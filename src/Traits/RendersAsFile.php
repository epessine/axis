<?php

namespace Axis\Traits;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Js;

trait RendersAsFile
{
    private string $includePath = '$PATH:/usr/local/bin:/opt/homebrew/bin';

    private string $nodeBinary = 'node';

    abstract private function prepareForScreenshot(): void;

    abstract private function getPackageName(): string;

    public function setNodeBinary(string $path): static
    {
        $this->nodeBinary = $path;

        return $this;
    }

    /**
     * @see https://pptr.dev/api/puppeteer.screenshotoptions
     *
     * @param  array<string, mixed>  $options
     */
    public function toPng(int $width, int $height, array $options = []): string
    {
        return $this->getImageContents('png', $width, $height, $options);
    }

    /**
     * @see https://pptr.dev/api/puppeteer.screenshotoptions
     *
     * @param  array<string, mixed>  $options  in pixels
     */
    public function toJpeg(int $width, int $height, array $options = []): string
    {
        return $this->getImageContents('jpeg', $width, $height, $options);
    }

    /**
     * @see https://pptr.dev/api/puppeteer.screenshotoptions
     *
     * @param  array<string, mixed>  $options
     */
    public function toWebp(int $width, int $height, array $options = []): string
    {
        return $this->getImageContents('webp', $width, $height, $options);
    }

    /**
     * @param  array<string, mixed>  $options
     */
    private function getImageContents(string $type, int $width, int $height, array $options): string
    {
        $script = "\"{$this->getScreenshotGenerationScript($type, $width, $height, $options)}\"";

        return $this->runScreenshotProcess($script);
    }

    private function runScreenshotProcess(string $script): string
    {
        $path = "PATH={$this->includePath}";

        $result = Process::run("$path {$this->nodeBinary} -e $script");

        if ($result->errorOutput() !== '') {
            throw new \Exception($result->errorOutput());
        }

        return base64_decode($result->output());
    }

    private function getChartPuppeteerRenderFunction(): string
    {
        $this->prepareForScreenshot();

        /** @var \Illuminate\Support\Stringable $script */
        $script = str($this->minify(<<<JS
            async () => {
                this.\$refs.container = document.querySelector('#chart');
                const boot = {$this->bootScript()};
                window.chart = boot();
            }
        JS));

        return $script->replace('this.$refs.container', 'window.chartContainer')->replace('"', '\'');
    }

    private function getFileRenderHtml(int $width, int $height): string
    {
        return <<<HTML
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            </head>
            <body>
                <{$this->getContainerElement()} id='chart' style='width: {$width}px; height: {$height}px;'>
                </{$this->getContainerElement()}>
            </body>
            </html>
        HTML;
    }

    /**
     * @param  array<string, mixed>  $options
     */
    private function getScreenshotGenerationScript(string $type, int $width, int $height, array $options): string
    {
        $renderFunction = $this->getChartPuppeteerRenderFunction();
        $pageContent = $this->getFileRenderHtml($width, $height);
        $screenshotOptions = Js::from([...$options, 'type' => $type]);

        return $this->minify(<<<JS
            (async () => {
                const puppeteer = require('puppeteer');
                const browser = await puppeteer.launch({ headless: true });
                try {
                    const page = await browser.newPage();
                    await page.setViewport({ width: $width, height: $height, deviceScaleFactor: 2 });
                    await page.setContent(\"$pageContent\");
                    await page.addScriptTag({ url: 'https://unpkg.com/{$this->getPackageName()}' }); 
                    await page.evaluate($renderFunction);
                    const element = await page.\\\$('#chart');
                    const buffer = await element.screenshot($screenshotOptions);
                    console.log(buffer.toString('base64'));
                } catch (e) {
                    console.error(e);
                } finally {
                    await browser.close();
                }
            })();
        JS);
    }
}

<?php

use Axis\Traits\ParsesJs;

beforeEach(function () {
    $this->class = new class
    {
        use ParsesJs {
            js as traitJs;
            minify as traitMinify;
        }

        public string $id = 'id';

        public function js(mixed $data): string
        {
            return $this->traitJs($data);
        }

        public function minify(string $data): string
        {
            return $this->traitMinify($data);
        }
    };
});

test('it should minify string', function () {
    $string = <<<'JS'
    const foo = 'bar';
    const bar = 'foo';

    if (foo !== bar) {
        console.log('foo is not bar');
    }
    JS;

    expect($this->class->minify($string))
        ->toBe("const foo = 'bar';const bar = 'foo';if (foo !== bar) {console.log('foo is not bar');}");
});

test('it should parse data into minified js', function () {
    $data = [
        'foo' => 'bar',
        'bar' => 'foo',
        'foobar' => 'barfoo',
    ];

    expect($this->class->js($data))
        ->toBe("JSON.parse('{\u0022foo\u0022:\u0022bar\u0022,\u0022bar\u0022:\u0022foo\u0022,\u0022foobar\u0022:\u0022barfoo\u0022}')");
});

test('it should replace $chart with proper object property', function () {
    $string = '$chart.destroy()';

    expect($this->class->minify($string))
        ->toBe('$axis[\'id\'].destroy()');
});

test('it should replace $container with proper alpine property', function () {
    $string = 'const container = $container';

    expect($this->class->minify($string))
        ->toBe('const container = this.$refs.container');
});

<?php

use Axis\Support\Script;

test('it should json serialize to md5 hash', function () {
    $script = Script::from('(e) => console.log(e)');
    $md5 = md5('(e) => console.log(e)');

    expect(json_encode($script))->toBe("\"$md5\"");
});

test('it should replace md5 for expression', function () {
    $script = Script::from('(e) => console.log(e)');
    $json = json_encode(['func' => $script]);

    expect($script->replace($json))->toBe('{"func":(e) => console.log(e)}');
});

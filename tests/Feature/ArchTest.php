<?php

test('should not use debug functions')
    ->expect(['dd', 'dump'])
    ->not->toBeUsed();

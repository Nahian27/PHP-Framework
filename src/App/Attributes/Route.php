<?php

namespace phpTest\src\App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(public string $path, public string|array $httpMethod = 'GET')
    {
    }
}
<?php

namespace phpTest\src\App\Attributes\ORM;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PrimaryKey
{
    public function __construct()
    {
    }
}
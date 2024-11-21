<?php

namespace phpTest\src\Models;

use phpTest\src\App\Attributes\ORM\Column;
use phpTest\src\App\Attributes\ORM\PrimaryKey;
use phpTest\src\App\Classes\BaseModel;

class Issue extends BaseModel
{
    #[Column]
    #[PrimaryKey]
    public string $id;

    #[Column]
    public string $title;

    #[Column]
    public string $description;

    #[Column]
    public string $type;

    #[Column]
    public string $status;

    #[Column]
    public string $created_at;

}
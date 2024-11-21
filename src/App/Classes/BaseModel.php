<?php

namespace phpTest\src\App\Classes;

use phpTest\src\App\Attributes\ORM\PrimaryKey;
use ReflectionClass;

class BaseModel
{
    private string $reflectionTable;
    private array $reflectionFields;
    private string $reflectionPrimary;

    public function __construct()
    {
        $reflection = new ReflectionClass($this);
        $this->reflectionTable = strtolower($reflection->getShortName());
        foreach ($reflection->getProperties() as $field) {
            if ($field->getAttributes(PrimaryKey::class)) {
                $this->reflectionPrimary = $field->name;
            }
            $this->reflectionFields[] = $field->name;
        }
    }

    public function getAll(): array
    {
        $arrStr = implode(', ', $this->reflectionFields);
        return DB::getInstance()->query('select ' . $arrStr . ' from ' . $this->reflectionTable);
    }

    public function get(string $primaryKey): array
    {
        $arrStr = implode(', ', $this->reflectionFields);
        return DB::getInstance()->query(
            'select ' . $arrStr . ' from ' . $this->reflectionTable . ' where ' . $this->reflectionPrimary . ' =? '
            ,
            $primaryKey
        );
    }
}
<?php

namespace App\Traits;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

trait EnumsHelperTrait
{
    use InvokableCases;
    use Names;
    use Values;
    use Options;

    public static function make($name): int
    {
        return self::{$name}();
    }

    public static function getNames(): array
    {
        return array_map('strtolower', self::names());
    }

    public static function asSelectArray(): array
    {
        $values = [];

        foreach (self::cases() as $value) {
            $values[$value->value] = $value->name;
        }

        return $values;
    }

    public static function fromName(string $name): string
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status->value;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum ".self::class);
    }

    public static function tryFromName(string $name): ?string
    {
        try {
            return self::fromName($name);
        } catch (\ValueError $error) {
            return null;
        }
    }

    public static function fromIndex(int $index): ?string
    {
        $array = self::asSelectArray();

        return $array[$index];
    }

    public static function asJson(): string
    {
        return json_encode(self::asSelectArray(), JSON_THROW_ON_ERROR);
    }
}

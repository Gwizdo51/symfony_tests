<?php declare(strict_types=1);

namespace App\Enum;

use ValueError;

trait QueriableEnumTrait {
    public static function fromName($name): static {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        throw new ValueError('The requested name was not found in the cases');
    }

    public static function valueFromName($name): string {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case->value;
            }
        }
        throw new ValueError('The requested name was not found in the cases');
    }
}

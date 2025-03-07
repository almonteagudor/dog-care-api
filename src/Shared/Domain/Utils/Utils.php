<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Utils;

final readonly class Utils
{
    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower(
            preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text),
        );
    }
}

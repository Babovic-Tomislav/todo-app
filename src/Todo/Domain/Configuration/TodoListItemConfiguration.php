<?php

namespace Todo\Domain\Configuration;

class TodoListItemConfiguration
{
    public const MIN_DESCRIPTION_LENGTH = 1;
    public const MAX_DESCRIPTION_LENGTH = 255;

    private static int $minDescriptionLength = self::MIN_DESCRIPTION_LENGTH;
    private static int $maxDescriptionLength = self::MAX_DESCRIPTION_LENGTH;

    public static function setMinDescriptionLength(int $length): void
    {
        self::$minDescriptionLength = $length;
    }

    public static function getMinDescriptionLength(): int
    {
        return self::$minDescriptionLength;
    }

    public static function setMaxDescriptionLength(int $length): void
    {
        self::$maxDescriptionLength = $length;
    }

    public static function getMaxDescriptionLength(): int
    {
        return self::$maxDescriptionLength;
    }
}

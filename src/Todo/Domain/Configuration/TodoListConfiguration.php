<?php

namespace Todo\Domain\Configuration;

class TodoListConfiguration
{
    public const DEFAULT_NAME_MINIMUM_LENGTH = 3;
    public const DEFAULT_NAME_MAXIMUM_LENGTH = 100;
    public const DEFAULT_DESCRIPTION_MINIMUM_LENGTH = 0;
    public const DEFAULT_DESCRIPTION_MAXIMUM_LENGTH = 255;

    private static int $minimumNameLength = self::DEFAULT_NAME_MINIMUM_LENGTH;
    private static int $maximumNameLength = self::DEFAULT_NAME_MAXIMUM_LENGTH;
    private static int $minimumDescriptionLength = self::DEFAULT_DESCRIPTION_MINIMUM_LENGTH;
    private static int $maximumDescriptionLength = self::DEFAULT_DESCRIPTION_MAXIMUM_LENGTH;

    public static function setMinimumNameLength(int $minimumNameLength): void
    {
        self::$minimumNameLength = $minimumNameLength;
    }

    public static function setMaximumNameLength(int $maximumNameLength): void
    {
        self::$maximumNameLength = $maximumNameLength;
    }

    public static function minimumNameLength(): int
    {
        return self::$minimumNameLength;
    }

    public static function maximumNameLength(): int
    {
        return self::$maximumNameLength;
    }

    public static function setMinimumDescriptionLength(int $minimumDescriptionLength): void
    {
        self::$minimumDescriptionLength = $minimumDescriptionLength;
    }

    public static function setMaximumDescriptionLength(int $maximumDescriptionLength): void
    {
        self::$maximumDescriptionLength = $maximumDescriptionLength;
    }

    public static function minimumDescriptionLength(): int
    {
        return self::$minimumDescriptionLength;
    }

    public static function maximumDescriptionLength(): int
    {
        return self::$maximumDescriptionLength;
    }
}

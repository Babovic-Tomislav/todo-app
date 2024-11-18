<?php

namespace User\Domain\Configuration;

class UserConfiguration
{
    public const DEFAULT_PASSWORD_MINIMUM_LENGTH = 8;
    public const DEFAULT_PASSWORD_MAXIMUM_LENGTH = 20;
    public const DEFAULT_USERNAME_MINIMUM_LENGTH = 2;
    public const DEFAULT_USERNAME_MAXIMUM_LENGTH = 20;
    public const DEFAULT_NAME_MINIMUM_LENGTH = 2;
    public const DEFAULT_NAME_MAXIMUM_LENGTH = 255;
    public const DEFAULT_LASTNAME_MINIMUM_LENGTH = 2;
    public const DEFAULT_LASTNAME_MAXIMUM_LENGTH = 255;

    private static int $minimumPasswordLength = self::DEFAULT_PASSWORD_MINIMUM_LENGTH;
    private static int $maximumPasswordLength = self::DEFAULT_PASSWORD_MAXIMUM_LENGTH;
    private static int $minimumUsernameLength = self::DEFAULT_USERNAME_MINIMUM_LENGTH;
    private static int $maximumUsernameLength = self::DEFAULT_USERNAME_MAXIMUM_LENGTH;
    private static int $minimumNameLength = self::DEFAULT_NAME_MINIMUM_LENGTH;
    private static int $maximumNameLength = self::DEFAULT_NAME_MAXIMUM_LENGTH;
    private static int $minimumLastnameLength = self::DEFAULT_LASTNAME_MINIMUM_LENGTH;
    private static int $maximumLastnameLength = self::DEFAULT_LASTNAME_MAXIMUM_LENGTH;

    public static function setMinimumPasswordLength(int $length): void
    {
        self::$minimumPasswordLength = $length;
    }

    public static function getMinimumPasswordLength(): int
    {
        return self::$minimumPasswordLength;
    }

    public static function setMaximumPasswordLength(int $length): void
    {
        self::$maximumPasswordLength = $length;
    }

    public static function getMaximumPasswordLength(): int
    {
        return self::$maximumPasswordLength;
    }

    public static function setMinimumUsernameLength(int $length): void
    {
        self::$minimumUsernameLength = $length;
    }

    public static function getMinimumUsernameLength(): int
    {
        return self::$minimumUsernameLength;
    }

    public static function setMaximumUsernameLength(int $length): void
    {
        self::$maximumUsernameLength = $length;
    }

    public static function getMaximumUsernameLength(): int
    {
        return self::$maximumUsernameLength;
    }

    public static function setMinimumNameLength(int $length): void
    {
        self::$minimumNameLength = $length;
    }

    public static function getMinimumNameLength(): int
    {
        return self::$minimumNameLength;
    }

    public static function setMaximumNameLength(int $length): void
    {
        self::$maximumNameLength = $length;
    }

    public static function getMaximumNameLength(): int
    {
        return self::$maximumNameLength;
    }

    public static function setMinimumLastnameLength(int $length): void
    {
        self::$minimumLastnameLength = $length;
    }

    public static function getMinimumLastnameLength(): int
    {
        return self::$minimumLastnameLength;
    }

    public static function setMaximumLastnameLength(int $length): void
    {
        self::$maximumLastnameLength = $length;
    }

    public static function getMaximumLastnameLength(): int
    {
        return self::$maximumLastnameLength;
    }
}

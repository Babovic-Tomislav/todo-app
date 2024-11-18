<?php

namespace User\Domain\Configuration;

interface UserConfigurationInterface
{
    public function getPasswordLength(): int;

    public function getUsernameLength(): int;

    public function getNameLength(): int;

    public function getLastnameLength(): int;

    public function getEmailLength(): int;
}

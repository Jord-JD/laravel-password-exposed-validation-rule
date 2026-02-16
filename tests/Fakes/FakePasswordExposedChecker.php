<?php

namespace Tests\Fakes;

use JordJD\PasswordExposed\Enums\PasswordStatus;
use JordJD\PasswordExposed\Interfaces\PasswordExposedCheckerInterface;

class FakePasswordExposedChecker implements PasswordExposedCheckerInterface
{
    /**
     * @var array<string, string>
     */
    private $passwordStatuses;

    /**
     * @param array<string, string> $passwordStatuses
     */
    public function __construct(array $passwordStatuses = [])
    {
        $this->passwordStatuses = $passwordStatuses;
    }

    /**
     * {@inheritdoc}
     */
    public function passwordExposed(string $password): string
    {
        if (array_key_exists($password, $this->passwordStatuses)) {
            return $this->passwordStatuses[$password];
        }

        return PasswordStatus::NOT_EXPOSED;
    }

    /**
     * {@inheritdoc}
     */
    public function passwordExposedByHash(string $hash): string
    {
        return PasswordStatus::UNKNOWN;
    }

    /**
     * {@inheritdoc}
     */
    public function isExposed(string $password): ?bool
    {
        $passwordStatus = $this->passwordExposed($password);

        if ($passwordStatus === PasswordStatus::UNKNOWN) {
            return null;
        }

        return $passwordStatus === PasswordStatus::EXPOSED;
    }

    /**
     * {@inheritdoc}
     */
    public function isExposedByHash(string $hash): ?bool
    {
        return null;
    }
}

<?php

namespace JordJD\LaravelPasswordExposedValidationRule;

use JordJD\LaravelPasswordExposedValidationRule\Factories\PasswordExposedCheckerFactory;
use JordJD\PasswordExposed\Enums\PasswordStatus;
use JordJD\PasswordExposed\PasswordExposedChecker;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class PasswordExposed.
 */
class PasswordExposed implements Rule
{
    /**
     * @var PasswordExposedChecker
     */
    private $passwordExposedChecker;
    /**
     * @var string
     */
    private $message = 'The :attribute has been exposed in a data breach.';

    /**
     * PasswordExposed constructor.
     *
     * @param PasswordExposedChecker|null $passwordExposedChecker
     */
    public function __construct(PasswordExposedChecker $passwordExposedChecker = null)
    {
        if (!$passwordExposedChecker) {
            $factory = new PasswordExposedCheckerFactory();
            $passwordExposedChecker = $factory->instance();
        }

        $this->passwordExposedChecker = $passwordExposedChecker;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passwordStatus = $this->passwordExposedChecker->passwordExposed($value);

        return $passwordStatus !== PasswordStatus::EXPOSED;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * Set a custom validation error message.
     *
     * @param string $customMessage
     *
     * @return \JordJD\LaravelPasswordExposedValidationRule\PasswordExposed
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}

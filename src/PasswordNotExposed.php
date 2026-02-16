<?php

namespace JordJD\LaravelPasswordExposedValidationRule;

use Illuminate\Contracts\Validation\Rule;
use InvalidArgumentException;
use JordJD\LaravelPasswordExposedValidationRule\Factories\PasswordExposedCheckerFactory;
use JordJD\PasswordExposed\Enums\PasswordStatus;
use JordJD\PasswordExposed\Interfaces\PasswordExposedCheckerInterface;

/**
 * Class PasswordNotExposed.
 */
class PasswordNotExposed implements Rule
{
    /**
     * @var callable|null
     */
    private static $passwordExposedCheckerResolver;

    /**
     * @var PasswordExposedCheckerInterface
     */
    private $passwordExposedChecker;

    /**
     * @var string
     */
    private $message = 'The :attribute has been exposed in a data breach.';

    /**
     * PasswordNotExposed constructor.
     *
     * @param PasswordExposedCheckerInterface|null $passwordExposedChecker
     */
    public function __construct(PasswordExposedCheckerInterface $passwordExposedChecker = null)
    {
        $this->passwordExposedChecker = $passwordExposedChecker ?: $this->createPasswordExposedChecker();
    }

    /**
     * Allow tests to provide a custom checker resolver.
     *
     * @param callable $passwordExposedCheckerResolver
     */
    public static function resolvePasswordExposedCheckerUsing(callable $passwordExposedCheckerResolver): void
    {
        self::$passwordExposedCheckerResolver = $passwordExposedCheckerResolver;
    }

    /**
     * Reset the custom checker resolver.
     */
    public static function clearResolvedPasswordExposedChecker(): void
    {
        self::$passwordExposedCheckerResolver = null;
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
        $passwordStatus = $this->passwordExposedChecker->passwordExposed((string) $value);

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
     * @param string $message
     *
     * @return \JordJD\LaravelPasswordExposedValidationRule\PasswordNotExposed
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return PasswordExposedCheckerInterface
     */
    private function createPasswordExposedChecker(): PasswordExposedCheckerInterface
    {
        if (self::$passwordExposedCheckerResolver !== null) {
            $passwordExposedChecker = call_user_func(self::$passwordExposedCheckerResolver);

            if (!$passwordExposedChecker instanceof PasswordExposedCheckerInterface) {
                throw new InvalidArgumentException(
                    'The password exposed checker resolver must return a PasswordExposedCheckerInterface instance.'
                );
            }

            return $passwordExposedChecker;
        }

        $factory = new PasswordExposedCheckerFactory();

        return $factory->instance();
    }
}

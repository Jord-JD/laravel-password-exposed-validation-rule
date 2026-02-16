<?php

namespace Tests\Unit;

use InvalidArgumentException;
use JordJD\LaravelPasswordExposedValidationRule\PasswordExposed;
use JordJD\LaravelPasswordExposedValidationRule\PasswordNotExposed;
use JordJD\PasswordExposed\Enums\PasswordStatus;
use PHPUnit\Framework\TestCase;
use Tests\Fakes\FakePasswordExposedChecker;

class PasswordNotExposedTest extends TestCase
{
    protected function tearDown(): void
    {
        PasswordNotExposed::clearResolvedPasswordExposedChecker();

        parent::tearDown();
    }

    /** @test */
    public function defaultMessageIsReturned()
    {
        $rule = new PasswordNotExposed(new FakePasswordExposedChecker());

        $this->assertSame('The :attribute has been exposed in a data breach.', $rule->message());
    }

    /** @test */
    public function customMessageCanBeSet()
    {
        $customMessage = 'Custom message';
        $rule = new PasswordNotExposed(new FakePasswordExposedChecker());

        $this->assertSame($customMessage, $rule->setMessage($customMessage)->message());
    }

    /** @test */
    public function passwordFailsValidation()
    {
        $rule = new PasswordNotExposed(
            new FakePasswordExposedChecker([
                'password' => PasswordStatus::EXPOSED,
            ])
        );

        $this->assertFalse($rule->passes('password', 'password'));
    }

    /** @test */
    public function passwordPassesValidation()
    {
        $rule = new PasswordNotExposed(
            new FakePasswordExposedChecker([
                'password' => PasswordStatus::NOT_EXPOSED,
            ])
        );

        $this->assertTrue($rule->passes('password', 'password'));
    }

    /** @test */
    public function customCheckerResolverCanBeUsedForTesting()
    {
        PasswordNotExposed::resolvePasswordExposedCheckerUsing(
            function (): FakePasswordExposedChecker {
                return new FakePasswordExposedChecker([
                    'password' => PasswordStatus::EXPOSED,
                ]);
            }
        );

        $rule = new PasswordNotExposed();

        $this->assertFalse($rule->passes('password', 'password'));
    }

    /** @test */
    public function customCheckerResolverMustReturnAValidChecker()
    {
        $this->expectException(InvalidArgumentException::class);

        PasswordNotExposed::resolvePasswordExposedCheckerUsing(
            function (): object {
                return new \stdClass();
            }
        );

        new PasswordNotExposed();
    }

    /** @test */
    public function legacyPasswordExposedRuleRemainsSupported()
    {
        $rule = new PasswordExposed(
            new FakePasswordExposedChecker([
                'password' => PasswordStatus::EXPOSED,
            ])
        );

        $this->assertFalse($rule->passes('password', 'password'));
    }
}

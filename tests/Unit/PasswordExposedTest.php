<?php

namespace Tests\Unit;

use JordJD\LaravelPasswordExposedValidationRule\PasswordExposed;
use PHPUnit\Framework\TestCase;

class PasswordExposedTest extends TestCase
{
    public function setUp(): void
    {
        $this->passwordExposed = new PasswordExposed();
    }

    /** @test */
    public function defaultMessageIsReturned()
    {
        $message = $this->passwordExposed->message();
        $this->assertEquals('The :attribute has been exposed in a data breach.', $message);
    }

    /** @test */
    public function customMessageCanBeSet()
    {
        $customMessage = 'Custom message';
        $passwordExposedObject = $this->passwordExposed->setMessage($customMessage);
        $setMessage = $passwordExposedObject->message();
        $this->assertEquals($customMessage, $setMessage);
    }

    /** @test */
    public function passwordFailsValidation()
    {
        $password = 'password';
        $passed = $this->passwordExposed->passes('password', $password);
        $this->assertFalse($passed);
    }

    /** @test */
    public function passwordPassesValidation()
    {
        $password = uniqid();
        $passed = $this->passwordExposed->passes('password', $password);
        $this->assertTrue($passed);
    }
}

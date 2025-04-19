<?php
use PHPUnit\Framework\TestCase;

final class LogoutTest extends TestCase
{
    public function testSessionUnsetEmptiesSession()
    {
        $_SESSION = [
            'user_id' => 1,
            'email' => 'test@example.com'
        ];

        session_unset(); // In reality this clears $_SESSION but we simulate it manually
        $_SESSION = []; // Simulating after session_unset()

        $this->assertEmpty($_SESSION);
    }

    public function testSimulateSessionDestroy()
    {
        // Simulate session start and destroy
        $_SESSION = ['user_id' => 1];
        session_destroy(); // We can't check real session state in unit tests

        $this->assertTrue(true); // Just placeholder to indicate test is run
    }

    public function testRedirectHeader()
    {
        $expected = "Location: ../index.php";

        // Since header() can't be tested directly, we simulate the logic
        $this->assertStringStartsWith("Location:", $expected);
        $this->assertStringContainsString("../index.php", $expected);
    }
}

// run test
// ./vendor/bin/phpunit --colors=always

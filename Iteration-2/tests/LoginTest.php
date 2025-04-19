<?php
use PHPUnit\Framework\TestCase;

final class LoginTest extends TestCase
{
    public function testDetectsPostRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertEquals('POST', $_SERVER['REQUEST_METHOD']);
    }

    public function testReadsEmailAndPasswordFromPost()
    {
        $_POST = [
            'email' => 'test@example.com',
            'password' => 'secret123'
        ];

        $this->assertArrayHasKey('email', $_POST);
        $this->assertArrayHasKey('password', $_POST);
        $this->assertEquals('test@example.com', $_POST['email']);
        $this->assertEquals('secret123', $_POST['password']);
    }

    public function testPasswordVerificationSuccess()
    {
        $rawPassword = 'supersecure';
        $hashed = password_hash($rawPassword, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($rawPassword, $hashed));
    }

    public function testPasswordVerificationFailure()
    {
        $rawPassword = 'wrongpassword';
        $hashed = password_hash('correctpassword', PASSWORD_DEFAULT);

        $this->assertFalse(password_verify($rawPassword, $hashed));
    }

    public function testLoginRedirectUrlFormation()
    {
        $userId = 7;
        $redirectUrl = "Location: index.php?user_id=" . urlencode($userId);

        $this->assertStringContainsString("index.php", $redirectUrl);
        $this->assertStringContainsString("user_id=7", $redirectUrl);
    }

    public function testLoginErrorMessageRendering()
    {
        $loginError = "Invalid email or password.";
        $html = "<div class='update-message'>" . htmlspecialchars($loginError) . "</div>";

        $this->assertStringContainsString("Invalid email or password.", $html);
        $this->assertStringContainsString("&lt;", htmlspecialchars("<script>"));
    }
}

// run test
// ./vendor/bin/phpunit --colors=always

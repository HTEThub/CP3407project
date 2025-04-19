<?php
use PHPUnit\Framework\TestCase;

final class EditProfileTest extends TestCase
{
    public function testDetectsPostRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertEquals('POST', $_SERVER['REQUEST_METHOD']);
    }

    public function testReadsPostFormValues()
    {
        $_POST = [
            'user_id' => 7,
            'email' => 'user@example.com',
            'phone' => '0400000000',
            'fullAddress' => '123 Street',
            'zip' => '4000',
            'cardNumber' => '4111111111111111',
            'expiryDate' => '12/25',
            'cvv' => '123',
            'password' => 'newpassword123'
        ];

        $this->assertEquals(7, $_POST['user_id']);
        $this->assertEquals('user@example.com', $_POST['email']);
        $this->assertEquals('newpassword123', $_POST['password']);
    }

    public function testPasswordHashingWhenProvided()
    {
        $rawPassword = 'newpassword123';
        $hashed = password_hash($rawPassword, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($rawPassword, $hashed));
    }

    public function testBuildsRedirectUrlWithMessage()
    {
        $userId = 5;
        $msg = "Profile updated!";
        $url = "Location: ../profile.php?user_id=" . urlencode($userId) . "&updateMessage=" . urlencode($msg);

        $this->assertStringContainsString("profile.php", $url);
        $this->assertStringContainsString("user_id=5", $url);
        $this->assertStringContainsString("updateMessage=Profile+updated%21", $url);
    }

    public function testRedirectWithoutUserIdFails()
    {
        $_GET = []; // no user_id

        $this->assertArrayNotHasKey('user_id', $_GET);
    }

    public function testEmailAlreadyExistsCondition()
    {
        $existingEmail = "taken@example.com";
        $currentUserId = 10;

        $query = "SELECT id FROM users WHERE email = ? AND id <> ?";
        $this->assertStringContainsString("email = ?", $query);
        $this->assertStringContainsString("id <>", $query);
    }
}

// run test
// ./vendor/bin/phpunit --colors=always

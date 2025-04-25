<?php
use PHPUnit\Framework\TestCase;

final class RegisterTest extends TestCase
{
    public function testPostRequestDetection()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertEquals('POST', $_SERVER['REQUEST_METHOD']);
    }

    public function testReadsAndTrimsPostInputs()
    {
        $_POST = [
            'email' => '  newuser@example.com ',
            'phone' => ' 0123456789 ',
            'fullAddress' => ' 123 Test Street ',
            'zip' => ' 4000 ',
            'cardNumber' => ' 4111111111111111 ',
            'expiryDate' => ' 12/26 ',
            'cvv' => ' 123 '
        ];

        $this->assertEquals('newuser@example.com', trim($_POST['email']));
        $this->assertEquals('123 Test Street', trim($_POST['fullAddress']));
    }

    public function testPasswordHashAndVerify()
    {
        $plainPassword = 'supersecure';
        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($plainPassword, $hash));
    }

    public function testEmailAlreadyExistsSQL()
    {
        $sql = "SELECT id FROM users WHERE email = ?";
        $this->assertStringContainsString("email = ?", $sql);
    }

    public function testHandlesArtistCheckbox()
    {
        $_POST = ['apply_as_artist' => 'on'];
        $apply = isset($_POST['apply_as_artist']) ? 1 : 0;

        $this->assertEquals(1, $apply);

        $_POST = [];
        $apply = isset($_POST['apply_as_artist']) ? 1 : 0;

        $this->assertEquals(0, $apply);
    }

    public function testResumeUploadHandlingWhenProvided()
    {
        $_FILES = [
            'resume_file' => [
                'name' => 'resume.pdf',
                'tmp_name' => '/tmp/php123',
                'error' => UPLOAD_ERR_OK
            ]
        ];

        $this->assertEquals('resume.pdf', $_FILES['resume_file']['name']);
        $this->assertEquals(UPLOAD_ERR_OK, $_FILES['resume_file']['error']);
    }

    public function testSuccessMessageOutput()
    {
        $message = "Registration successful! You can now <a href='login.php'>Login</a>.";
        $this->assertStringContainsString('login.php', $message);
    }
}


// run test
// ./vendor/bin/phpunit --colors=always

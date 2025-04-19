<?php
use PHPUnit\Framework\TestCase;

final class ProfileTest extends TestCase
{
    public function testSessionUpdatedFromGet()
    {
        $_GET = ['user_id' => '15'];
        $_SESSION = [];

        if (isset($_GET['user_id'])) {
            $_SESSION['user_id'] = intval($_GET['user_id']);
        }

        $this->assertArrayHasKey('user_id', $_SESSION);
        $this->assertEquals(15, $_SESSION['user_id']);
    }

    public function testLoggedInCheck()
    {
        $_SESSION = [];
        $this->assertFalse(isset($_SESSION['user_id']));

        $_SESSION['user_id'] = 3;
        $this->assertTrue(isset($_SESSION['user_id']));
    }

    public function testArtistConversionToBoolean()
    {
        $dbValue = 1;
        $isArtist = ($dbValue == 1);
        $this->assertTrue($isArtist);

        $dbValue = 0;
        $isArtist = ($dbValue == 1);
        $this->assertFalse($isArtist);
    }

    public function testUpdateMessageInGet()
    {
        $_GET = ['updateMessage' => 'Profile updated!'];
        $message = '';

        if (isset($_GET['updateMessage'])) {
            $message = $_GET['updateMessage'];
        }

        $this->assertEquals('Profile updated!', $message);
    }

    public function testHtmlEscapingForSecurity()
    {
        $raw = "<script>alert('XSS');</script>";
        $escaped = htmlspecialchars($raw);
        $this->assertEquals("&lt;script&gt;alert(&#039;XSS&#039;);&lt;/script&gt;", $escaped);
    }

}

// test code
// ./vendor/bin/phpunit 

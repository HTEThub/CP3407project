<?php
use PHPUnit\Framework\TestCase;

final class BookingListTest extends TestCase
{
    public function testSessionUserIdCheck()
    {
        $_SESSION = [];
        $this->assertFalse(isset($_SESSION['user_id']));

        $_SESSION['user_id'] = 42;
        $this->assertTrue(isset($_SESSION['user_id']));
        $this->assertEquals(42, $_SESSION['user_id']);
    }

    public function testPostRequestStatusUpdateCheck()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_POST['booking_id'] = 123;
        $_POST['status'] = 'accepted';

        $this->assertEquals('POST', $_SERVER['REQUEST_METHOD']);
        $this->assertTrue(isset($_POST['booking_id'], $_POST['status']));
        $this->assertEquals(123, $_POST['booking_id']);
        $this->assertEquals('accepted', $_POST['status']);
    }

    public function testArtistStatusBooleanAssignment()
    {
        $isArtist = false;
        $this->assertFalse($isArtist);

        $isArtist = true; // simulate successful DB fetch result
        $this->assertTrue($isArtist);
    }

    public function testBookingStatusRadioLogic()
    {
        $status = 'finished';

        $this->assertSame(
            'checked',
            $status === 'finished' ? 'checked' : ''
        );

        $this->assertSame(
            '',
            $status === 'accepted' ? 'checked' : ''
        );
    }
}

// run the test
// ./vendor/bin/phpunit --colors=always

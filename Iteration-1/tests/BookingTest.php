<?php
use PHPUnit\Framework\TestCase;

final class BookingTest extends TestCase
{
    public function testAppointmentDatetimeFormat()
    {
        $date = "2025-04-22";
        $time = "13:45";
        $expected = "2025-04-22 13:45:00";

        $this->assertEquals($expected, $date . ' ' . $time . ':00');
    }

    public function testConnectionFailureReal()
    {
        try {
            new mysqli("invalid_host", "root", "wrongpass", "Beauty_Saloon");
            $this->fail("Expected mysqli_sql_exception not thrown.");
        } catch (mysqli_sql_exception $e) {
            $this->assertStringContainsString("getaddrinfo", $e->getMessage());
        }
    }


    public function testPostMethodCheck()
    {
        $_SERVER['REQUEST_METHOD'] = "POST";
        $this->assertEquals("POST", $_SERVER['REQUEST_METHOD']);
    }

    public function testSessionUserIdExists()
    {
        $_SESSION = []; // reset session
        $_SESSION['user_id'] = 10;

        $this->assertTrue(isset($_SESSION['user_id']));
        $this->assertEquals(10, $_SESSION['user_id']);
    }
}

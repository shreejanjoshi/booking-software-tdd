<?php

namespace App\Tests;
use App\Entity\Bookings;
use App\Entity\User;
use App\Entity\Room;
use DateTime;

use Monolog\Test\TestCase;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints\Date;

class CheckRoomAvailabilityTest extends TestCase
{
    private function dataProviderForPremiumRoom(): array
    {
        return [
            [true, true, true],
            [false, false, true],
            [false, true, true],
            [true, false, false]
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForIsAvailable
     */
    public function testIsAvailable(DateTime $Startdate, DateTime $Enddate, bool $expectedOutput): void
    {
        $booking = new Bookings();
        $this->assertEquals($expectedOutput, $booking->checkAvailability($Startdate, $Enddate));
    }
}
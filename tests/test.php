<?php

namespace App\Tests;
use App\Entity\Bookings;
use App\Entity\NewUser;
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
     * @dataProvider dataProviderForPremiumRoom
     */
    public function testPremiumRoom(bool $roomVar, bool $userVar, bool $expectedOutput): void
    {

        $room = new Room($roomVar);
        $user = new NewUser($userVar);
        $this->assertEquals($expectedOutput, $room->canBook($user));
    }

    private function dataProviderForbookings(): array
    {
        return [
            [new DateTime("2020-01-12 05:12:30"), new DateTime("2020-01-12 05:40:30"), true],
            [new DateTime("2020-01-12 05:12:30"), new DateTime("2020-01-12 10:12:30"), false],
            [new DateTime("2020-01-12 06:12:30"), new DateTime("2020-01-12 10:12:30"), true],
            [new DateTime("2020-01-12 05:12:30"), new DateTime("2020-01-12 10:11:30"), false],


        ];
    }
    /**
     * function has to start with Test
     * @dataProvider dataProviderForbookings
     */
    public function testBookings(DateTime $Startdate, DateTime $Enddate,bool $expectedOutput): void
    {
        $bookings = new Bookings();
        $this->assertEquals($expectedOutput, $bookings->canBook($Startdate, $Enddate));

    }
    public function dataProviderCanAfford(): array
    {
        return [
            [new NewUser(), 100 , 3 , true],
            [new NewUser(),50,4, false],
            [new NewUser(),150,3, true],
            [new NewUser(),20,5,false]
        ];
    }
    /**
     * function has to start with Test
     * @dataProvider dataProviderCanAfford
     */
    public function canAfford(NewUser $user, int $credit, int $bookings, bool $expectedOutput): void
    {
        $user = new NewUser();
        $user->setCredit();
        $this->assertEquals($expectedOutput, $user->canAfford($user, $bookings));

    }
    function dataProviderForIsAvailable(): array
    {
        return [
            [new DateTime("2018-01-10 12:00:45"), new DateTime("2018-01-10 14:00:45"), [
                ['Startdate' => new DateTime("2018-01-10 02:00:45"), 'Enddate' => new DateTime("2018-01-10 06:00:45")],
                ['Startdate' => new DateTime("2018-01-10 12:00:45"), 'Enddate' => new DateTime("2018-01-10 13:00:45")],
                ['Startdate' => new DateTime("2018-01-10 14:00:45"), 'Enddate' => new DateTime("2018-01-10 16:00:45")],
            ], false],
            [new DateTime("2018-01-10 12:00:45"), new DateTime("2018-01-10 14:00:45"), [
                ['Startdate' => new DateTime("2018-01-10 08:00:45"), 'Enddate' => new DateTime("2018-01-10 12:00:45")],
                ['Startdate' => new DateTime("2018-01-10 08:00:45"), 'Enddate' => new DateTime("2018-01-10 10:00:45")],
                ['Startdate' => new DateTime("2018-01-10 14:00:45"), 'Enddate' => new DateTime("2018-01-10 19:00:45")],
            ], true],
            [new DateTime("2018-01-10 15:00:45"), new DateTime("2018-01-10 19:00:45"), [
                ['Startdate' => new DateTime("2018-01-10 12:00:45"), 'Enddate' => new DateTime("2018-01-10 15:00:45")],
                ['Startdate' => new DateTime("2018-01-10 11:00:45"), 'Enddate' => new DateTime("2018-01-10 12:00:45")],
                ['Startdate' => new DateTime("2018-01-10 11:00:45"), 'Enddate' => new DateTime("2018-01-10 14:00:45")],
            ], true],
            [new DateTime("2018-01-10 10:00:45"), new DateTime("2018-01-10 14:00:45"), [
                ['Startdate' => new DateTime("2018-01-10 02:00:45"), 'Enddate' => new DateTime("2018-01-10 02:00:45")],
                ['Startdate' => new DateTime("2018-01-10 02:00:45"), 'Enddate' => new DateTime("2018-01-10 02:00:45")],
                ['Startdate' => new DateTime("2018-01-10 12:00:45"), 'Enddate' => new DateTime("2018-01-10 13:00:45")],
            ], false],
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
<?php
    require 'app/services/Timetable.php';

    class ClassName extends PHPUnit_Framework_TestCase {
        function testArrayHours() {
            $hours = Timetable::hours();

            $this->assertEquals($hours["07"], "07");
            $this->assertEquals($hours["08"], "08");
            $this->assertEquals($hours["09"], "09");
            $this->assertEquals($hours["10"], "10");
            $this->assertEquals($hours["11"], "11");
            $this->assertEquals($hours["12"], "12");
            $this->assertEquals($hours["13"], "13");
            $this->assertEquals($hours["14"], "14");
            $this->assertEquals($hours["15"], "15");
        }

        function testArrayWeekDays() {
            $weekDays = Timetable::weekDays();

            $this->assertEquals($weekDays[1], "Sunday");
            $this->assertEquals($weekDays[2], "Monday");
            $this->assertEquals($weekDays[3], "Tuesday");
            $this->assertEquals($weekDays[4], "Wednesday");
            $this->assertEquals($weekDays[5], "Thursday");
            $this->assertEquals($weekDays[6], "Friday");
            $this->assertEquals($weekDays[7], "Saturday");
        }

        function testArrayMinutes() {
            $minutes = Timetable::minutes();

            $this->assertEquals(sizeof($minutes), 12);

            $this->assertEquals($minutes["00"], "00");
            $this->assertEquals($minutes["05"], "05");
            $this->assertEquals($minutes["10"], "10");
            $this->assertEquals($minutes["15"], "15");
            $this->assertEquals($minutes["20"], "20");
            $this->assertEquals($minutes["25"], "25");
            $this->assertEquals($minutes["30"], "30");
            $this->assertEquals($minutes["35"], "35");
            $this->assertEquals($minutes["40"], "40");
            $this->assertEquals($minutes["45"], "45");
            $this->assertEquals($minutes["50"], "50");
            $this->assertEquals($minutes["55"], "55");
        }
    }
?>
<?php

class OnCall
{
//
// class variables
//

// list of names for days and months
   private $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
   private $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

// number of days in each month
   private $totalDays = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

// variables to hold current month, day and year
    private $currYear;
    private $currMonth;
    private $currDay;
    private $dbcnx;

//
// class methods
//

// constructor
    public function __construct($year, $month, $prev, $dbcnx)
    {
// current values
        $this->dbcnx = $dbcnx;
        if ($prev > 0) {
            $pmonth = $prev % 12;
            $pyear = floor($prev / 12);
            $month = $month + $pmonth;
            $year = $year + $pyear;
        }

        if ($prev < 0) {
            $prev = $prev * -1;
            $pmonth = $prev % 12;
            $pyear = floor($prev / 12);
            $month = $month - $pmonth;
            $year = $year - $pyear;
        }

        if ($month < 1) {
            $month = $month + 12;
            $year = $year - 1;
        }

        if ($month > 12) {
            $month = $month - 12;
            $year = $year + 1;
        }


        /*           $month = $month - $prev;
        if ($month < 1) {
        $month = $month + 12;
        $year = $year - 1;
        }    */

        $this->currMonth = $month;
        $this->currYear = $year;
        $this->currDay = date("j");

// if leap year, modify $totalDays array appropriately
        if (date("L", mktime(0, 0, 0, $this->currMonth, 1, $this->currYear))) {
            $this->totalDays[2] = 29;
        }

    }

// this prints the HTML code to display the calendar
    function viewIt($type, $display, $prev)
    {
        $S = "      ";
        $rowCount = 0;
// find out which day the first of the month falls on
        $firstDayOfMonth = date("w", mktime(0, 0, 0, $this->currMonth, 1, $this->currYear)) - 1;
        if ($firstDayOfMonth < 0) {
            $firstDayOfMonth = 6;
        }
// start printing table
        echo "\n    <table border=0 cellpadding=2 cellspacing=5>\n";

        // header
        echo "$S<tr>\n";
        echo "<td colspan=7 align=center><font face=Arial size=-1><b>" .
            $this->months[$this->currMonth] . " " . $this->currYear . "</b></font></td>\n";
        echo "</tr>\n";

        // day names
        echo "<tr>\n";
        for ($x = 0; $x < 7; $x++) {
            echo "<td><font face=Arial size=-2>" . substr($this->days[$x], 0, 3) . "</font></td>\n";
        }
        echo "</tr>\n";

        // start printing dates
        echo "<tr>\n";

        // display blank spaces until the first day of the month
        for ($x = 1; $x <= $firstDayOfMonth; $x++) {
            // this comes in handy to find the end of each 7-day block
            $rowCount++;
            echo "<td><font face=Arial size=-2>&nbsp;</font></td>\n";
        }

        // counter to track the current date
        $dayCount = 1;
        while ($dayCount <= $this->totalDays[$this->currMonth]) {
            // use this to find out when the 7-day block is complete and display a new row
            if ($rowCount % 7 == 0) {
                echo "</tr>\n<tr>\n";
            }

            $result = mysqli_query($this->dbcnx, "SELECT NAME FROM $type where MONTH = $this->currMonth AND DAY = $dayCount AND YEAR = $this->currYear");
            if (!$result) {
                echo("<P>Error performing query: " . mysqli_error($this->dbcnx) . "</P>");
                exit();
            }
            $row = mysqli_fetch_array($result);

            $name = $row["NAME"];


            $result = mysqli_query($this->dbcnx, "SELECT colour FROM users WHERE name = '$name'");
            if (!$result) {
                echo("<P>Error performing query: " . mysqli_error($this->dbcnx) . "</P>");
                exit();
            }

            $row = mysqli_fetch_array($result);
            $fill = $row["colour"];

            if (isset ($_SESSION['AUTH'])) {
                echo "<td width=\"20\" bgcolor=" . $fill . "><a href=\"Change.php?DAY=$dayCount&MONTH=$this->currMonth&YEAR=$this->currYear&TYPE=$type&DISPLAY=$display&PREV=$prev\">";
                echo "<font face=Arial size=-1>$dayCount</font></a></td>\n";
            } else {
                echo "<td align=center bgcolor=" . $fill . "><font face=Arial size=-1>$dayCount</font>";
            }


            // increment counters
            $dayCount++;
            $rowCount++;
        }
        echo "</tr>\n";
        echo "</table>\n";
    }

// end of class
}
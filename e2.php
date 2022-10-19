<?
$distance = $_GET['x'];
?>

<?php print_r($_GET);
?>

<?
// Calculate the time in mintues with a decimal for a one way trip
function travelminutes($distance, $averageSpeed)
{
    $time = $distance / $averageSpeed;
    $time = number_format((float)$time, 2, '.', '');
    $time = $time * 60;
    return $time;
}

// Convert minutes to hours + minutes in real time notation
function convertToHoursMins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

// Get the on way distance from Google
if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])) {
    $distanceOneWay = $response_a['rows'][0]['elements'][0]['distance']['text']; // DISTANCE CALCULATED GOOGLE MAPS 
} else {
    $distanceOneWay = $_POST['distance']; // TEST WITH FIXED ONE WAY DISTANCE
}

// $distanceOneWay = $_POST['distcalc']; // TEST WITH Route.Js ONE WAY DISTANCE

$distanceOneWay = '80';

// Caculate the arrival and return times 
$travelTimeMinutes = travelminutes($distanceOneWay, 70);
$travelTimeHours = $travelTimeMinutes / 60;
$traveTimeSeconds = $travelTimeMinutes * 60;
$travelTimeHoursRaw = round($travelTime / 60, 2); // The One Way drive time in hours

$dateDestArrivalUnix = strtotime($_POST['departure']);
$timeDestArrivalUnix = strtotime($_POST['departureTime']) + $traveTimeSeconds;
$dateTimeDestArrivalUnix = $dateDestArrivalUnix + $timeDestArrivalUnix;
$arrivalDateTime = date("Y/m/d H:i:s", date($dateTimeDestArrivalUnix));

// Caculate the Reaching the Destination
$timeDextArrivalUnix =  strtotime($_POST['departureTime']) + $traveTimeSeconds;
$timeDestArrival = date("H:i", $timeDestArrivalUnix);

// Caculate the Time of returning home
$dateHomeArrivalUnix = strtotime($_POST['arrival']);
$timeHomeArrivalUnix =  strtotime($_POST['arrivalTime']) + $traveTimeSeconds;
$timeHomeArrival = date("H:i", $timeHomeArrivalUnix);

// Calculate total travel time from departure until arrival
$dateTimeDeparture = strtotime($_POST['departure'] . 'T' . $timeDeparture);
$dateTimeHome = strtotime($_POST['arrival'] . 'T' . $arrivalTime);

$totalTravelTime = $timeHomeArrivalUnix - $timeHomeArrivalUnix;

$totalTime = $totalTravelTime / 3600;


// Calculate time differnce between departure and arrival
$fromDate = date('Y-m-d', strtotime($_POST['departure'])); // Convert from date -> unix to Date
$fromTime = date('H:i:s', strtotime($_POST['departureTime'])); // Concert from time -> Unix to Time
$fromDate = $fromDate . ' ' . $fromTime; // Format Date + Time
$fromDate = strtotime($fromDate); // Unix Time From Date + Time

/// Travel time caculatoin to determine if arrival on destination is on the same date as the departure date
$destDateTime = $fromDate + $traveTimeSeconds; // The date + Time when the bus arrive at the destination
$destDateFormat = date("Y-m-d", $destDateTime); // The date in Y-m-d format to detime destination arrival date
$fromDateFormat = date('Y-m-d', strtotime($_POST['departure'])); // The date of departure
// End 

$returnDate = date('Y-m-d', strtotime($_POST['arrival'])); // Convert Return date -> Unix to Date
$returnTime = date('H:i:s', strtotime($_POST['arrivalTime'])); // Convert Return Time -> Unix to Time
$returnDate = $returnDate . ' ' . $returnTime; // Format Date + Time
$returnDate = strtotime($returnDate);
$returnDate = $returnDate + $traveTimeSeconds; // Add the Travel Time on way to Return Time

// Calculate the time between 00:00 on the return homedate and the time of arrival home
// For example if the return date is 5 april 2021 and the leave home at 20:00 with travel of 10 hours they arrive at 6 in the morning on the 6th of April - The difference between 12 and 6 o'clock is 6 hours
$returnDateMidnight = date('Y-m-d 00:00', $returnDate);
$returnDateMidnight = strtotime($returnDateMidnight);
$returnDateDifference = ($returnDate - $returnDateMidnight) / 3600;
if (!empty($returnDateDifference) && $returnDateDifference < 8) {
    $returnDateDifference = 8;
}

$travelTime = ($returnDate - $fromDate) / 3600; // Caculte The Differnce in hours between depart and home arrival

// ****** CALCULATE TRAVETIME ABROUD WITH TIME 00:00 AS STARTING TIME
$fromDateAbroad = date('Y-m-d', strtotime($_POST['departure'])); // Convert from date -> unix to Date
$fromTimeAbroad = date('H:i:s', strtotime('00:00:00')); // Concert from time -> Unix to Time
$fromDateAbroad = $fromDateAbroad . ' ' . $fromTimeAbroad; // Format Date+Time
$fromDateAbroad = strtotime($fromDateAbroad);
$traveltimeAbroad = (($returnDate - $fromDateAbroad) / 3600) / 24; // Rounded up to Ceil
$traveltimeAbroadCeil = ceil((($returnDate - $fromDateAbroad) / 3600) / 24); // Rounded up to Ceil

// Calulate Price
$passengers = $_POST['persons'];

// $hourPrice = '35.00';
// $limit = 50;
// $kmPrice = '0.65';
// $distance = 75 * 2;
// $averageSpeed = 70;

// $travelTimeHours = 6.57;

// $totalPrice = ($distance * $kmPrice) + $upset + ($hourPrice * $travelTimeHours);


// Qoutration div if rules do not match
if ($distanceOneWay >= 1820) {
    // is de heenreis / terugreis langer dan 1820 km vraag dan een offerte aan.					
    $quotation = 1;
}

// ************ PRICE CALCULATION 1-2 DAY ******************/
// if ($_POST['countryF'] == 'Netherlands' && $_POST['countryD'] == 'Netherlands') {
if (!isset($_POST['abroad'])) {

    $kmPrice = 0.65;
    $supplyKmCost = 0.19;
    $minHours = 4;
    $averageSpeed = 70;
    $hourPrice = '35.00';
    $restPrice = '35.00';
    $upset = 180;
    $totalDistance = $distanceOneWay * 2;
    $totalDistanceReturn = ($totalDistance * $kmPrice) * 2; // The price for 4 times the distance for sort trips if the bus can return to homebase								
    $driveTimeTotal = ($distanceOneWay * 2) / 70; // The total time the busdriver is driving the bus
    if ($driveTimeTotal < 4) {
        $driveTimeTotal = 4; // Minimal calculated driveTime 4 hours
    }

    if ($distanceOneWay / 70 < 4) {
        $driveTimeTotalReturn = 4; // Minimal calculated driveTime 4 hours
    }

    $driveTimeTotalReturn = (($distanceOneWay / 70) * 2) * 2.2; // The total time the busdriver is driving the bus including Margin for extra time (Factor 2.2)

    $restTime = $travelTime - $driveTimeTotal; // The difference between the total traveltime and the drive time total to determine the rest time

    // ************************ Calculations ************************
    // TravelTime <= 14 hours
    if ($travelTime <= 14) {
        $optionCal1 = $totalDistanceReturn + $upset; // Option 1 with returning the bus home before pick-up time
        $hoursCal1 = $hourPrice * $driveTimeTotalReturn;
        $optionCal1 = $optionCal1 + $hoursCal1;

        $optionCal2 = ($totalDistance * $kmPrice) + $upset; // Normal caculation
        $hoursCal2 =  $hourPrice * $travelTime;
        $optionCal2 = $optionCal2 + $hoursCal2;

        $totalPrice = min(array($optionCal1, $optionCal2));
        //$totalPrice = $optionCal1;
        //$totalPrice = $driveTimeTotalReturn;
    }

    // Travel time bigger then 21 hours without 9 hours resting time
    if ($travelTime > 21  && $restTime < 9) {
        $a = '> 21 without 9 hours rest';

        $totalPrice = ($totalDistance * $kmPrice) + $upset + ($hourPrice * ($travelTimeHours * 4)) + ($totalDistance * 0.19);
    }

    // Travetime > 14 hours && total traveltime < 9 hours & without 9 hours rest
    if ($travelTime > 14  && $driveTimeTotal < 9 && $restTime < 9) {
        $a = '14 without 9 hours rest';
        $timeRest = ($travelTime - 14) * 2;
        $totalPrice =
            ($totalDistance * $kmPrice) +
            $upset +
            ($hourPrice * $travelTime) +
            (250 * $supplyKmCost) +
            ($timeRest * $restPrice);
    }

    // TravelTime > 14 & total drive time less then 9 hours with 9 hours rest.
    if ($travelTime > 14  && $driveTimeTotal < 9 && $restTime >= 9) {
        $a = '> 14 with 9 hours rest';
        if ($travelTimeHoursRaw < 16) {
            $travelTimeHoursRaw = 16;
        }

        $totalPrice = ($totalDistance * $kmPrice) + $upset + ($hourPrice * $travelTimeHoursRaw);
    }

    // Price caculation each person
    if ($_POST['persons'] != 0) {
        $pricePerson = $totalPrice / $_POST['persons'];
    }
}

// ************ PRICE CALCULATION MUTIPLE DAYS ******************/
else {

    $kmPrice = 0.75;
    //$minHours = 4;
    $averageSpeed = 70;
    $hourPrice = '35.00';
    $restPrice = '35.00';
    $replacePrice = '25.00';
    $upset = 350;
    $replaceKmPrice = 0.19;
    $hourPrice = 35.00;

    $travelDays = ($dateHomeArrivalUnix - $dateDestArrivalUnix);
    $travelDays = round($travelDays / (60 * 60 * 24));
    $travelDays = $travelDays + 2;

    $totalDistance = $distanceOneWay * 2;


    if (
        // Calc 1:
        // de heenreis is korter dan 11 uren			
        // heenreis is niet verdeeld over 2 dagen			
        // de  heenreis is korter dan 15 uren			
        // de reis is naar het buitenland        
        $travelTimeHours  < 11 &&
        $travelTimeHours  < 15 &&
        $destDateFormat == $fromDateFormat
    ) {
        $calcN = 'cal 1';
        $distanceToBorder = 150;
        $vat1 = (100 / $distanceOneWay);
        $vat2 = $vat1 * $distanceToBorder; // 250 is the distance to the border
        $vat  = $vat1 * $vat2;
        $travelCost = ($traveltimeAbroadCeil * 8) * $hourPrice;
        $totalPrice = ($upset * $traveltimeAbroadCeil) + ($totalDistance * $kmPrice) + ($travelCost);
        $totalPrice = (($totalPrice / 100 * $vat2) * 0.09) + $totalPrice;
        $numberOfDrivers = $traveltimeAbroadCeil * 8;
    }

    if (
        // Calc 2:
        // de heenreis is korter dan 11 uren		
        // heenreis is verdeeld over 2 dagen		
        // de  heenreis is korter dan 15 uren		
        // de reis is naar het buitenland	
        $travelTimeHours  < 11 &&
        // $travelTimeHours  <= 15 &&
        $destDateFormat > $fromDateFormat
    ) {
        $calcN = 'cal 2';
        $distanceToBorder = 150;
        $vat1 = (100 / $distanceOneWay);
        $vat2 = $vat1 * $distanceToBorder; // 250 is the distance to the border
        $vat  = $vat1 * $vat2;
        $travelCost = ((($traveltimeAbroadCeil - 1) * 8) + $travelTimeHours)  * $hourPrice;
        $totalPrice = ($upset * $traveltimeAbroadCeil) + ($totalDistance * $kmPrice) + ($travelCost);
        $totalPrice = (($totalPrice / 100 * $vat2) * 0.09) + $totalPrice;
        $numberOfHours = (($traveltimeAbroadCeil - 1) * 8) + $travelTimeHours;
    }
    if (
        // Calc 3:
        // de heenreis is langer dan 15 uren		
        // heenreis is verdeeld over 2 dagen		
        // de  heenreis is korter dan 20 uren		
        // de reis is naar het buitenland
        $travelTimeHours  > 15 &&
        $travelTimeHours  <= 20 &&
        $destDateFormat > $fromDateFormat
    ) {
        $calcN = 'cal 3';
        $distanceToBorder = 250;
        $vat1 = (100 / $distanceOneWay);
        $vat2 = $vat1 * $distanceToBorder; // 250 is the distance to the border
        $vat  = $vat1 * $vat2;
        $numberOfDrivers = 2;
        $travelCost = (((($traveltimeAbroadCeil - 1) * 8) + $travelTimeHours)  * $hourPrice) * $numberOfDrivers;
        $totalPrice = ($upset * $traveltimeAbroadCeil) + ($totalDistance * $kmPrice) + ($travelCost);
        $totalPrice = (($totalPrice / 100 * $vat2) * 0.09) + $totalPrice;
        $numberOfHours = ((($traveltimeAbroadCeil - 1) * 8) + $travelTimeHours) * $numberOfDrivers;
    }
    if (
        // Calc 4:
        // de heenreis is langer dan 20 uren		
        // heenreis is verdeeld over 2 dagen		
        // de  heenreis is korter dan 26 uren		
        // de reis is naar het buitenland		
        $travelTimeHours  > 20 &&
        $travelTimeHours  <= 26 &&
        $destDateFormat > $fromDateFormat
    ) {
        $calcN = 'cal 4';
        $distanceToBorder = 250;
        $vat1 = (100 / $distanceOneWay);
        $vat2 = $vat1 * $distanceToBorder; // 250 is the distance to the border
        $vat  = $vat1 * $vat2;
        $numberOfDrivers = 2;
        $distanceToBorder = 250;
        $replaceCost = ((($distanceOneWay - 1400) * 4) / 70) * $replacePrice;
        $replaceKmCost = (($distanceOneWay - 1400) * 4) * $replaceKmPrice;
        $travelCost = (((($traveltimeAbroadCeil - 1) * 8) + $travelTimeHours)  * $hourPrice) * $numberOfDrivers;
        $totalPrice = ($upset * $traveltimeAbroadCeil) + ($totalDistance * $kmPrice) + $travelCost + $replaceCost +  $replaceKmCost;
        $numberOfHours = ((($traveltimeAbroadCeil - 1) * 8) + $travelTimeHours) * $numberOfDrivers;

        $vatCalc = (($totalPrice / 100) * $vat2) * 0.09;

        $totalPrice = $totalPrice + $vatCalc;
    }
    if (
        // Calc 5:
        // de heenreis is langer dan 11 uren			
        // heenreis is niet verdeeld over 2 dagen			
        // de  heenreis is korter dan 15 uren			
        // de reis is naar het buitenland				
        $travelTimeHours  > 11 &&
        $travelTimeHours  <= 15 &&
        $destDateFormat == $fromDateFormat
    ) {
        $calcN = 'cal 5';
        $distanceToBorder = 150;
        $vat1 = (100 / $distanceOneWay);
        $vat2 = $vat1 * $distanceToBorder; // 250 is the distance to the border
        $vat  = $vat1 * $vat2;
        $numberOfDrivers = 1;
        $distanceToBorder = 250;
        $replaceCost = ((($distanceOneWay - 750) * 4) / 70) * $replacePrice;
        $replaceKmCost = (($distanceOneWay - 750) * 4) * $replaceKmPrice;
        $travelCost = ((($traveltimeAbroadCeil - 2) * 8) + ($travelTimeHours * 2)) * $hourPrice;

        $totalPrice = ($upset * $traveltimeAbroadCeil) + ($totalDistance * $kmPrice) + $travelCost + $replaceCost;
        $numberOfHours = ((($traveltimeAbroadCeil - 2) * 8) + $travelTimeHours + $returnDateDifference) * 2;

        $vatCalc = (($totalPrice / 100) * $vat2) * 0.09;

        $totalPrice = $totalPrice + $vatCalc;
    }

    if (
        // Calc 6:
        // de heenreis is langer dan 15 uren		
        // heenreis is niet verdeeld over 2 dagen		
        // de  heenreis is korter dan 20 uren		
        // de reis is naar het buitenland		
        $travelTimeHours  > 15 &&
        $travelTimeHours  <= 20 &&
        $destDateFormat == $fromDateFormat

    ) {
        $calcN = 'cal 6';
        $distanceToBorder = 250;
        $vat1 = (100 / $distanceOneWay);
        $vat2 = $vat1 * $distanceToBorder; // 250 is the distance to the border
        $vat  = $vat1 * $vat2;
        $numberOfDrivers = 2;
        $travelCost = (((($traveltimeAbroadCeil - 2) * 8) + $travelTimeHours + $returnDateDifference) * 2) * $hourPrice;
        $totalPrice = ($upset * $traveltimeAbroadCeil) + ($totalDistance * $kmPrice) + ($travelCost);
        $totalPrice = (($totalPrice / 100 * $vat2) * 0.09) + $totalPrice;
        $numberOfHours = ((($traveltimeAbroadCeil - 2) * 8) + $travelTimeHours + $returnDateDifference) * 2;
    }

    if (
        // Calc 7:
        // de heenreis is langer dan 20 uren		
        // heenreis is niet verdeeld over 2 dagen		
        // de  heenreis is korter dan 24 uren		
        // de reis is naar het buitenland			
        $travelTimeHours  > 20 &&
        $travelTimeHours  <= 24 &&
        $destDateFormat == $fromDateFormat
    ) {
        $calcN = 'cal 7';
        $distanceToBorder = 250;
        $vat1 = (100 / $distanceOneWay);
        $vat2 = $vat1 * $distanceToBorder; // 250 is the distance to the border
        $vat  = $vat1 * $vat2;
        $numberOfDrivers = 2;
        $distanceToBorder = 250;
        $replaceCost = ((($distanceOneWay - 1400) * $traveltimeAbroadCeil) / 70) * $replacePrice;
        $replaceKmCost = (($distanceOneWay - 1400) * 4) * $replaceKmPrice;
        $travelCost = (((($traveltimeAbroadCeil - 2) * 8) + $travelTimeHours + $returnDateDifference) * 2) * $hourPrice;
        $totalPrice = ($upset * $traveltimeAbroadCeil) + ($totalDistance * $kmPrice) + $travelCost + $replaceCost +  $replaceKmCost;

        $numberOfHours = ((($traveltimeAbroadCeil - 2) * 8) + $travelTimeHours + $returnDateDifference) * 2;
        $vatCalc = (($totalPrice / 100) * $vat2) * 0.09;

        $totalPrice = $totalPrice + $vatCalc;
    }
}

echo $totalPrice;




<? for ($i = 1; $i <= 6; $i++) {
    $timeWayPoints[] = 2;
}


//print_r($timeWayPoints);
$a = array_sum($timeWayPoints);
echo $a;


$postcode = '1234AB';
$postcode = substr($postcode, 0, 4);
echo '<br>';
echo $postcode;

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?

    $waypoints = array('lwd', 'ams', 'rot');
    // print_r($waypoints);
    foreach (array_filter($waypoints) as $key => $waypointL) { //
        $key =  $key;
        // $key = $key + 1;

        // echo '<h1>POK' . $key . '</h1>';
        // $waypoint[] = $_POST['cityW' . $key] . $_POST['streetW' . $key] . $_POST['streetnumberW' . $key];
        //$x1 = 'blah';

        // $amount = '$amount';
        ${'amount' . $key} = $waypointL;

        // $x = ${'amount' . $key};


        $x .= ${'amount' . $key} . '|';

        // $x . $key = 'aaa';
        // echo $x0 . '<br>';
    }

    // echo $amount0;
    $x = substr($x, 0, -1);
    echo $x;
    ?>

    <form action="" method="post">
        <? for ($i = 1; $i <= 2; $i++) { ?>
            <input placeholder="c" type="text" name="cityW[]">
            <input placeholder="s" type="text" name="streetW[]">
        <? } ?>
        <input type="submit" value="submit">
    </form>
    <?


    foreach ($_POST['cityW'] as $city) {
        $waypoints = $_POST['cityW'] . $_POST['streetW'];
    }

    foreach ($waypoints as $waypointC) {
        $waypoint[] = $waypointC;
    }

    print_r($waypoint);

    ?>
</body>

</html>
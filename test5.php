<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <?
        for ($i = 1; $i <= 3; $i++) { ?>
            <input type="text" name="test[]">

            <input type="text" name="appel[]">
            <input type="text" name="peer[]">
            <br>
        <? } ?>

        <input type="submit" value="submit">
    </form>


    <?
    if (!empty($_POST)) {
        $test = ($_POST['test']);
        $appel = ($_POST['appel']);
        $peer = ($_POST['peer']);
        $group = array_filter(array_merge($test, $appel, $peer));

        print_r($group);
    }
    ?>
</body>

</html>
<form action="" method="POST">
    <? for ($i = 1; $i <= 4; $i++) { ?>

    <? } ?>

</form>


<?
for ($i = 0; $i < count($_POST['a']); ++$i) {
    $b = $_POST['b'][$i];
    $c = $_POST['c'][$i];
    $d = $_POST['d'][$i];
    $e = $_POST['e'][$i];
    // do stuff
}

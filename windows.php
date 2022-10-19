
<?php
// create mysqli connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "pieterpanda";

$db = new mysqli($host, $user, $pass, $db);

$query = $db->query("SELECT * FROM `user`");

while ($row = mysqli_fetch_array($query)) {
    echo $row['id'];
    echo $row['name'];
}


// add user
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $query = $db->query("INSERT INTO `user` (`name`) VALUES ('$name')");
    header("Location: windows.php");
}

// delete user
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = $db->query("DELETE FROM `user` WHERE `id` = '$id'");
    header("Location: windows.php");
}

// add user form 
echo "<form method='post' action='windows.php'>
    <input type='text' name='name' placeholder='Name'>
    <input type='submit' name='add' value='Add'>
</form>";

// delete user form
echo "<form method='post' action='windows.php'>
    <input type='text' name='id' placeholder='ID'>
    <input type='submit' name='delete' value='Delete'>
</form>";

// create edit dropdown list users
echo "<form method='post' action='windows.php'>
    <select name='id'>";
$query = $db->query("SELECT * FROM `user`");

while ($row = mysqli_fetch_array($query)) {
    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
}
echo "</select>
    <input type='submit' name='edit' value='Edit'>
</form>";

// edit user form
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $query = $db->query("SELECT * FROM `user` WHERE `id` = '$id'");
    while ($row = mysqli_fetch_array($query)) {
        echo "<form method='post' action='windows.php'>
            <input type='text' name='name' value='" . $row['name'] . "'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <input type='submit' name='update' value='Update'>
        </form>";
    }
}

// update user
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $query = $db->query("UPDATE `user` SET `name` = '$name' WHERE `id` = '$id'");
    header("Location: windows.php");
}

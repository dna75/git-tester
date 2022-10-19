<?php
//Database connection file
include('config.php');

if (isset($_POST['submit'])) {
    // Counting No fo skilss
    $count = count($_POST["skill"]);
    //Getting post values
    $skill = $_POST["skill"];
    if ($count > 1) {
        for ($i = 0; $i < $count; $i++) {
            if (trim($_POST["skill"][$i] != '')) {
                $sql = mysqli_query($con, "INSERT INTO tblskills(skill) VALUES('$skill[$i]')");
            }
        }
        echo "<script>alert('Skills inserted successfully');</script>";
    } else {
        echo "<script>alert('Please enter skill');</script>";
    }
}
?>
<html>

<head>
    <title>PHPGurukul Programmin Blog | Dynamically Add or Remove input fields in PHP with JQuery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h2 align="center">Dynamically Add or Remove input fields in PHP with JQuery</h2><br />
        <div class="form-group">
            <form name="add_name" id="add_name" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field">
                        <tr>
                            <td><input type="text" name="skill[]" placeholder="Enter your Skill" class="form-control name_list" /></td>
                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                        </tr>
                    </table>
                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="skill[]" placeholder="Enter your Skill" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>

</html>
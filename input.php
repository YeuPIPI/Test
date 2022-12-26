<?php
require_once ('database.php');

$UserName = $Password = $Email = $Lever = $Name = $Phone = '';

if (!empty($_POST)) {
    $s_id = '';

    if (isset($_POST['UserName'])) {
        $UserName = $_POST['UserName'];
    }

    if (isset($_POST['Password'])) {
        $Password = $_POST['Password'];
    }

    if (isset($_POST['Name'])) {
        $Name = $_POST['Name'];
    }

    if (isset($_POST['Email'])) {
        $Email = $_POST['Email'];
    }

    if (isset($_POST['Lever'])) {
        $Lever = $_POST['Lever'];
    }

    if (isset($_POST['Phone'])) {
        $Phone = $_POST['Phone'];
    }

    if (isset($_POST['id'])) {
        $s_id = $_POST['id'];
    }

    $UserName = str_replace('\'', '\\\'', $UserName);
    $Password      = str_replace('\'', '\\\'', $Password);
    $Name  = str_replace('\'', '\\\'', $Name);
    $Email       = str_replace('\'', '\\\'', $Email);
    $Lever       = str_replace('\'', '\\\'', $Lever);
    $Phone       = str_replace('\'', '\\\'', $Phone);
    $s_id       = str_replace('\'', '\\\'', $s_id);
    if ($s_id != '') {
        //update
        $sql = "update user set UserName = '$UserName', Password = '$Password', Name = '$Name', Email = '$Email', Lever = '$Lever', Phone = '$Phone'  where id = " .$s_id;
    } else {
        //insert
        $sql = "insert into user(UserName,Password,Name,Email,Lever,Phone) value ('$UserName', '$Password', '$Name', '$Email', '$Lever', '$Phone')";
    }

    query($sql);

    header('Location: index.php');
    die();
}

$id = '';
if (isset($_GET['id'])) {
    $id          = $_GET['id'];
    $sql         = 'select * from user where id = '.$id;
    $studentList = select($sql);
    if ($studentList != null && count($studentList) > 0) {
        $std        = $studentList[0];
        $UserName = $std['UserName'];
        $Password  = $std['Password'];
        $Name  = $std['Name'];
        $Email  = $std['Email'];
        $Lever  = $std['Lever'];
        $Phone  = $std['Phone'];

    } else {
        $id = '';
    }
}
?>

    <!DOCTYPE html>
    <html>
<head>
    <title>Registation Form * Form Tutorial</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">Add Student</h2>
        </div>
        <div class="panel-body">
            <form method="post">
                <div class="form-group">
                    <label>UserName:</label>
                    <input type="number" name="id" value="<?=$id?>" style="display: none;">
                    <input required="true"  type="text" class="form-control"  name="UserName" value="<?=$UserName?>">
                </div>
                <div class="form-group">
                    <label >Password:</label>
                    <input  type="text" class="form-control"  name="Password" value="<?=$Password?>">
                </div>

                <div class="form-group">
                    <label >Email:</label>
                    <input type="text" class="form-control"  name="Email" value="<?=$Email?>">
                </div>
                <div class="form-group">
                    <label>Lever:</label>
                    <input type="number" class="form-control"  name="Lever" value="<?=$Lever?>">
                </div>
                <div class="form-group">
                    <label >Name:</label>
                    <input  type="text" class="form-control"  name="Name" value="<?=$Name?>">
                </div>

                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" class="form-control"  name="Phone" value="<?=$Phone?>">
                </div>

                <button class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
</body>
    </html><?php

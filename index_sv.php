<?php
require_once ('config.php');
require_once ('database.php');
session_start();
$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
if ($conn === false) {
    die("ERROR: Không thể kết nối. " . mysqli_connect_error());
}
if (isset($_SESSION['UserName']) && $_SESSION['UserName']){
    echo 'Xin chao : '.$_SESSION['UserName']."<br/>";
    echo 'Click vào đây để <a href="logout.php">Logout</a>';
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
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
            Quản lý thông tin sinh viên
            <form method="get">
                <input type="text" name="search" class="form-control" style="margin-top: 15px; margin-bottom: 15px;" placeholder="Tìm kiếm theo tên">
            </form>
        </div>

        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Lever</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th width="60px"></th>
                    <th width="60px"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_GET['search']) && $_GET['search'] != '') {
                    $sql = 'select * from user where Name like "%'.$_GET['search'].'%"';
                } else {
                    $sql = 'select * from user';
                }

                $studentList = select($sql);

                $index = 1;
                foreach ($studentList as $std) {
                    echo '<tr>
			<td>'.($index++).'</td>
			<td>'.$std['Email'].'</td>
			<td>'.$std['Lever'].'</td>
			<td>'.$std['Name'].'</td>
			<td>'.$std['Phone'].'</td>
			<td><button class="btn btn-warning" onclick=\'window.open("Chat.php?id='.$std['id'].'","_self")\'>Chat</button></td>
		</tr>';
                }
                ?>
                </tbody>
            </table>
            <?php
            $UserName = $_SESSION['UserName'];
            $rows = mysqli_query($conn,"
				select * from user where UserName = '$UserName' 
			");
            $row_save = mysqli_fetch_array($rows);
            $id = $row_save['id'];

            echo '<tr>
            
                    <button class="btn btn-warning" onclick=\'window.open("edit_sv.php?id='.$id.'","_self")\'>EDIT PROFILE</button>
            </tr>';
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function deleteStudent(id) {
        option = confirm('Bạn có muốn xoá sinh viên này không')
        if(!option) {
            return;
        }

        console.log(id)
        $.post('delete_student.php', {
            'id': id
        }, function(data) {
            alert(data)
            location.reload()
        })
    }
</script>
</body>
</html>
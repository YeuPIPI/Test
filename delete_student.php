<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    require_once ('database.php');
    $sql = 'delete from user where id = '.$id;
    query($sql);

    echo 'Xoá sinh viên thành công';
}
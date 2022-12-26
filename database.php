<?php
require_once ('config.php');

function query($query) {
    //tao ket noi toi database
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    //mysqli_set_charset($conn, 'utf8_unicode_ci');

    //thuc hien cac cau truy van
    //insert, update, delete
    // $conn->query($query);
    mysqli_query($conn, $query);

    //dong ket noi
    $conn->close();
}
function select($query) {
    //tao ket noi toi database
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    if ($conn === false) {
        die("ERROR: Không thể kết nối. " . mysqli_connect_error());
    }
    //thuc hien cac cau truy van
    //select
    $cusor = mysqli_query($conn,$query);
    $result = [];
    while ($row = mysqli_fetch_array($cusor, 1)) {
        $result[] = $row;
    }
    //dong ket noi
    $conn->close();
    return $result;
}

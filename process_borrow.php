<?php
    include "config.php";

    $currentDateTime = date("Y-m-d");

    if (isset($_POST['borrow_user']) && isset($_POST['borrow_id'])) {
        $borrow_user = mysqli_real_escape_string($conn, $_POST['borrow_user']);
        $borrow_id = mysqli_real_escape_string($conn, $_POST['borrow_id']);
        $borrow_id = strtoupper($borrow_id);

        $sql_borrow = "INSERT INTO tb_borrow_book (br_date_br, br_date_rt, b_id, m_user, br_fine) VALUES ('$currentDateTime', '0000-00-00', '$borrow_id', '$borrow_user', '0')";
        mysqli_query($conn, $sql_borrow);

        echo "<script>";
        echo "if(confirm('ทำรายการสำเร็จ')) {";
        echo "  window.location.href = 'br_borrow.php';";
        echo "} ";
        echo "</script>";
    } else {
        echo "<script>";
        echo "if(confirm('ไม่ได้รับข้อมูลการยืมหนังสือ')) {";
        echo "  window.location.href = 'br_borrow.php';";
        echo "} ";
        echo "</script>";
    }
?>

                    
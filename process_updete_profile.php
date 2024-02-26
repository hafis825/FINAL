<?php
   
   include 'config.php';
   session_start();

   $fullname = $_POST['fullname'];
   $phone = $_POST['phone'];
   

   $username = $_SESSION['m_user'];
   //uploadfile
   $file = $_FILES['photo']['name'];
   $folder_name = "images/";
   $new_file = $username."_".$file;
   $base_name = $folder_name.$new_file ;
   $ext_name = strtolower(pathinfo($base_name,PATHINFO_EXTENSION));
   $file_image = getimagesize($_FILES['photo']['tmp_name']);
   $file_size = $_FILES['photo']['size'];

   
   if($file_image == false){
    echo "คุณไม่ได้ส่งรูปภาพ";
    }elseif ($ext_name != "jpg" && $ext_name != "jpeg" && $ext_name != "png") {
        echo "คุณไม่ได้ส่งรูปภาพนามสกุล jpg /jpeg/png";
    }elseif($file_size > 300000){
        echo "คุณส่งรูปภาพใหญ่เกิน 300KB";
    }else{
        move_uploaded_file($_FILES['photo']['tmp_name'],$base_name);  
        $sql1 = "UPDATE tb_member SET m_name = '$fullname', m_phone = '$phone', m_photo = '$new_file' WHERE m_user = '$username'"; 
        $qry1 = mysqli_query($conn,$sql1);
        if (!$qry1) {
            // ปรับปรุงข้อมูลไม่สำเร็จ
            header("location: setting.php");
        }else {
            // ปรับปรุงข้อมูลสำเร็จ
            header("location: index.php");
        }  

    }
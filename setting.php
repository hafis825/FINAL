<?php 
    include 'config.php';
    session_start();

    if (!isset($_SESSION['m_user'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    $username = $_SESSION['m_user'];
    $sql = "SELECT * FROM tb_member WHERE m_user = '$username'"; 
    $qry = mysqli_query($conn,$sql);
    $result = mysqli_fetch_array($qry);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniProject | Update Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    header {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .body-info {
            margin: 0 auto;
            max-width: 550px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 5px;
    }

    input[type=text],
    input[type=file] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            outline: none;
            border-radius: 5px;
    }

    .container {
            padding: 16px;
    }

    .container a {
            color: #292929;
    }


    .btn {
            background-color: #292929;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
    }

    .dropdown img {
        border-radius: 50%;
        max-width: 40px;
        max-height: 40px;
    }

    .dropdown-content .dropdown-content-user {
        display: flex;
        align-items: center; 
        padding: 5px;
    }

    .dropdown-content .dropdown-content-user img {
        border-radius: 50%;
        max-width: 40px;
        max-height: 40px;
        margin: 0 10px; 
    }

    .dropdown-content #user {
        color: #ff5733;
        padding: 5px;
        font-size: 18px;
    }


</style>

<body>
    <section class="header">
        <div class="head-menu">
            <strong>วิทยาลัยการอาชีพปัตตานี</strong>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">หน้าแรก</a></li>

            <div class="dropdown">
                <button class="dropbtn">
                    ยืม-คืนหนังสือ
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="br_borrow.php">ยืมหนังสือ</a>
                    <a href="rt_borrow.php">คืนหนังสือ</a>
                </div>
            </div>

            <li><a href="statistics.php">ข้อมูลสถิติ</a></li>
            
            
            <div class="dropdown">
                <button class="dropbtn" id="user">
                        <img src="images/<?php echo $result['m_photo'];?>" alt="profile">
                </button>
                <div class="dropdown-content">
                    <div class="dropdown-content-user">
                        <img src="images/<?php echo $result['m_photo'];?>" alt="profile">
                        <span id="user"><?php echo $_SESSION['m_user']; ?></span>
                    </div>
                    <hr>
                    <a href="setting.php">ตั้งค่า</a>
                    <a href="logout.php">ออกจากระบบ</a>
                </div>
            </div>

        </ul>


    </section>

    <header>
        <div class="header-info">
            <h1>เพิ่มข้อมูล/แก้ไขประวัติส่วนตัว</h1>
        </div>
    </header>

    <section class="body-info">
        <div class="container">
            <form action="process_updete_profile.php" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="uname"><b>ชื่อ - สกุล</b></label>
                    <input type="text" name="fullname" value=<?=$result['m_name']?>>
                </div>

                <div class="input-group">
                    <label for="psw"><b>เบอร์โทรศัพท์</b></label>
                    <input type="text" name="phone" value=<?=$result['m_phone']?>>
                </div>

                <div class="input-group">
                    <label for="psw"><b>รูปภาพ</b></label>
                    <input type="file" name="photo" value=<?=$result['m_photo']?>>
                </div>


                <div class="input-group">
                    <button type="submit" class="btn">เพิ่มข้อมูล/แก้ไข</button>

                </div>
            </form>
        </div>
    </section>


</body>

</html>
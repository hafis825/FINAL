<?php 
    session_start();
    include "config.php";

    if (!isset($_SESSION['m_user'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    $username = $_SESSION['m_user'];
    $sql = "SELECT * FROM tb_member WHERE m_user = '$username'"; 
    $qry = mysqli_query($conn,$sql);
    $result = mysqli_fetch_array($qry);


    $sql1 = "SELECT COUNT(b_name) AS count FROM tb_book";
    $sql2 = "SELECT COUNT(m_user) AS count FROM tb_member";
    $sql3 = "SELECT COUNT(br_date_br) AS count FROM tb_borrow_book";
    $sql4 = "SELECT COUNT(br_date_rt) AS count FROM tb_borrow_book WHERE br_date_rt = '0000-00-00'";

    
    $qry1 = mysqli_query($conn, $sql1);
    $result1 = mysqli_fetch_assoc($qry1);
    $count1 = $result1['count'];

    
    $qry2 = mysqli_query($conn, $sql2);
    $result2 = mysqli_fetch_assoc($qry2);
    $count2 = $result2['count'];

    
    $qry3 = mysqli_query($conn, $sql3);
    $result3 = mysqli_fetch_assoc($qry3);
    $count3 = $result3['count'];

    
    $qry4 = mysqli_query($conn, $sql4);
    $result4 = mysqli_fetch_assoc($qry4);
    $count4 = $result4['count'];
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniProject | Statistics</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>

    .body {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .header-info {
        text-align: center;

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

    .body-info {
        margin: 0 auto;
        padding: 1rem;
        border-radius: 15px;
        max-width: 850px;
        display: flex;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .total {
        width: 90%;
        padding: 1rem;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(2, 2fr);
        grid-gap: 50px;
    }

    .body-info .total .from-group strong {
        font-size: 94px;
        text-align: center;
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .body-info .total .from-group .amount1 strong {
        background-color: rgba(151,255,155,255);
    }

    .body-info .total .from-group .amount2 strong {
        background-color: rgba(153,205,253,255);
    }

    .body-info .total .from-group .amount3 strong {
        background-color: rgba(255,254,153,255);
    }

    .body-info .total .from-group .amount4 strong {
        background-color: rgba(255,204,203,255);
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

            <li  class="current"><a href="statistics.php">ข้อมูลสถิติ</a></li>
            
            
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
            <h1>ข้อมูลสถิติ-ของห้องสมุด</h1>
        </div>
    </header>


    <div class="body-info">
        <div class="total">
            <div class="from-group">
                <span><b>หนังสือทั้งหมด (เล่ม)</b></span>
                <div class="amount1"><strong><?php echo $count1; ?></strong></div>
            </div>
            
            <div class="from-group">
                <span><b>การใช้บริการยืม-คืนหนังสือ (ครั้ง)</b></span>
                <div class="amount2"><strong><?php echo $count3; ?></strong></div>
            </div>
                
            <div class="from-group">
                <span><b>สมาชิกทั้งหมด (คน)</b></span>
                <div class="amount3"><strong><?php echo $count2; ?></strong></div>
            </div>
            
            <div class="from-group">
                <span><b>หนังสือค้างส่ง (เล่ม)</b></span>
                <div class="amount4"><strong><?php echo $count4; ?></strong></div>
            </div>
        </div>
    </div>


</body>

</html>
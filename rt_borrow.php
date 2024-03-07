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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniProject | Borrow</title>
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



    .btn_c {
        background-color: #FF6961;
    }

    .search {
        margin: 0 auto;
        text-align: center;
        border-radius: 5px;
        margin-bottom: 3rem;
    }

    .search input,
    .search button,
    .search-group input,
    .search-group button {
        padding: 8px;
        margin: 0 auto;
        border: 1px solid #ccc;
        outline: none;
        border-radius: 5px;
    }

    .body-info {
        margin: 0 auto;
        padding: 1rem;
        max-width: 1200px;
        max-height: 70%;
        border-radius: 12px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .search-info {
        margin: 0 auto;
        text-align: center;
        width: 60%;
        max-height: 100%;
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        grid-gap: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .search-info .search-group {
        padding: 12px;
    }

</style>

<body>
    <section class="header">
        <div class="head-menu">
            <strong>ห้องสมุดการอาชีพปัตตานี</strong>
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
            <h1>คืนหนังสือ</h1>
        </div>
    </header>

    <div class="body-info">
        <form  method="post" action="process_rt_borrow.php">

            <div class="search">
                <label for="search_id">รหัสหนังสือที่ต้องการคืน :</label>
                <input type="text" id="search" name="search" required>
                <button type="submit" name="submit_search" class="btn"><b>ค้นหา</b></button>
            </div>

            <div class="search-info">
                <div class="search-group">
                    <label for="search_id">รหัสหนังสือ :</label>
                    <span></span>
                </div>

                <div class="search-group">
                    <label for="search_id">ชื่อหนังสือ :</label>
                    <span></span>
                </div>

                <div class="search-group">
                    <label for="search_id">ผู้ยืม-คืนหนังสือ :</label>
                    <span></span>
                </div>

                <div class="search-group">
                    <label for="search_id">วันที่ยืมหนังสือ :</label>
                    <span></span>
                </div>

                <div class="search-group">
                    <label for="search_id">ค่าปรับ :</label>
                    <input style="cursor:not-allowed;" type="text" name="search_id" placeholder="กรอกค่าปรับหนังสือ" readonly>
                </div>

                <div class="search-group">
                    <button type="button" name="submit_borrow" class="btn" ><b>คืนหนังสือ</b></button>
                    <button type="button" onclick="window.location.href = 'rt_borrow.php'" class="btn_c">ยกเลิก</button>
                </div>
            </div>
        </form>
    </div>


</body>

</html>
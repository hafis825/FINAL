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
    <title>MiniProject | Home</title>
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

    .body-info {
        margin-top: 3rem;
        text-align: auto;
        padding: 1rem;
        border-radius: 15px;
    }

    .search {
        margin: 0 auto;
        text-align: center;
        border-radius: 5px;

        & input, button{
            padding: 8px;
            margin: 0 auto;
            border: 1px solid #ccc;
            outline: none;
            border-radius: 5px;
            
            
        }
    }

    

    table {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-spacing: 1;
        border-collapse: collapse;
        background-color: rgba(211, 211, 211, 1);
        border-radius: 6px;
        overflow: hidden;
        /* max-width: 650px; */
        /* width: 100%; */
        margin: 0 auto;
        position: relative;

        * {
            position: relative
        }

        td,
        th {
            padding-left: 8px
        }

        thead tr {
            height: 60px;
            background: #707070;
            font-size: 16px;
        }

        tbody tr {
            height: 48px;
            border-bottom: 1px solid #ccc;

        }

        td,
        th {
            text-align: left;
        }

    }

    .btn_c {
        background-color: #FF6961;
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
        padding: 5px;
        font-size: 18px;
    }

    .dropdown-content.show {
        display: block;
    }

</style>

<body>
    <section class="header">
        <div class="head-menu">
            <strong>วิทยาลัยการอาชีพปัตตานี</strong>
        </div>
        <ul class="nav-links">
            <li class="current"><a href="index.php">หน้าแรก</a></li>

            <div class="dropdown" onclick="toggleDropdown()">
                <button class="dropbtn">
                    ยืม-คืนหนังสือ
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content" id="myDropdown">
                    <a href="br_borrow.php">ยืมหนังสือ</a>
                    <a href="rt_borrow.php">คืนหนังสือ</a>
                </div>
            </div>

            <li><a href="statistics.php">ข้อมูลสถิติ</a></li>
            
            
            <div class="dropdown" onclick="toggleDropdown()">
                <button class="dropbtn" id="user">
                        <img src="images/<?php echo $result['m_photo'];?>" alt="profile">
                </button>
                <div class="dropdown-content">
                    <div class="dropdown-content-user" id="myDropdown">
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
            <h1>การจัดการข้อมูลการยืม-คืนหนังสือ</h1>
        </div>
    </header>

    <form method="post">
        <div class="search">
            <input type="text" name="search">
            <button type="submit" name="submit_search" class="btn">ค้นหา</button>
            <button type="button" onclick="clearSearch()" class="btn_c">ยกเลิก</button>
        </div>

        <div class="body-info">
            <table>
                <thead>
                    <tr>
                        <th>รหัสหนังสือ</th>
                        <th>ชื่อหนังสือ</th>
                        <th>ผู้ยืม-คืน</th>
                        <th>วันที่ยืม</th>
                        <th>วันที่คืน</th>
                        <th>ค่าปรับ</th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT * FROM tb_book INNER JOIN tb_borrow_book ON tb_book.b_id = tb_borrow_book.b_id";
                if(isset($_POST['submit_search'])){
                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                    $sql .= sprintf(" WHERE tb_book.b_name LIKE '%%%s%%' OR tb_book.b_writer LIKE '%%%s%%' OR tb_borrow_book.br_date_br LIKE '%%%s%%' OR tb_borrow_book.br_date_rt LIKE '%%%s%%' OR tb_book.b_id LIKE '%%%s%%' OR tb_borrow_book.br_fine LIKE '%%%s%%'", $search, $search, $search, $search, $search, $search);
                }

                $sql .= " ORDER BY tb_borrow_book.br_date_br DESC";

                $qry = mysqli_query($conn, $sql);
                if($qry === false) {
                    echo "Query execution failed: " . mysqli_error($conn);
                } else {
                    if(mysqli_num_rows($qry) > 0) {
                        while ($result = mysqli_fetch_assoc($qry)) {
                            ?>
                            <tr>
                                <td><?php echo $result['b_id']; ?></td>
                                <td><?php echo $result['b_name']; ?></td>
                                <td><?php echo $result['b_writer']; ?></td>
                                <td><?php echo $result['br_date_br']; ?></td>
                                <td><?php echo $result['br_date_rt']; ?></td>
                                <td><?php echo $result['br_fine']; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>ไม่พบรายการ</td></tr>";
                    }
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </form>

    <script>
        function clearSearch() {
            document.querySelector('input[name="search"]').value = '';
            document.querySelector('form').submit();
        }

        function toggleDropdown() {
            var dropdownContent = document.getElementById("myDropdown");
            dropdownContent.classList.toggle("show");
            }
            window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
                }
            }
        }
    </script>


</body>

</html>

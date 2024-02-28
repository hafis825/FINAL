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

    .body-info {
        margin-top: 3rem;
        margin: 0 auto;
        text-align: auto;
        padding: 1rem;
        border-radius: 15px;
        max-width: 650px;
        width: 100%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .search {
        margin: 0 auto;
        text-align: center;
        border-radius: 5px;
        margin-bottom: 1rem;
    }

    .search input,
    .search button {
        padding: 8px;
        margin: 0 auto;
        border: 1px solid #ccc;
        outline: none;
        border-radius: 5px;
    }

    table {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-spacing: 1;
        border-collapse: collapse;
        background-color: rgba(211, 211, 211, 1);
        border-radius: 3px;
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
            <h1>ยืมหนังสือ</h1>
        </div>
    </header>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $input_value_user = $_POST['search_user'];
            $input_value_id = $_POST['search_id'];
        } else {
            $input_value_user = '';
            $input_value_id = '';
        }
    ?>

    <div class="body-info">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <div class="search">
                <label for="search_user">ผู้ที่ต้องการยืม :</label>
                <input type="text" id="search_user" name="search_user" placeholder="กรอกผู้ใช้งาน" value="<?php echo $input_value_user;?>" required>
            </div>

            <div class="search">
                <label for="search_id">รหัสหนังสือ :</label>
                <input type="text" id="search_id" name="search_id" placeholder="กรอกรหัสหนังสือ" value="<?php echo $input_value_id;?>" required>
            </div>

            <div class="search">
                <button type="submit" name="submit_search" class="btn"><b>ตกลง</b></button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ชื่อ-สกุลผู้ยืม</th>
                        <th>รหัสหนังสือ</th>
                        <th>ชื่อหนังสือ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['submit_search'])) {
                        $search_user = mysqli_real_escape_string($conn, $_POST['search_user']);
                        $search_id = mysqli_real_escape_string($conn, $_POST['search_id']);

                        $sql_user = "SELECT m_name FROM tb_member WHERE m_user LIKE '%$search_user%'";
                        $qry_user = mysqli_query($conn, $sql_user);
                        $user_result = mysqli_fetch_assoc($qry_user);

                        $sql_book = "SELECT b_id, b_name FROM tb_book WHERE b_id LIKE '%$search_id%'";
                        $qry_book = mysqli_query($conn, $sql_book);

                        if ($qry_user === false || $qry_book === false) {
                            echo "Query execution failed: " . mysqli_error($conn);
                        } else {
                            if (mysqli_num_rows($qry_user) > 0 && mysqli_num_rows($qry_book) > 0) {
                                while ($book_result = mysqli_fetch_assoc($qry_book)) {
                    ?>
                                    <tr>
                                        <td><?php echo $user_result['m_name']; ?></td>
                                        <td><?php echo $book_result['b_id']; ?></td>
                                        <td><?php echo $book_result['b_name']; ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                echo "<script>";
                                echo "if(confirm('ไม่พบข้อมูลสมาชิก หรือหนังสือ')) {";
                                echo "  window.location.href = 'br_borrow.php';";
                                echo "} ";
                                echo "</script>";
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>

            <input type="hidden" id="borrow_user" name="borrow_user">
            <input type="hidden" id="borrow_id" name="borrow_id">

            <div class="search">
                <button type="button" name="submit_borrow" class="btn" onclick="submitBorrowForm()"><b>ยืมหนังสือ</b></button>
                <button type="button" onclick="clearSearch()" class="btn_c">ยกเลิก</button>
            </div>

            

        </form>
    </div>

    <script>
        function submitBorrowForm() {
            var borrowUser = document.getElementById('search_user').value;
            var borrowId = document.getElementById('search_id').value;

            if (borrowUser.trim() === "" || borrowId.trim() === "") {
                alert("กรุณาระบุผู้ที่ต้องการยืมและรหัสหนังสือ");
                return;
            }

            document.getElementById('borrow_user').value = borrowUser;
            document.getElementById('borrow_id').value = borrowId;

            document.querySelector('form').action = 'process_borrow.php';
            document.querySelector('form').submit();
        }

        function clearSearch() {
            document.querySelector('input[name="search_user"]').value = '';
            document.querySelector('input[name="search_id"]').value = '';
        }
    </script>


</body>

</html>
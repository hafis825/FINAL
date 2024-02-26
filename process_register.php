$_SESSION['m_user'] = $username;<?php 
    session_start();
    include('config.php');

    $errors = array();

    if (isset($_POST['reg_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['m_user']);
        $password = mysqli_real_escape_string($conn, $_POST['m_pass']);
        $name = mysqli_real_escape_string($conn, $_POST['m_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['m_phone']);


    
        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
        if (empty($name)) {
            array_push($errors, "name is required");
        }
        if (empty($phone)) {
            array_push($errors, "phone is required");
        }

        $user_check_query = "SELECT * FROM tb_member WHERE m_user = '$username'  ";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) {
            if ($result['m_user'] === $username) {
                array_push($errors, "Username already exists");
            }
        }

        if (count($errors) == 0) {
            // $password = md5($password);

            $sql = "INSERT INTO tb_member (m_user, m_pass, m_name, m_phone) VALUES ('$username', '$password', '$name', '$phone')";
            mysqli_query($conn, $sql);

            $sql2 = "INSERT INTO tb_borrow_book (m_user) VALUES ('$username')"; 
            mysqli_query($conn,$sql2);

            $_SESSION['m_user'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } 
    
    }


?>
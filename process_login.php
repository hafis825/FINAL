<?php 
    session_start();
    include('config.php');


    $errors = array();

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        
        if (empty($username) || empty($password)) {
            array_push($errors, "Username and password are required");
        } else {
            // $password = md5($password);
            $query = "SELECT * FROM tb_member WHERE m_user = '$username' AND m_pass = '$password'";
            $result = mysqli_query($conn, $query);
    
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['m_user'] = $username;
                $_SESSION['success'] = "You are now logged in";
                header('location: index.php');
            } else {
                array_push($errors, "Wrong username/password combination");
                $_SESSION['error'] = "Wrong username or password. Please try again!";
                header("location: login.php");
            }
        }
    }
    

?>
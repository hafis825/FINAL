<?php 
    include('config.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniProject | Register</title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    header {
        /* border: 1px solid red; */
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login {
        /* border: 1px solid red; */
        margin: 0 auto;
        max-width: 550px;
        padding-bottom: 1rem;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        outline: none;
        border-radius: 5px;
    }

    button {
        background-color: #292929;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        border-radius: 5px;
        transition: 0.3s;
    }

    button:focus {
        box-shadow: #d8d8d8 0 0 0 1.5px inset, rgba(211, 211, 211, 0.4) 0 2px 4px, rgba(211, 211, 211, 0.3) 0 7px 13px -3px, #e4e4e4 0 -3px 0 inset;
    }

    button:hover {
        box-shadow: rgba(45, 35, 66, 0.3) 0 4px 8px, rgba(45, 35, 66, 0.2) 0 7px 13px -3px, #cecece 0 -3px 0 inset;
        transform: translateY(-2px);
    }

    button:active {
        box-shadow: #D6D6E7 0 3px 7px inset;
        transform: translateY(2px);
    }




    .container {
        padding: 16px;
    }

    span.psw {
        float: right;
        /* padding-top: 16px; */
    }

    .container a {
        color: #292929;
    }
</style>

<body>

    <header>
        <div class="header-info">
            <h1>REGISTER</h1>
        </div>
    </header>

    <section class="login">
        <div class="container">
            <form action="process_register.php" method="post">
                <?php if (isset($_SESSION['error'])) : ?>
                <div class="error">
                    <h3>
                        <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                    </h3>
                </div>
                <?php endif ?>
                <div class="input-group">
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="m_user" required>
                </div>

                <div class="input-group">
                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="m_pass" required>
                </div>

                <div class="input-group">
                    <label for="psw"><b>Name</b></label>
                    <input type="text" placeholder="Enter Name" name="m_name" required>
                </div>

                <div class="input-group">
                    <label for="psw"><b>Phone</b></label>
                    <input type="text" placeholder="Enter Phone" name="m_phone" required>
                </div>


                <div class="input-group">
                    <button type="submit" name="reg_user" class="btn">Register</button>

                </div>




            </form>

            <span class="psw" style="color: #707070;">Already a member? <a href="login.php">Singin</a></span>

        </div>



    </section>

</body>

</html>
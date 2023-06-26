<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
</head>

<body>
    <section>
        <?php
        if (isset($_POST['submit'])) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            $passwordRepeat = filter_input(INPUT_POST, 'repeat-password', FILTER_SANITIZE_SPECIAL_CHARS);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            require_once '../database/database.php';

            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                echo " <script> alert('Email này đã được sử dụng') </script> ";
            } else {
                if (empty($username)) {
                    echo " <script> alert('Vui lòng nhập tên') </script> ";
                } else if (empty($email)) {
                    echo " <script> alert('Vui lòng nhập email') </script> ";
                } else if (empty($password)) {
                    echo " <script> alert('Vui lòng nhập password') </script> ";
                } else if (empty($passwordRepeat)) {
                    echo " <script> alert('Vui lòng nhập lại password') </script> ";
                } else {
                    $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash);
                        mysqli_stmt_execute($stmt);
                        echo " <script>alert('Bạn đã đăng ký thành công')</script> ";
                    }
                }
            }
        }
        ?>
        <div class="form-box">
            <div class="form-value">
                <form action=" <?php htmlspecialchars($_SERVER['PHP_SELF']) ?> " method="post">
                    <h2>Sign up</h2>

                    <div class="form-group">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="username">
                        <label for="">Username</label>
                    </div>
                    <div class="form-group">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email">
                        <label for="">Email</label>
                    </div>
                    <div class="form-group">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password">
                        <label for="">Password</label>
                    </div>
                    <div class="form-group">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="repeat-password">
                        <label for="">Password repeat</label>
                    </div>


                    <button type="submit" name="submit">Sign up</button>

                    <div class="register">
                        <p>You have a account <a href="./login.php">Log in</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</html>
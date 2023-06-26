<?php
session_start();
if (isset($_SESSION["user"])) {
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
        <div class="form-box">
            <?php
            if (isset($_POST['submit'])) {
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                require_once '../database/database.php';
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        session_start();
                        $_SESSION['user'] = 'yes';
                        header('Location: index.php');
                        die();
                    }
                }
            }

            ?>
            <div class="form-value">
                <form action=" <?php htmlspecialchars($_SERVER['PHP_SELF']) ?> " method="post">
                    <h2>Log in</h2>

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

                    <div class="forget">
                        <label for="">
                            <input type="checkbox">Remember me
                            <a href="#">Forget password</a>
                        </label>
                    </div>

                    <button type="submit" name="submit">Log in</button>

                    <div class="register">
                        <p>Don't have a account <a href="./registration.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</html>
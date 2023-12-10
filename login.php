<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mate</title>
    <link rel="icon" href="assets/favicon.ico">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
</head>
<body>

    <?php 

    if(isset($_POST['login']) || isset($_POST['edit'])){
        $usr = trim($_POST['user']);
        $pas = trim($_POST['pass']);

        if($usr=='' or $pas==''){
            $error_message = "Data tidak boleh kosong!";

        } else if($usr=='admin' AND $pas=='admin'){
            $_SESSION['user'] = "Administrator";
            echo"<meta http-equiv='refresh' content='0;URL=index.php'>";
        } else {
            $sql = "SELECT count(*) FROM mahasiswa WHERE nim='$usr' AND nama='$pas'";
            $data = mysqli_fetch_row (mysqli_query($koneksi, $sql));
            if ($data[0] != 0) {
                $_SESSION['user']="$pas";
                echo"<meta http-equiv='refresh' content='0;URL=index.php'>";
            }
             else {
                $error_message = "Username dan Password Salah!";
             }
        }

    }

    ?>

    <div class="container">
        <div class="login-container">
            <div class="input-container">
                <div class="logo-container">
                    <img src="assets/brandlogo.svg" alt="">
                    <h1>Login</h1>
                    <span>Enter your account details</span>
                </div>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" name="user" id="login" placeholder="Username">
                        <input type="password" name="pass" id="login" placeholder="Password">
                        <a href="https://wa.me/082158874067" target="_blank">Forgot Password?</a>
                        <div class="error-message" id="error-message"><?php echo $error_message; ?></div>
                    </div>
                    <div class="submit-group">
                        <input type="submit" name="login" value="Login" id="submit">
                    </div>
                </form>
            </div>
        </div>
        <div class="picture">
            <div class="picture-text">
                <span class="title head"><b>Welcome to </b>Student Mate</span><br>
                <span class="sub-title">Login to access your account</span>
            </div>
            <img src="assets/secure-login-animate.svg" alt="">
        </div>
    </div>

</body>
</html>
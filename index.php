<?php 
session_start();
$koneksi = mysqli_connect('localhost', 'root', 'semogabisayok321','latihan');
?>

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
            if(isset($_GET['logout'])){
                unset($_SESSION['user']);
                echo"<meta http-equiv='refresh' content='0;URL=index.php'>";
            } else if(isset($_SESSION['user'])){
                echo"
                <div class='container-home'>
                    <div class='container-right'>
                        <div class='title-home'>
                            <div class='title-container'>
                                <div class='date-container'>
                                    <p id='date'></p>
                                    <p id='clock'></p>
                                </div>
                                <h3>Selamat datang, ".$_SESSION['user']."</h3>
                                <span>Selalu dapatkan informasi terbaru di portal mahasiswa</span>
                            </div>
                            <div class='title-container-left'>
                                <img src='assets/college-students-animate.svg' alt=''>
                            </div>
                            <div class='title-container-left'>
                                <img src='assets/college-class-animate.svg' alt=''>
                            </div>
                        </div>
                    </div>
                </div>
                ";
                echo"
                <div class='menu'>
                        <div class='brandlogo'>
                            <img src='assets/brandlogo.svg' alt=''>
                        </div>
                        <div class='menu-link'>
                            <img src='assets/dashboard.svg' alt=''>
                            <a href='index.php'>Dashboard</a> 
                        </div>
                        <div class='menu-link'>
                            <img src='assets/mahasiswa.svg' alt=''>
                            <a href='index.php?menu=mhs'>Data Mahasiswa</a>
                        </div>
                        <div class='menu-link log'>
                            <img src='assets/logout.svg' alt=''>
                            <a class='log' href='index.php?logout'>Logout</a>
                        </div>
                    </div>";
                    if(isset($_GET['menu']) && $_GET['menu'] === 'mhs'){
                        include"mhs.php";
                    } else{
                        include"crud.php";
                    }
            } else{include"login.php";}
    ?>
    
    <script src="script.js?<?php echo time(); ?>"></script>   

</body>
</html>
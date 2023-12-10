<?php 
session_start();
$koneksi = mysqli_connect('localhost', 'root', 'semogabisayok321','latihan');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <img src="s" alt="">
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
    if(isset($_POST['simpan'])){
        $id = $_POST['idmatkul'];
        $nama = $_POST['namamatkul'];
        $sks = $_POST['sks'];
        $dosen = $_POST['dosen'];
        mysqli_query($koneksi,"INSERT INTO matakuliah (id_matkul,nama_matkul,SKS,dosen_pengampu) VALUES ('$id','$nama','$sks','$dosen')");
        echo "<meta http-equiv='refresh' content='0; url=index.php''>";
        
    } else if(isset($_POST['edit'])){
        $id = $_POST['idmatkul'];
        $nama = $_POST['namamatkul'];
        $sks = $_POST['sks'];
        $dosen = $_POST['dosen'];
        mysqli_query($koneksi,"UPDATE matakuliah SET nama_matkul='$nama', sks='$sks', dosen_pengampu='$dosen' WHERE id_matkul='$id'");
        echo "<meta http-equiv='refresh' content='0; url=index.php''>";

    } else if (isset($_GET['edit'])) {
        $id = $_GET['kode'];
        $sql = "SELECT * FROM matakuliah WHERE id_matkul='$id'";
        $data = mysqli_fetch_row(mysqli_query($koneksi, $sql));

    echo "<form action='' method='POST'>
    <div class='form-container'>
        <h3>Input Data Matakuliah</h3>
        <label for='idmatkul'>Kode Mata Kuliah</label>
        <input type='text' id='idmatkul' name='idmatkul' value='$data[0]'>
        
        <label for='namamatkul'>Nama Mata Kuliah</label>
        <input type='text' id='namamatkul' name='namamatkul' value='$data[1]'>
        
        <label for='sks'>Jumlah SKS</label>
        <input type='text' id='sks' name='sks' value='$data[2]'>

        <label for='dosen'>Dosen Pengampu</label>
        <input type='text' id='dosen' name='dosen' value='$data[3]'>
        
        <input type='submit' name='edit' value='Simpan'>
    </div>
    </form>";

    } else if (isset($_GET['delete'])) {
        $id = $_GET['kode'];
        mysqli_query($koneksi, "DELETE FROM matakuliah WHERE id_matkul = '$id'");
        echo "<meta http-equiv='refresh' content='0; url=index.php''>";
    } else if ($_SESSION['user'] === 'Administrator') {
    ?>  <form action="" method="POST">
            <div class="form-container">
                <h3>Input Data Matakuliah</h3>
                <label for="idmatkul">Kode Mata Kuliah</label>
                <input type="text" id="idmatkul" name="idmatkul">
                
                <label for="namamatkul">Nama Mata Kuliah</label>
                <input type="text" id="namamatkul" name="namamatkul">
                
                <label for="sks">Jumlah SKS</label>
                <input type="text" id="sks" name="sks">

                <label for="dosen">Dosen Pengampu</label>
                <input type="text" id="dosen" name="dosen">
                
                <input type="submit" name="simpan" value="Simpan">
            </div>
        </form>
    <?php }

    $sql = "SELECT * FROM matakuliah ORDER BY id_matkul";

    if ($_SESSION['user'] === 'Administrator') {
        echo "<div class='data-container'>";
        echo "<table class='data-table' id='mytable'>";
        echo "<tr>";
        echo "<th style='text-align: left; width: 80px';>Kode MK</th>";
        echo "<th style='text-align: left;'>Nama Mata Kuliah</th>";
        echo "<th style='text-align: left;'>SKS</th>";
        echo "<th style='text-align: left;'>Dosen Pengampu</th>";
        if($_SESSION['user']=="Administrator"){
            echo "<th style='text-align: left;'>Operasi</th>";
        }
        echo "</tr>";

        if ($result = mysqli_query($koneksi, $sql)) {
            while($data = mysqli_fetch_row($result)){
                echo "<tr class='data-row'>";
                echo "<td align='left' style='width: 55px;'>$data[0]</td>";
                echo "<td align='left''>$data[1]</td>";
                echo "<td align='center'>$data[2]</td>";
                echo "<td align='left' style='width: 240px;'>$data[3]</td>";
                if($_SESSION['user']=="Administrator"){
                    echo "<td align='left' style='width: 100px;'>";
                    echo "<a href='index.php?edit&kode=$data[0]'><img src='assets/icons8-editbox.png' alt=''></a>";
                    echo "<a href='index.php?delete&kode=$data[0]'><img src='assets/icons8-delete.svg' alt=''></a>";
                    echo "</td>";
                }
                echo "</tr>";
            }
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='data-container second'>";
        echo "<table class='data-table' id='mytable'>";
        echo "<tr>";
        echo "<th style='text-align: left; width: 80px';>Kode MK</th>";
        echo "<th style='text-align: left;'>Nama Mata Kuliah</th>";
        echo "<th style='text-align: left;'>SKS</th>";
        echo "<th style='text-align: left;'>Dosen Pengampu</th>";
        if($_SESSION['user']=="Administrator"){
            echo "<th style='text-align: left;'>Operasi</th>";
        }
        echo "</tr>";

        if ($result = mysqli_query($koneksi, $sql)) {
            while($data = mysqli_fetch_row($result)){
                echo "<tr class='data-row'>";
                echo "<td align='left' style='width: 55px;'>$data[0]</td>";
                echo "<td align='left''>$data[1]</td>";
                echo "<td align='center'>$data[2]</td>";
                echo "<td align='left' style='width: 240px;'>$data[3]</td>";
                if($_SESSION['user']=="Administrator"){
                    echo "<td align='left' style='width: 100px;'>";
                    echo "<a href='index.php?edit&kode=$data[0]'><img src='assets/icons8-editbox.png' alt=''></a>";
                    echo "<a href='index.php?delete&kode=$data[0]'><img src='assets/icons8-delete.svg' alt=''></a>";
                    echo "</td>";
                }
                echo "</tr>";
            }
        }
        echo "</table>";
        echo "</div>";
    }

    ?>

    <script src="script.js"></script>  
    
</body>
</html>
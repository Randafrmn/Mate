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

        $usr = $_POST['nim'];
        $pass = $_POST['nama'];
        $nomor = $_POST['nomor'];
        $jenis = $_POST['jenis'];
        $foto = $_FILES['foto']['name'];

        $folder = "uploads/";
        $tmpFile = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmpFile, $folder.$foto);

        mysqli_query($koneksi,"INSERT INTO mahasiswa (nim,nama,nomor_telepon,jenis_kelamin,foto) VALUES ('$usr','$pass','$nomor','$jenis','$foto')");
        echo "<meta http-equiv='refresh' content='0; url=index.php?menu=mhs'>";
        
    } else if(isset($_POST['edit'])){
        $usr = $_POST['nim'];
        $pass = $_POST['nama'];
        $nomor = $_POST['nomor'];
        $jenis = $_POST['jenis'];

        $foto = $_FILES['foto']['name'];

        if (!empty($foto)) {
            $folder = "uploads/";
            $tmpFile = $_FILES['foto']['tmp_name'];
            move_uploaded_file($tmpFile, $folder.$foto);
        } else {
            $result = mysqli_query($koneksi, "SELECT foto FROM mahasiswa WHERE nim = '$usr'");
            $row = mysqli_fetch_assoc($result);
            $foto = $row['foto'];
        }

        mysqli_query($koneksi,"UPDATE mahasiswa SET nim='$usr',nama='$pass', nomor_telepon='$nomor', jenis_kelamin='$jenis', foto='$foto' WHERE nim='$usr'");

        if($_SESSION['user']!="Administrator"){
            $_SESSION['user'] = $pass;
        }

        echo "<meta http-equiv='refresh' content='0; url=index.php?menu=mhs'>";

    } else if (isset($_GET['edit']) && $_SESSION['user'] === 'Administrator') {
        $usr = $_GET['kode'];
        $sql = "SELECT * FROM mahasiswa WHERE nim='$usr'";
        $data = mysqli_fetch_row(mysqli_query($koneksi, $sql));
        echo "<form action='' method='POST' enctype='multipart/form-data'>
        <div class='form-container mhs'>
            <h3>Input Data Mahasiswa</h3>
            <label for='nim'>NIM</label>
            <input type='text' id='nim' name='nim' value='$data[0]'>
            
            <label for='nama'>Nama Mahasiswa</label>
            <input type='text' id='nama' name='nama' value='$data[1]'>

            <label for='ttl'>Nomor Telepon</label>
            <input type='text' id='ttl' name='nomor' value='$data[2]'>

            <label id='jenis' for='jenis'>Jenis Kelamin</label>
            <div class='gender'>
                <label id='jeniskelamin' for='laki-laki'>Laki-laki</label>";
                echo "<input type='radio' id='laki-laki' name='jenis' value='Laki-Laki'" . ($data[3] === 'Laki-Laki' ? ' checked' : '') . ">";
                echo "<label id='jeniskelamin' for='perempuan'>Perempuan</label>";
                echo "<input type='radio' id='perempuan' name='jenis' value='Perempuan'" . ($data[3] === 'Perempuan' ? ' checked' : '') . ">";
                echo "</div>
            
            <label for='image'>Masukkan Foto</label>
            <input type='file' id='image' name='foto' value='$data[4]' accept='image/*''>
        
            <input type='submit' name='edit' value='Simpan'>
        </div>
        </form>";

    } else if (isset($_GET['edit'])){
        $usr = $_GET['kode'];
        $sql = "SELECT * FROM mahasiswa WHERE nim='$usr'";
        $data = mysqli_fetch_row(mysqli_query($koneksi, $sql));
        
        echo "<form action='' method='POST' enctype='multipart/form-data'>
        <div class='form-container mhs-second'>
            <h3>Input Data Mahasiswa</h3>
            <label for='nim'>NIM</label>
            <input type='text' id='nim' name='nim' value='$data[0]'>
            
            <label for='nama'>Nama Mahasiswa</label>
            <input type='text' id='nama' name='nama' value='$data[1]'>

            <label for='ttl'>Nomor Telepon</label>
            <input type='text' id='ttl' name='nomor' value='$data[2]'>

            <label id='jenis' for='jenis'>Jenis Kelamin</label>
            <div class='gender'>
                <label id='jeniskelamin' for='laki-laki'>Laki-laki</label>
                <input type='radio' id='laki-laki' name='jenis' value='Laki-Laki'" . ($data[3] === 'Laki-Laki' ? ' checked' : '') . ">
                <label id='jeniskelamin' for='perempuan'>Perempuan</label>
                <input type='radio' id='perempuan' name='jenis' value='Perempuan'" . ($data[3] === 'Perempuan' ? ' checked' : '') . ">
            </div>

            <label for='image'>Masukkan Foto</label>
            <input type='file' id='image' name='foto' value='$data[4]' accept='image/*'>
        
            <input type='submit' name='edit' value='Simpan'>
        </div>
        </form>";

    } else if (isset($_GET['delete'])) {
        $usr = $_GET['kode'];

        $result = mysqli_query($koneksi, "SELECT foto FROM mahasiswa WHERE nim = '$usr'");
        $row = mysqli_fetch_assoc($result);
        $namaFileFoto = $row['foto'];

        mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE nim = '$usr'");

        if ($namaFileFoto !== null) {
            $fileYangAkanDihapus = "uploads/" . $namaFileFoto;

            if (file_exists($fileYangAkanDihapus)) {
                unlink($fileYangAkanDihapus);
                echo "File $fileYangAkanDihapus berhasil dihapus.";
            } else {
                echo "File $fileYangAkanDihapus tidak ditemukan.";
            }
        }

        echo "<meta http-equiv='refresh' content='0; url=index.php?menu=mhs''>";

    } else if ($_SESSION['user'] === 'Administrator') {
    ?>  
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-container mhs">
                <h3>Input Data Mahasiswa</h3>
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim">
                
                <label for="nama">Nama Mahasiswa</label>
                <input type="text" id="nama" name="nama">

                <label for="ttl">Nomor Telepon</label>
                <input type="text" id="ttl" name="nomor">

                <label id="jenis" for="jenis">Jenis Kelamin</label>
                <div class="gender">
                    <label id="jeniskelamin" for="laki-laki">Laki-Laki</label>
                    <input type="radio" id="laki-laki" name="jenis" value="Laki-laki">
                    <label id="jeniskelamin" for="perempuan">Perempuan</label>
                    <input type="radio" id="perempuan" name="jenis" value="Perempuan">
                </div>

                <label for="image">Masukkan Foto</label>
                <input type="file" id="image" name="foto" accept="image/*" required>

                <input type="submit" name="simpan" value="Simpan">
            </div>
        </form>
            
    <?php }

        $usr = $_SESSION['user'];
        $sql = "SELECT * FROM mahasiswa ORDER BY (nama = '$usr') DESC, tanggal desc";

        if ($_SESSION['user'] === 'Administrator') {
            echo "<div class='data-container'>";
            echo "<table class='data-table' id='mytable'>";
            echo "<tr>";
            echo "<th style='text-align: left;'>NIM</th>";
            echo "<th style='text-align: left;'>Nama</th>";
            echo "<th style='text-align: center;'>Nomor</th>";
            echo "<th style='text-align: center;'>Gender</th>";
            echo "<th style='text-align: center;'>Foto</th>";
            echo "<th style='text-align: left;'>Operasi</th>";
            echo "</tr>";
            if ($result = mysqli_query($koneksi, $sql)) {
                while($data = mysqli_fetch_row($result)){
                    echo "<tr>";
                    echo "<td align='left'>$data[0]</td>";
                    echo "<td align='left'>$data[1]</td>";
                    echo "<td align='center'>$data[2]</td>";
                    echo "<td align='center'>$data[3]</td>";
                    echo "<td align='center'><img src='uploads/$data[4]' alt='Foto Profil' style='width: 80px; height: 80px; border-radius: 3px;'></td>";
                    echo "<td align='left' style='width: 100px;'>";
                    if($_SESSION['user']=="Administrator" || $_SESSION['user']== $data[1]){
                        echo "<a href='index.php?menu=mhs&edit&kode=$data[0]'><img src='assets/icons8-editbox.png' alt=''></a>";
                    } 
                    
                    if($_SESSION['user']=="Administrator"){
                        echo "<a href='index.php?menu=mhs&delete&kode=$data[0]'><img src='assets/icons8-delete.svg' alt=''></a>";
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
            echo "<th style='text-align: left;'>NIM</th>";
            echo "<th style='text-align: left;'>Nama</th>";
            echo "<th style='text-align: center;'>Nomor</th>";
            echo "<th style='text-align: center;'>Gender</th>";
            echo "<th style='text-align: center;'>Foto</th>";
            echo "<th style='text-align: left;'>Operasi</th>";
            echo "</tr>";
            if ($result = mysqli_query($koneksi, $sql)) {
                while($data = mysqli_fetch_row($result)){
                    echo "<tr>";
                    echo "<td align='left'>$data[0]</td>";
                    echo "<td align='left'>$data[1]</td>";
                    echo "<td align='center'>$data[2]</td>";
                    echo "<td align='center'>$data[3]</td>";
                    echo "<td align='center'><img src='uploads/$data[4]' alt='Foto Profil' style='width: 80px; height: 80px; border-radius: 3px;'></td>";
                    echo "<td align='left' style='width: 100px;'>";
                    if($_SESSION['user']=="Administrator" || $_SESSION['user']== $data[1]){
                        echo "<a href='index.php?menu=mhs&edit&kode=$data[0]'><img src='assets/icons8-editbox.png' alt=''></a>";
                    } 
                    
                    if($_SESSION['user']=="Administrator"){
                        echo "<a href='index.php?menu=mhs&delete&kode=$data[0]'><img src='assets/icons8-delete.svg' alt=''></a>";
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            }
            echo "</table>";
            echo "</div>";

        }
    ?>

    <script src="script.js?<?php echo time(); ?>"></script> 

</body>
</html>
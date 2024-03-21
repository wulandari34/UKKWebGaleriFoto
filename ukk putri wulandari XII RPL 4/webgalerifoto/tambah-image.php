<?php
    session_start();
    include 'db.php';
    if ($_SESSION['status_login'] != true) {
        echo '<script>window.location="login.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEB Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style>
        header {
            background-color: #6eedc7;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            text-decoration: none;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            display: inline-block;
            margin-right: 15px;
        }

        ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        .section {
            padding: 40px 0;
        }

        h3 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 700px;
            margin: 0 auto;
            animation: fadeIn 1s ease-in-out;
        }

        .input-control {
            position: relative;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Add this CSS to center the submit button */
.form-container {
    text-align: center;
}

.btn {
    display: inline-block; /* Change from block to inline-block */
    width: 20%;
    padding: 10px;
    background-color: #6eedc7;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #4bbf8b;
}



        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">WEB GALERY FOTO</a></h1>
            <ul>
                <li><a href="dashboard.php">Album</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="data-image.php">Data Foto</a></li>
                <li><a href="Keluar.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Tambah Data Foto</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php
                    $result = mysqli_query($conn, "select * from tb_category");
                    $jsArray = "var prdName = new Array();\n";
                    echo '<select class="input-control" name="kategori" onchange="document.getElementById(\'prd_name\').value = prdName[this.value]" required>';
                    echo '<option>-Pilih Kategori Foto-</option>';
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                        $jsArray .= "prdName['" . $row['category_id'] . "'] = '" . addslashes($row['category_name']) . "';\n";
                    }
                    echo '</select>';
                    ?>
                    <input type="hidden" name="nama_kategori" id="prd_name">
                    <input type="hidden" name="adminid" value="<?php echo $_SESSION['a_global']->admin_id ?>">
                    <input type="text" name="namaadmin" class="input-control" value="<?php echo $_SESSION['a_global']->admin_name ?>" readonly="readonly">
                    <input type="text" name="nama" class="input-control" placeholder="Nama Foto" required>
                    <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea><br />
                    <input type="file" name="gambar" class="input-control" required>
                    <select class="input-control" name="status">
                        <option value="">--Pilih--</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    // print_r($_FILES[gambar]);
                    // menampung inputan dari form
                    $kategori  = $_POST['kategori'];
                    $nama_ka   = $_POST['nama_kategori'];
                    $ida       = $_POST['adminid'];
                    $user      = $_POST['namaadmin'];
                    $nama      = $_POST['nama'];
                    $deskripsi = $_POST['deskripsi'];
                    $status    = $_POST['status'];

                    // menampung data file yang diupload
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

                    $newname = 'foto' . time() . '.' . $type2;

                    // menampung data format file yang diizinkan
                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                    // validasi format file
                    if (!in_array($type2, $tipe_diizinkan)) {
                        // jika format file tidak ada di dalam tipe diizinkan
                        echo '<script>alert("Format file tidak diizinkan")</script>';
                    } else {
                        // jika format file sesuai dengan yang ada di dalam array tipe diizinkan
                        // proses upload file sekaligus insert ke database
                        move_uploaded_file($tmp_name, './foto/' . $newname);

                        $insert = mysqli_query($conn, "INSERT INTO tb_image VALUES (
                                    null,
                                    '" . $kategori . "',
                                    '" . $nama_ka . "',
                                    '" . $ida . "',
                                    '" . $user . "',
                                    '" . $nama . "',
                                    '" . $deskripsi . "',
                                    '" . $newname . "',
                                    '" . $status . "',
                                    null
                                        ) ");

                        if ($insert) {
                            echo '<script>alert("Tambah Foto berhasil")</script>';
                            echo '<script>window.location="data-image.php"</script>';
                        } else {
                            echo 'gagal' . mysqli_error($conn);
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2024 - Web Galeri Foto.</small>
        </div>
    </footer>
    <script>
        CKEDITOR.replace('deskripsi');
    </script>
    <script type="text/javascript"><?php echo $jsArray; ?></script>
</body>
</html>

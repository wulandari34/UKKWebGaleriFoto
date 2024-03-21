<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEB Galeri Foto - Registrasi Akun</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://kit.fontawesome.com/ce3e6003c9.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ccc;
        }

        header {
            background-color: #6eedc7;
            padding: 10px 0;
            color: #fff;
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
            padding: 20px;
            max-width: 400px;
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

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ccc;
        }

        .btn-container {
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
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
            <h1><a href="index.php">WEB GALERY FOTO</a></h1>
            <ul>
                <li><a href="galeri.php">Galeri</a></li>
                <li><a href="registrasi.php">Registrasi</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </header>
    
    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Registrasi Akun</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama User" class="input-control" required>
                    <input type="text" name="user" placeholder="Username" class="input-control" required>
                  
                    <div style="position: relative;">
                <input type="password" name="pass" placeholder="Password" class="input-control" id="password">
                <span class="eye-icon" onclick="togglePasswordVisibility()">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
           
                    <input type="text" name="tlp" placeholder="Nomor Telpon" class="input-control" required>
                    <input type="text" name="email" placeholder="E-mail" class="input-control" required>
                    <input type="text" name="almt" placeholder="Alamat" class="input-control" required>
                    <div class="btn-container">
                        <input type="submit" name="submit" value="Submit" class="btn">
                    </div>
                </form>
                    <?php
                    include 'db.php';

                    if(isset($_POST['submit'])){
                        $nama = ucwords($_POST['nama']);
                        $username = $_POST['user'];
                        $password = $_POST['pass'];
                        $telpon = $_POST['tlp'];
                        $mail = $_POST['email'];
                        $alamat = ucwords($_POST['almt']);
                        
                        $insert = mysqli_query($conn, "INSERT INTO tb_admin VALUES (
                                                null,
                                                '".$nama."',
                                                '".$username."',
                                                '".$password."',
                                                '".$telpon."',
                                                '".$mail."',
                                                '".$alamat."')
                                                ");
                        if($insert){
                            echo '<script>alert("Registrasi berhasil")</script>';
                            echo '<script>window.location="login.php"</script>';
                        } else {
                            echo 'Gagal '.mysqli_error($conn);
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
         function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.querySelector(".eye-icon i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>

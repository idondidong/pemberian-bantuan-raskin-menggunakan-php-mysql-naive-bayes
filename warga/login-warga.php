<?php
session_start();
if (isset($_SESSION['user'])) {
    session_destroy();
}
include "../koneksi.php";
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="main.css"/>
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body class="loginpage">
<div class="wrap">
    <div class="login">
        <h1>Login</h1>
        <?php
        if (isset($_POST['submit'])) {
            $query = mysqli_query($koneksi, "select * from warga where kepala_rumah_tangga ='".$_POST['kepala_rumah_tangga']."' and noktp=md5('".$_POST['noktp']."')");
            if (mysqli_num_rows($query) > 0) {
                $data = mysqli_fetch_array($query);
                $_SESSION['user'] = $data['kepala_rumah_tangga'];
                header('location:home-warga.php');
            } else {
                echo "<p class='text-error'>Username dan password salah...</p>";
            }
        }
        ?>
        <form method="post">
        <div class="form-group">
            <label for="username">Nama</label>
            <input type="text" name="kepala_rumah_tangga" class="form-control" id="kepala_rumah_tangga" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">No KTP</label>
            <input type="password" name="noktp" class="form-control" id="noktp" placeholder="Password">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['user']))
  header("location:log.php");
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" lang="id">
    <title>Bayes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="main.css"/>
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

  

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="#">Naive Bayes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class='nav-item'>
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>

    <?php 
      $level = $_SESSION['level'];
        
      if ($level == '0') {
         echo "
      

      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#'' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          Data
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
          <a class='dropdown-item' href='data_awal.php'>Data Awal</a>
          <a class='dropdown-item' href='preprocessing.php'>Preprocessing/Normalisasi</a>
          <a class='dropdown-item' href='aturan.php'>Aturan</a> 
          
      </li>

      
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#'' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          Training
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
          <a class='dropdown-item' href='dataset_latih.php'>Data Training</a>
          <a class='dropdown-item' href='hitung_latih.php'>Hitung Algoritma Bayes</a>
          <a class='dropdown-item' href='reset-perhitungan_latih.php'>Reset Perhitungan</a> 
          <div class='dropdown-divider'></div>
          <a class='dropdown-item' href='tabel-probabilitas_latih.php'>Tabel Probabilitas</a>
        <!--<a class='dropdown-item' href='tabel-bayes_latih.php'>Tabel Perhitungan Bayes</a> 
           <a class='dropdown-item' href='tabel-hasil_latih.php'>Tabel Matrix Confusion</a>-->
        </div>
      </li>

      
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#'' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          Testing
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
          <a class='dropdown-item' href='dataset.php'>Data Uji</a>
          <a class='dropdown-item' href='hitung.php'>Hitung Data Testing</a>
          <a class='dropdown-item' href='reset-perhitungan.php'>Reset Perhitungan</a>
          <div class='dropdown-divider'></div>
          <!-- <a class='dropdown-item' href='tabel-probabilitas.php'>Tabel Probabilitas</a>-->
          <a class='dropdown-item' href='tabel-bayes.php'>Tabel Perhitungan Bayes</a>
          <a class='dropdown-item' href='tabel-hasil.php'>Tabel Matrix Confusion</a>
        </div>
      </li>

      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#'' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          Survei Warga
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
          
          <a class='dropdown-item' href='data-warga.php'>Data Warga Hasil Survei</a>
          <a class='dropdown-item' href='klasifikasi.php'>Klasifikasi</a>
          <div class='dropdown-divider'></div>
          <a class='dropdown-item' href='data-warga-klasifikasi.php'>Hasil Klasifikasi</a>
          <div class='dropdown-divider'></div>
          <a class='dropdown-item bg-danger font-weight-bold' href='log-klasifikasi.php'>Untuk Pengembangan (data latih) next</a>
          
        </div>
      </li>

    
      <li class='nav-item'>
        <a class='nav-link' href='logout.php'>Logout</a>
      </li>

    
"; 
      } else if ($level == 1){
                echo "

  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item'>
        <a class='nav-link' href='warga.php'>Data Pribadi <span class='sr-only'>(current)</span></a>
      </li>
      

 
      <li class='nav-item'>
        <a class='nav-link' href='logout.php'>Logout</a>
      </li>
    </ul>
  "; 
      }
     ?>
 
</ul>

</div>
<div class="navbar-text pull-right"><?php echo date('l, d-m-Y  H:i:s a'); ?> </div>
</div>


</nav>
<div class="wrap">
<div class="container">

<!-- <a class='dropdown-item' href='tambah-warga.php'>Survei Warga</a> -->


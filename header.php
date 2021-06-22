<?php include "koneksi.php";  

  session_start();
  if(!isset($_SESSION['id_user'])){
    echo '<script> window.location.replace("login.php");</script>';
  }
  $iduser = $_SESSION['id_user'];
  function rupiah($angka){
	
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    return $hasil_rupiah;
   
  }
  
  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Menjadi Programmer</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="./distribution/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Google fonts - Popppins for copy-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">
    <!-- orion icons-->
    <link rel="stylesheet" href="./distribution/css/orionicons.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="./distribution/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="./distribution/css/custom.css">
    <link rel="stylesheet" href="./distribution/css/datepicker.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="./img/icon/knowledge.png">
    
    <link rel="stylesheet" type="text/css" href="../distribution/DataTables/datatables.min.css"/>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    

  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a href="#" class="sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead"><i class="fas fa-align-left"></i></a><a href="index.php" class="navbar-brand font-weight-bold text-uppercase text-base">Menjadi Prorammer</a>
        <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
                  </ul>
      </nav>
    </header>
    <div class="d-flex align-items-stretch">
      <div id="sidebar" class="sidebar py-3">
        <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">MAIN</div>
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="index.php" class="sidebar-link text-muted <?= $halaman == 'dashboard' ? 'active' : ''; ?> "><i class="o-home-1 mr-3 text-gray"></i><span>Dashboard</span></a></li>
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#master-data" aria-expanded="false" aria-controls="master-data" class="sidebar-link text-muted <?= $halaman ==  'kategori' || $halaman == 'konten' ? 'active' : ''; ?>"><i class="o-database-1 mr-3 text-gray"></i><span>Master Data</span></a>
                <div id="master-data" class="collapse <?= $halaman == 'konten' || $halaman == 'kategori' ? 'show' : ''; ?>">
                <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                    <li class="sidebar-list-item"><a href="kategori.php" class="sidebar-link text-muted pl-lg-5 <?= $halaman == 'kategori' ? 'active' : ''; ?>">Kategori</a></li>
                    <li class="sidebar-list-item"><a href="konten.php" class="sidebar-link text-muted pl-lg-5 <?= $halaman == 'konten' ? 'active' : ''; ?>">Konten</a></li>
                    <li class="sidebar-list-item"><a href="user.php" class="sidebar-link text-muted pl-lg-5 <?= $halaman == 'user' ? 'active' : ''; ?>">User</a></li>
                </ul>
                </div>
            </li>
            <li class="sidebar-list-item"><a href="logout.php" class="sidebar-link text-muted"><i class="o-exit-1 mr-3 text-gray"></i><span>Logout</span></a></li>
            
        </ul>
      </div>

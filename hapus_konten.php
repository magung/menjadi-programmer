<?php
	include "koneksi.php";
	include "functions.php";
	$hapus = mysqli_query($koneksi, "DELETE FROM konten WHERE ID='$_GET[id]'");
	
	// hapus_gambar($_GET['gambarlama']);
	if($hapus){
		header('location:konten.php');
	}
?>
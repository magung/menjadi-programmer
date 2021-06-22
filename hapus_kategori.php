<?php
	include "koneksi.php";
	include "functions.php";
	$hapus = mysqli_query($koneksi, "DELETE FROM kategori WHERE ID='$_GET[id]'");
	
	// hapus_gambar($_GET['gambarlama']);
	if($hapus){
		header('location:kategori.php');
	}
?>
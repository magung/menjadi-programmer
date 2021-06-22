<?php
	include "koneksi.php";
	include "functions.php";
	$hapus = mysqli_query($koneksi, "DELETE FROM akun WHERE ID='$_GET[id]'");
	
	if($hapus){
		header('location:user.php');
	}
?>
<?php
	$host = 'localhost';
	$db   = 'menjadi_programmer';
	$user = 'root';
	$pass = '';

	$koneksi = mysqli_connect($host,$user,$pass,$db);

	if(!$koneksi){
		echo "Koneksi Database Gagal...!!!";
	}
?>
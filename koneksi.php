<?php
	var $host = 'localhost';
	var $db   = 'menjadi_programmer';
	var $user = 'root';
	var $pass = '';

	$koneksi = mysqli_connect($host,$user,$pass,$db);

	if(!$koneksi){
		echo "Koneksi Database Gagal...!!!";
	}
?>
<?php
	mysql_connect('localhost', 'root', '');
	mysql_select_db('ta');

	$num = $_POST["num"];
	$numa = $_POST["numa"];

	$pieces = explode("+", $numa);

	if($num != 0){
		$produktivity = $pieces[2]/$num;
	}else{
		$produktivity = 0;
	}

	$queri 	= "UPDATE insurance2 SET jumlah_teknisi='$num',produktivity='$produktivity' WHERE paket='$pieces[0]' AND hari='$pieces[1]'";
	$hasil 	= mysql_query ($queri);

	echo "Update Sukses";
?>

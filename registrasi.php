<?php
require_once "koneksi.php";

$db = new Database();
$username = "admin";
$password = "password";
$cek = $db->query("SELECT username FROM users WHERE username=? LIMIT 1",[$username]);
if(!$cek){
	$password_hash = password_hash($password ,PASSWORD_DEFAULT);
	$db->execute("INSERT INTO users (username, password) VALUES (?, ?)",[$username, $password_hash]);
	echo "Username ".$username." and Password ".$password." Berhasil dibuat.";
}else{
	echo "Username sudah ada.";
}
?>
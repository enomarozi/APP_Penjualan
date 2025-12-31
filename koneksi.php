<?php
class Database{
	private $host = "localhost";
	private $username = "admin";
	private $password = "password";
	private $dbname = "db_pembelian";
	private $pdo;
	private $stmt;

	public function __construct(){
		$this->connect();
	}

	private function connect(){
		try{
			$dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
			$this->pdo = new PDO($dsn, $this->username, $this->password);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			die("Koneksi gagal: ".$e->getMessage());
		}
	}

	public function query($sql, $params = []){
		$this->stmt = $this->pdo->prepare($sql);
		$this->stmt->execute($params);
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function execute($sql, $params = []){
		$this->stmt = $this->pdo->prepare($sql);
		return $this->stmt->execute($params);
	}

}
?>
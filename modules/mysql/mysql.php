<?php

namespace io;

use PDO, PDOException;

class MySQL
{
	public $dbh = null;

	public $sth = null;

	public function __construct(string $host = null, string $username = null, string $pass = null, string $dbname = null, int $port = null, string $socket = null)
	{
		try {
			$this->dbh = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $username, $pass);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

    	return $this;
	}

	public function __destruct()
	{
		if (!is_null($this->dbh)) {
			$this->dbh = null;
		}

		return $this->dbh;
	}

	public function quote(String $string = '')
	{
		return $this->dbh->quote($string);
	}

	public function prepare(String $sql)
	{
		return $this->sth = $this->dbh->prepare($sql);
	}

	public function query(String $sql = '')
	{
		$this->sth = $this->dbh->query($sql);

		return $this->sth;
	}

    public function select(String $sql = '')
	{
		$this->sth = $this->dbh->query($sql);

		return $this->sth;
	}

    public function insert(String $sql = '')
	{
		$this->sth = $this->dbh->query($sql);

		return $this->lastInsertId();
	}

	public function lastInsertId()
	{
		return $this->dbh->lastInsertId();
	}

	public function getError()
	{
		return $this->sth->errorInfo();
		// $info = self::$sth->errorInfo();
		// return (isset($info[2])) ? 'SQL: ' . $info[2] : null;
	}
}
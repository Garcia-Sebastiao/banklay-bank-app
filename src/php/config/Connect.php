<?php

/**
 * Connect
 *
 * Connecting with database
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 */

class Connect{
    private $host = "localhost";
    private $user = "root";
    private $dbname = "bank-app";
    private $password = "";

    public function getConn()
    {
        try {
            $conn = new \PDO(
                "mysql:host=".$this->host . ";" .
                "dbname=" .$this->dbname,
                $this->user,
                $this->password
            );
            return $conn;
        } catch (PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
        }
    }
}
<?php
class Model
{
    private $host = 'localhost';
    private $dbname = 'glosary';
    private $user = 'root';
    private $password = 'root';
    private $tabl_name = 'test_task';
    private $conn;
    
    public function __construct() 
    { 
        try
        {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
            
        }
          catch(PDOException $e) {
              echo $e->getMessage();
        }
    }
    
    public function __destruct() 
    {
        $this->conn = NULL;
    }
    
    public function addUser($username, $email, $password)
    {
        $data = array(
            ':username' => $username,
            ':email' => $email,
            ':password' => md5($password),
        );
        
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    function validateLogin($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, username, password FROM users WHERE email=:email");


        $stmt->execute([ 'email' => $email ]);

        return $stmt->fetch();
    }

    function checkEmail($email) {
        $sql = "SELECT email FROM users WHERE email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }
}

<?php
class Model
{
    private $host = 'localhost';
    private $dbname = 'glossary';
    private $user = 'root';
    private $password = 'rootroot';
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

    function addCard($theme, $userId) {
        $sql = "INSERT INTO card (theme, userId) VALUES (:theme, :userId)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'theme' => $theme,
            'userId' => $userId
        ]);
        return $this->conn->lastInsertId();
    }

    function addTerm($cardId, $term) {
        try {
            $stmt = $this->conn->prepare("SELECT id FROM term WHERE name=:term");
            $stmt->execute(['term' => $term]);
            $data = $stmt->fetch();
            if ($data) {
                return $data['id'];
            }
            // Insert Term
            $sql = "INSERT INTO term (name, cardId) VALUES (:term, :cardId)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'term' => $term,
                'cardId' => $cardId
            ]);
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        }
    }

    function addTranslate($termId, $lang, $trans, $userId) {
        $sql = "INSERT INTO translate (termId, lang, value, userId) VALUES (:termId, :lang, :value, :userId)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'termId' => $termId,
            'lang' => $lang,
            'value' => $trans,
            'userId' => $userId
        ]);
    }
}

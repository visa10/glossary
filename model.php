<?php

require './config.php';

class Model
{
    private $host = 'localhost';
    private $dbname = 'glossary';
    private $user = 'root';
    private $password = 'root';
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

    function getTernId($term) {
        $stmt = $this->conn->prepare("SELECT id FROM term WHERE name=:term");
        $stmt->execute(['term' => $term]);
        $data = $stmt->fetch();
        if ($data) {
            return $data['id'];
        }
        return false;
    }

    function addTerm($cardId, $term) {
        try {
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
        return $this->conn->lastInsertId();
    }

    function getCards() {
        $sql = "SELECT * FROM card";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getSearchCards($search) {

        $sql = "SELECT * FROM card WHERE theme LIKE :term";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['term' => "%$search%" ]);
        return $stmt->fetchAll();
    }

    function getCard($id) {
        $sql = "SELECT 
                    card.id as cardId,
                    card.theme,
                    #term.id as term,
                    #translate.value as translate,
                    term.id as termId,
                    term.name as term,
                    translate.id as translateId,
                    translate.value,
                    translate.lang
                    #CONCAT(term.id, '-', term.name) as term,
                    #CONCAT(translate.termId, '-', translate.value) as translate
                FROM card 
                LEFT JOIN term ON term.cardId = card.id
                LEFT JOIN translate ON term.id = translate.termId
            WHERE cardId=:id
            #GROUP BY term.id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }
}

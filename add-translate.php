<?php
var_dump($_SESSION['username']); exit;
    if(isset($_SESSION['username'])){
        header("Location: index.php");
    }

    if ($_POST) {
        require "model.php";

        $model = new Model();
        $userId = $_SESSION['userId'];

        print_r($_POST);
    }
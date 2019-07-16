<?php
/**
 * Created by IntelliJ IDEA.
 * User: vss
 * Date: 13.07.19
 * Time: 12:18
 */


$login = false;

if(isset($_SESSION['username'])) {
    $welcome ="Welcome  " . $_SESSION['username'];
    $login = true;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Mini glossary</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/cover/">

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">-->
    <link href="/assets/css/pidie-0.0.8.css" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.js" ></script>
    <script src="/assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">

<header class="masthead ">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3">
        <h1 class="my-0  font-weight-bold mr-5">Mini</h1>
        <nav class="my-2 my-md-0 mr-md-auto ">
            <a class="p-2 " href="/">Home</a>
            <a class="p-2 " href="/glossary.php">Glossary</a>
        </nav>
        <?php
            if (!$login) :
        ?>
            <a class="btn btn-outline-primary login mr-3" href="login.php">Sing up</a>
            <a class="btn btn-outline-primary register" href="register.php">Register</a>
        <?php
            else:
                echo "<div class='mr-3' style='color: #a0a0a0'>$welcome</div>";
        ?>
            <a class="btn btn-outline-primary" href="logout.php" >Logout</a>
        <?php
            endif;
        ?>

    </div>
</header>
<?php


    session_start();
    if(isset($_SESSION['username'])){
        header("location:index.php");
    }

    if ($_POST) {
        require "model.php";

        $model = new Model();


        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $userExists = $model->checkEmail($email);
        if(!$userExists) {
            $res = $model->addUser($username, $email, $password);
            if ($res) {
                echo("true"); exit;
            }

        } else {
            $errMSG = "User exists";
        }
    }

    include "components/header.php"
?>

<main role="main" class="inner cover">
    <form class="form-signin" id="register-form" name="register" method="post">

        <h1 class="h3 mb-3 font-weight-normal">Create Account</h1>
        <?php
        if (isset($errMSG)) { ?>
            <div class="form-group">
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            </div>
            <?php
        }
        ?>
        <div id="message"></div>

        <input name="username" type="name" class="form-control has-error" placeholder="Name" required>
        <input name="email" type="email" class="form-control" placeholder="Email ID" required>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
        <input name="retypepwd" type="password" class="form-control" placeholder="Re-Type Password" required>
        <button name="Submit" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>



    </form>
</main>

<script src="/assets/js/register.js"></script>

<?php
    include "components/footer.php"
?>
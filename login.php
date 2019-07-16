
<?php
    session_start();

    if(isset($_SESSION['username'])){
        header("Location: index.php");
    }

    if ($_POST) {
        require "model.php";

        $model = new Model();

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $password = md5($password); // password hashing using SHA256
        $res = $model->validateLogin($email, $password);

        if ($res) {
            if ($res['password'] === $password) {
                $_SESSION['userId'] = $res['id'];
                $_SESSION['username'] = $res['username'];

                header("Location: index.php");
            } else {
                $errMSG = "Bad password";
            }
        } else {
            // todo error
            $errMSG = "User not found";
        }
    }

    include "components/header.php"
?>

<main role="main" class="inner cover">
    <form class="form-signin" action="login.php" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

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

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" class="form-control" name="email" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</main>

<?php
    include "components/footer.php"
?>

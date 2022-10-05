<?php

    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        header("location: welcome.php");
    }
    require_once 'config.php';
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validating the username
        if (empty(trim($_POST["username"]))){
            $username_err = "Username cannot be blank!";
        }else{
            $sql = "SELECT id FROM users WHERE username=?";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = trim($_POST["username"]);

                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 1){
                        $username_err = "This username is alrady taken!";
                    }else{
                        $usermame = trim($_POST["username"]);
                    }
                }else{
                    echo "Something went wrong...";
                }
            }
        }
        
        // Validating the password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Password cannot be blank!";
        }elseif (strlen(trim($_POST["password"])) < 5){
            $password_err = "Password cannot be less than 5 characters!";
        }else{
            $password = trim($_POST["password"]);
        }
        
        // Validating the confirm password
        if (trim($_POST["password"]) != trim($_POST["confirm_password"])){
            $password_err = "Passwords should match!";
        }
        
        // If the errors are empty, then create a new record of the user
        if(empty($usermame_err) && empty($password_err) && empty($confirm_password_err)) {
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_passwword);
                
                $param_username = $usermame;
                $param_passwword = password_hash($password, PASSWORD_DEFAULT);
                
                if (mysqli_stmt_execute($stmt)) {
                    header("location: login.php");
                }
                else{
                    echo "Something went wrong... cannot redirect!";
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Register - PHP Login System</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="register.php">PHP Login System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container my-3">
        <h1>Please register here</h1>
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Address 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" id="inputCity">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputState">State</label>
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="text" class="form-control" id="inputZip">
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>
<?php
ob_start();
session_start();

require_once('config/database.php');
$koneksi = Database::getInstance()->getConnection();

// Check if the user is already logged in, redirect to the dashboard
if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
    header("location:index.php?page=dashboard");
    exit;
}

// Handle form submission for login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the username exists
    $sql = $koneksi->query("SELECT * FROM tb_user WHERE username='$username'");
    $data = $sql->fetch_assoc();

    // Verify the password and check user level
    if ($sql->num_rows > 0 && password_verify($password, $data['password'])) {
        if ($data['level'] == "admin") {
            $_SESSION['admin'] = $data['id']; // Admin session
        } elseif ($data['level'] == "user") {
            $_SESSION['user'] = $data['id']; // User session
            $_SESSION['id_anggota'] = $data['id_anggota']; // Store user's ID
        }
        // Redirect to the dashboard
        header("location:index.php?page=dashboard");
        exit;
    } else {
        // Show an error if login fails
        echo "<script>alert('Login Failed, Incorrect Username or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <!-- Bootstrap and other stylesheets -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <br /><br />
                <h2>Login Page</h2>
                <br />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Enter Username and Password</strong>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Your Username" required />
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Your Password" required />
                            </div>
                            <input type="submit" name="login" value="Login" class="btn btn-primary" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript scripts -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>
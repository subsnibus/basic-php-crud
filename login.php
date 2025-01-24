<?php
/* `session_start();` is a PHP function that initializes a new session or resumes the existing session
based on a session identifier passed via a GET or POST request, or a cookie. Sessions are a way to
store information (in variables) to be used across multiple pages. This function must be called
before any output is sent to the browser. It is typically used to start a session and allow you to
store and retrieve values associated with a user as they navigate through your website.
Imagine this: After you log in to a system, the system needs to remember few of your informations like your name, email, profile picture or any other necessary information until you log out of the system, so that the system knows that it's actually you who is logged into the system and in cas the system needs to keep track of your activities. */
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'database.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new Database();

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $hashed_password = sha1(md5($password)); // Remember that we hashed the password using both sha1 and md5 functions while registering the user. So, we need to hash the password again here to compare it with the hashed password in the database, as the password is stored in the database in hashed format.
    $result = $conn->select($sql, [$email, $hashed_password]);
    if (!empty($result) && count($result) === 1) { // Check if the result is not empty and only one user is found
        $user = $result[0];
        // Now we are storing the user id and email in the session variable. This will help us to identify the user in the system. Remember that we need to do `session_start();` at the beginning of the file to use the session variables. After we set this session variable, we can use this variable as $_SESSION['user_id'] or $_SESSION['user_email'] in any other file where we have started the session. We can add more session variables as per our requirement.
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php"); // Redirect to the dashboard page after successful login
        exit();
    } else {
        // echo "Invalid Credentials."; // We can display a plain text error message if the user credentials are invalid.
        $_SESSION['error'] = "Invalid Credentials."; // However, instead of displaying a plain text error message, we can store the error message in a session variable and display it on the login page.
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            margin-top: 50px;
        }
        .register-form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-form">
                    <h2 class="text-center">Login</h2>
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <p class="text-center mt-3">
                        Don't have an account? <a href="register.php">Register here</a>
                    </p>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <?= $_SESSION['error']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
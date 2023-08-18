<?php
session_start();

include("../connection1.php");
$error = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if (empty($email)) {
        $email_error = "Valid email is required";
        $error = 1;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format";
        $error = 1;
    }

    if (empty($password)) {
        $password_error = "Please enter password";
        $error = 1;
    } elseif (strlen($password) < 6) {
        $password_error = "Password must be at least 6 characters long";
        $error = 1;
    }


    if ($error == 0) {



        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];

                if ($user['user_type'] == 'admin') {

                    $_SESSION['admin_name'] = $user['name'];
                    header('Location: http://localhost/CRUD/display.php');

                } elseif ($user['user_type'] == 'user') {

                    $_SESSION['user_name'] = $user['name'];
                    header('location: http://localhost/CRUD/admin_user/user.php');
                }

            } else {
                echo "Invalid password";
            }
        } else {
            echo "User not found.";
        }

    } else {
        $msg = "";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
    <title>Login</title>
</head>

<body>





    <section class="vh-100  m-auto pt-2" style="background-color: #f6f2eb;">



        <div class="container-fluid h-100 py-5">
            <div class="card w-80 text-black  " style="border-radius: 1rem;
    width: 80%;
    margin: auto;
    margin-top: 50px;">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="3099609.jpg" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">
                            Login
                        </p>
                        <form method="post" action="login.php">



                            <div class="form-outline mb-4">

                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg"
                                    placeholder="Enter a valid email address" />
                                <span class="text-danger">
                                    <?php if (!empty($email_error)) {

                                        echo $email_error;
                                    } ?>
                                </span>

                            </div>


                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>

                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg" placeholder="Enter password" />
                                <span class="text-danger">
                                    <?php if (!empty($password_error)) {
                                        echo $password_error;
                                    } ?>
                                </span>

                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Checkbox -->
                                <div class="form-check mb-0">
                                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                    <label class="form-check-label" for="form2Example3">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#!" class="text-body">Forgot password?</a>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" value="Login" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>


                                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a
                                        href="http://localhost/CRUD/register/signup.php"
                                        class="link-danger">Register</a>
                                </p>
                            </div>

                        </form>
                        <div class="error text-danger">
                            <?php if (!empty($msg)) {
                                echo $msg;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>

</html>

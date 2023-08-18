<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../bootstrap.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .main-container {
      height: 70% !important;
    }
  </style>
  <title>Signup</title>
</head>

<body>

  <?php
  include("../connection1.php");

  $error = 0;



  if (isset($_POST['register'])) {
    $fname = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    // $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
  
    // Validate name
    if (empty($fname)) {
      $name_error = "Name is required";
      $error = 1;

    } elseif (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
      $name_error = "Only letters are allowed";
      $error = 1;
    }


    if (empty($email)) {
      $email_error = "Valid email is required";
      $error = 1;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Invalid email format";
      $error = 1;
    }


    if (empty($password) || strlen($password) < 6) {
      $password_error = "Password must be at least 6 characters long";
      $error = 1;
    }


    if ($password !== $password_confirmation) {
      $password_confirmation_error = "Passwords does'not match";
      $error = 1;
    }

    // if (empty($user_type)) {
    //   $user_type_error = "Please select a user type";
    //   $error = 1;
    // }
  
    if ($error == 0) {

      $password_hash = password_hash($password, PASSWORD_DEFAULT);


      $query = "INSERT INTO userregister(name, email, password_hash ) VALUES (?, ?, ? )";
      $stmt = mysqli_prepare($conn, $query);

      mysqli_stmt_bind_param($stmt, "sss", $fname, $email, $password_hash);



      // $user_type
  
      if (mysqli_stmt_execute($stmt)) {
        header("Location: http://localhost/CRUD/login/login.php");
        exit();
      } else {
        echo "Failed to insert user.";
      }
      mysqli_stmt_close($stmt);

    } else {
      $msg = "Please fill all fields first";
    }
  }

  // Display errors, if any
  // if (!empty($error)) {
  //   echo "<ul>";
  //   foreach ($error as $errors) {
  //     echo "<li>$errors</li>";
  //   }
  //   echo "</ul>";
  // }
  
  ?>



  <div>

    <section class="vh-100 w-75 m-auto pt-5" style="background-color: white; padding-bottom:50px;">



      <div class="container-fluid h-custom ">
        <div class="row border d-flex justify-content-center align-items-center h-100" style="    margin-top: ;">
          <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="Mobile-login.jpg" class="img-fluid" alt="Sample image">
          </div>
          <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-5">
              Sign up
            </p>
            <!-- action="process-signup.php" -->
            <form class="" method="post" novalidate>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" for="form3Example1c">Your Name</label>
                  <input type="text" id="form3Example1c" name="name" class="form-control" />
                  <span class="text-danger">
                    <?php if (!empty($name_error)) {
                      echo $name_error;
                    } ?>
                  </span>
                </div>
              </div>

              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" for="form3Example3c">Your Email</label>
                  <input type="email" id="form3Example3c" name="email" class="form-control" />
                  <span class="text-danger">
                    <?php if (!empty($email_error)) {
                      echo $email_error;
                    } ?>
                  </span>
                </div>
              </div>

              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" for="form3Example4c">Password</label>
                  <input type="password" id="form3Example4c" name="password" class="form-control" />
                  <span class="text-danger">
                    <?php if (!empty($password_error)) {
                      echo $password_error;
                    } ?>
                  </span>

                </div>
              </div>

              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" for="form3Example4cd">Repeat your password</label>
                  <input type="password" id="form3Example4cd" name="password_confirmation" class="form-control" />
                  <span class="text-danger">
                    <?php
                    if (!empty($password_confirmation_error)) {
                      echo $password_confirmation_error;
                    }
                    ?>
                  </span>
                </div>

              </div>
              <!-- <select name="user_type">
                <option value="user">user</option>
                <option value="admin">admin</option>
              </select> -->

              <!-- <select class="form-select" aria-label="Default select example" name="user_type" style="margin-bottom: 14px;
                          width: 89%;
                          margin-left: 35px;">
                <option selected>Select user type</option>
                <option value="user">user</option>
                <option value="admin">admin</option>

              </select> -->

              <!-- <span class="text-danger">
                
              </span>
              <div class="d-flex flex-row align-items-center mb-3" style="margin-left: 35px;font-size:17px;">
                <label for="signup as" style="margin-right:15px;">Signup As</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="user_type" id="Admin" value="admin">
                  <label class="form-check-label" style="margin-right:10px;" for="Admin">Admin</label>

                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="user_type" id="User" value="user">
                  <label class="form-check-label" for="User">User</label>

                </div>
              </div> -->


              <div class="form-check d-flex justify-content-center mb-3">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                <label class="form-check-label" for="form2Example3">
                  I agree all statements in
                  <a href="#!">Terms of service</a>
                </label>
              </div>

              <div class="d-flex justify-content-start mx-4 mb-3 mb-lg-4">
                <button type="submit" class="btn btn-primary btn-lg" name="register">
                  Register
                </button>
                <p class="small fw-bold mt-2  pt-1 mb-0" style="margin-left: 6px;">Already have an account <a
                    href="http://localhost/CRUD/login/login.php" class="link-danger">login</a></p>
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


      <!-- <footer>
    <div class="text-center p-3 footer-class fixed-bottom" style="background-color: rgba(0, 0, 0, 0.2)">
      © 2023 Copyright:
      <a class="text-white" href="https://copyright.com/">copyright.com</a>
    </div>
  </footer> -->
    </section>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</html>

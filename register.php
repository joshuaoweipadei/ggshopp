<?php 

session_start();

if(isset($_SESSION['userId'])) {
  header('location: index.php');
}

require("./db/db.php");

$errorMessage = "";
$successMessage = "";
$firstname= "";
$email = "";
$password = "";
$verifyPassword = "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regsiter</title>
</head>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_now'])) {
  if(isset($_POST["fullname"]) && isset($_POST["email"]) && isset($_POST["password"])){
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  
    $fullname = test_input($_POST['fullname']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $verifyPassword = test_input($_POST['verPassword']);
    $hash = bin2hex(random_bytes(34));
    $token = md5(mt_rand(0,1000000));
  
    if(empty($fullname) || empty($email) || empty($password)){
      $errorMessage = "All fields are required!";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
      $errorMessage = "Fullname: Invalid cahracter";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errorMessage = "Invalid Email";
    } elseif (strlen($password) < 6) {
      $errorMessage = "Password must be at at least 6 characters or more";
    } elseif ($password != $verifyPassword) {
      $errorMessage = "Passwords do not match";
    } else {
      // Check if user with that email already exists
      $sql = "SELECT * FROM account WHERE email = '$email'";
      $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      if(mysqli_num_rows($query) == 0) {
        $insertSql = "INSERT INTO account (fullname, email, password, hash, token) VALUES ('$fullname', '$email', md5('$password'), '$hash', '$token')";
        $insertQuery = mysqli_query($conn, $insertSql) or die(mysqli_error($conn));
        if($insertQuery){
          $successMessage = "Please check your email and click on the link to activate your account. <a href='login.php'>Go to Login.</a>";
        }
      } else {
        $errorMessage = "User with this email address already exists!";
      }
    }
  }
}

?>
<body>
  <div>
    <form action="" method="post">
      <div>
        <input type="text" name="fullname" class="input_field" placeholder="Full name" value="<?php echo $firstname; ?>" >
      </div>
      <div>
        <input type="text" name="email" class="input_field" placeholder="Enter email" value="<?php echo $email; ?>" >
      </div>
      <div>
        <input type="text" name="password" class="input_field" placeholder="Enter Password" value="<?php echo $password; ?>" >
      </div>
      <div>
        <input type="text" name="verPassword" class="input_field" placeholder="Enter Password Again" value="<?php echo $verifyPassword; ?>" >
      </div>
      <div>
        <button type="submit" class="submit_btn" name="register_now">Register Now</button>
      </div>

      <div class="error"><?php if($errorMessage){ echo $errorMessage; } ?></div>

      <div class="success"><?php if($successMessage){ echo $successMessage; } ?></div>

    </form>
  </div>
</body>
</html>
<?php 

session_start();

if(isset($_SESSION['userId'])) {
  header('location: index.php');
}

require("./db/db.php");

$errorMessage = "";
$successMessage = "";
$email = "";
$password = "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
  if(isset($_POST["email"]) && isset($_POST["password"])){
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
  
    if(empty($email) || empty($password)){
      $errorMessage = "Enter eamil or password";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errorMessage = "Invalid Email";
    } else {
      $sql = "SELECT * FROM account WHERE email = '$email' AND password = md5('$password')";
      $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      $checkQuery = mysqli_num_rows($query);
      if ($checkQuery != 1) {
        $errorMessage = "Incorrect email or password.";
      } else {
        $user = mysqli_fetch_array($query);
        $_SESSION['userId'] = $user['id'];
        $_SESSION['userEmail'] = $user['email'];

        header("Location: index.php");
        exit();
      }
    }
  }
}

?>
<body>
  <div>
    <form action="" method="post">
      <div>
        <input type="text" name="email" class="input_field" placeholder="Enter email" value="<?php echo $email; ?>" >
      </div>
      <div>
        <input type="text" name="password" class="input_field" placeholder="Enter Password" >
      </div>
      <div>
        <button type="submit" class="submit_btn" name="login">Login</button>
      </div>

      <div>
        <p>Register account? <a href="register.php">Register</a></p>
      </div>

      <div class="error"><?php if($errorMessage){ echo $errorMessage; } ?></div>

      <div class="success"><?php if($successMessage){ echo $successMessage; } ?></div>

    </form>
  </div>
</body>
</html>
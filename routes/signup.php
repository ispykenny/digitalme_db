<?php 
	ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
	session_start();
  ob_start();
  
  require '../connection.php';

  $username = $_POST['uid'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $passwordRepeat = $_POST['password_confirmation'];



  // set time of OG signup
  date_default_timezone_set("America/Los_Angeles");
  $date = date("F j, Y , h:i:sa");

  if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
    $result = json_encode(array(
      'result' => 'error',
      'message' => 'Empty input fields'
    ));
    echo $result;
    exit();
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = json_encode(array(
      'result' => 'error',
      'message' => 'Invalid email and or username.'
    ));
    echo $result;
    exit();
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = json_encode(array(
      'result' => 'error',
      'message' => 'Invalid email'
    ));
    echo $result;
    exit();
  } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = json_encode(array(
      'result' => 'error',
      'message' => 'Invalid email and or username.'
    ));
    echo $result;
    exit();
  } else if($password !== $passwordRepeat) {
    $result = json_encode(array(
      'result' => 'error',
      'message' => 'Passwords did not match'
    ));
    echo $result;
    exit();
  }
  else {
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?;";
    $stmt = $conn->prepare($sql);

    if(!$stmt) {  
      $result = json_encode(array(
        'result' => 'error',
        'message' => 'Database error'
      ));
      echo $result;
      exit();
    } else {
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $stmt->store_result();
      $resultCheck = $stmt->num_rows;
      $stmt->bind_result($usernNamed);

      if($resultCheck > 0) {
        $result = json_encode(array(
          'result' => 'error',
          'message' => 'This user name is already taken.'
        ));
        echo $result;
        exit();
      } else {
        $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if(!$stmt) {  
          exit();
        }  else {
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          $stmt->bind_param("sss", $username, $email, $hashedPwd);
          $stmt->execute();
          $stmt->close();
          $result = json_encode(array(
            'user_created' => $username,
            'result' => 'success',
            'message' => 'User generated'
          ));
          echo $result;
        }
      }
    }
  }



mysqli_close($conn);
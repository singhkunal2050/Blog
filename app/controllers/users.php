
<?php

require(ROOT_PATH . '/app/database/db.php');
require(ROOT_PATH . '/app/helpers/validateUser.php');

$table = 'users';
$username = '';
$password = '';
$passwordConf = '';
$email = '';
$errors = array();

function loginUser($user)
{
  $_SESSION['id'] = $user['id'];
  $_SESSION['username'] = $user['username'];
  $_SESSION['admin'] = $user['admin'];
  $_SESSION['message'] = 'You are logged in';
  $_SESSION['type'] = 'success';

  if ($_SESSION['admin']) {
    header('location: ' . BASE_URL . '/dashboard.php');
  } else {
    header('location: ' . BASE_URL . '/index.php');
  }
  exit();
}


if (isset($_POST['register-btn'])) {
  $errors = validateUser($_POST);

  if (count($errors) === 0) {
    unset($_POST['register-btn'], $_POST['passwordConf']);
    $_POST['admin'] = 0;
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $user_id = create($table, $_POST);
    $user = selectOne($table, ['id' => $user_id]);
    // login
    loginUser($user);
  } else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    $email = $_POST['email'];
  }
}

if (isset($_POST['login-btn'])) {
  $errors = validateLogin($_POST);
  if (count($errors) === 0) {
    $user = selectOne($table, ['username' => $_POST['username']]);
    if ($user && password_verify($_POST['password'], $user['password'])) {
      //login and redirext user
      loginUser($user);
    } else {
      // invalid credentials
      array_push($errors, "invalid credentials");
      $username = $_POST['username'];
      $password = $_POST['password'];
    }
  } else {
    // please enter password
    $username = $_POST['username'];
    $password = $_POST['password'];
  }
}

?>
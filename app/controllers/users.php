
<?php

require(ROOT_PATH . '/app/database/db.php');
require(ROOT_PATH . '/app/helpers/validateUser.php');

$table = 'users';
$admin_users = selectAll($table, ['admin' => 1]);            // get all admin users 
$username = '';
$id = '';
$admin = '';
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
    header('location: ' . BASE_URL . '/admin/users/index.php');
  } else {
    header('location: ' . BASE_URL . '/index.php');
  }
  exit();
}


if (isset($_POST['register-btn']) || isset($_POST['create-admin'])) {
  $errors = validateUser($_POST);
  if (count($errors) === 0) {
    unset($_POST['register-btn'], $_POST['passwordConf'], $_POST['create-admin']);
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (isset($_POST['admin'])) {
      $_POST['admin'] = 1;
      $user_id = create($table, $_POST);
      $_SESSION['message'] = 'Admin Created Successfully';
      $_SESSION['type'] = 'success';
      header('location: ' . BASE_URL . '/admin/users/index.php');
      exit();
    } else {
      $_POST['admin'] = 0;
      $user_id = create($table, $_POST);
      $user = selectOne($table, ['id' => $user_id]);
      loginUser($user);
    }
    // login
  } else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    $email = $_POST['email'];
    $admin = isset($_POST['admin']) ? 1 : 0;
  }
}

// update admin 

if (isset($_POST['update-user'])) {
  $errors = validateUser($_POST);
  if (count($errors) === 0) {
    $id = $_POST['id'];
    unset($_POST['id'], $_POST['passwordConf'], $_POST['update-user']);
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $_POST['admin'] = isset($_POST['admin']) ? 1 : 0;
    $count = update($table, $id, $_POST);
    $_SESSION['message'] = 'Admin Updated Successfully';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/users/index.php');
    exit();

  } else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    $email = $_POST['email'];
    $admin = isset($_POST['admin']) ? 1 : 0;
  }
}

/// edit admin

if (isset($_GET['id'])) {
  $user = selectOne($table, ['id' => $_GET['id']]);
  // dd($user);
  $id = $user['id'];
  $username = $user['username'];
  $email = $user['email'];
  $admin = isset($user['admin']) ? 1 : 0;
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

/// delete admin 

if (isset($_GET['delete_id'])) {
  $count = delete($table,  $_GET['delete_id']);
  $_SESSION['message'] = 'Admin Deleted Successfully';
  $_SESSION['type'] = 'success';
  header('location: ' . BASE_URL . '/admin/users/index.php');
  exit();
}



?>
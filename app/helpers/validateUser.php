<?php 

function validateUser($user){
  $errors = array();
  if (empty($user['username'])) {
    array_push($errors, "Please enter username");
  }
  if (empty($user['email'])) {
    array_push($errors, "Please enter Email");
  }
  if (empty($user['password']) || empty($user['passwordConf'])) {
    array_push($errors, "Please enter Password");
  }
  if (!empty($user['password']) &&  !empty($user['passwordConf']) && ($user['password']) !== ($user['passwordConf'])) {
    array_push($errors, "Password Mismatch");
  }
  $existingEmail = selectOne('users',['email'=>$user['email']]);
  if($existingEmail){ 
    array_push($errors , "User with this Email already Exist!!");
  }
  $existingUser = selectOne('users',['username'=>$user['username']]);
  if ($existingUser) {
    if (isset($user['update-user']) && $existingUser['id'] != $user['id']) {
      array_push($errors, "User already Exist!!");
    }
    if (isset($topic['create-admin'])) {
      array_push($errors, "USer already Exist!!");
    }
  }
  return $errors;
}

function validateLogin($user){
  $errors = array();
  if (empty($user['username'])) {
    array_push($errors, "Please enter username");
  }
  if (empty($user['password'])) {
    array_push($errors, "Please enter Password");
  }
  return $errors;
}

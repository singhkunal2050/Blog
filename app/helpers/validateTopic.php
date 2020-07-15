<?php 

function validateTopic($topic){
  $errors = array();
  if (empty($topic['name'])) {
    array_push($errors, "Please enter topic");
  }
  $existingTopic = selectOne('topics',['name'=>$topic['name']]);
  if($existingTopic){ 
    array_push($errors , "Topic already Exist!!");
  }
  return $errors;
}

?>
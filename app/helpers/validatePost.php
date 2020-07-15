<?php

function validatePost($posts){
  $errors = array();
  if (empty($posts['title'])) {
    array_push($errors, "Please enter title");
  }
  if (empty($posts['body'])) {
    array_push($errors, "Please enter body");
  }
  if (empty($posts['topic_id'])) {
    array_push($errors, "Please select a topic");
  }
  $existingPost = selectOne('posts',['title'=>$posts['title']]);
  if($existingPost){ 
    array_push($errors , "Post with same title already exists!!");
  }
  return $errors;
}

?>


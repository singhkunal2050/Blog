<?php

function validateTopic($topic)
{
  $errors = array();
  if (empty($topic['name'])) {
    array_push($errors, "Please enter topic");
  }
  $existingTopic = selectOne('topics', ['id' => $topic['id']]);
  // dd($existingTopic);
  // dd($topic);
  if ($existingTopic) {
    if (isset($_POST['update-topic']) && $existingTopic['id'] != $topic['id'] ) {
      // dd([$topic , $existingTopic]);
      array_push($errors, "Topic already Exist!!");
    }
    if (isset($_POST['save-post'])) {
      array_push($errors , "Topic already Exist!!");
    }
  }


  return $errors;
}

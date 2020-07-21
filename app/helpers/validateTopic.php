<?php

function validateTopic($topic)
{
  $errors = array();
  if (empty($topic['name'])) {
    array_push($errors, "Please enter topic");
  }
  $existingTopic = selectOne('topics', ['name' => $topic['name']]);
  if ($existingTopic) {
    // dd($existingTopic);
    if (isset($topic['update-topic']) && $existingTopic['id'] != $topic['id']) {
      array_push($errors, "Topic already Exist!!");
    }
    if (isset($topic['save-topic'])) {
      array_push($errors, "Topic already Exist!!");
    }
  }


  return $errors;
}

<?php

function validatePost($post)
{
  $errors = array();
  if (empty($post['title'])) {
    array_push($errors, "Please enter title");
  }
  if (empty($post['body'])) {
    array_push($errors, "Please enter body");
  }
  if (empty($post['topic_id'])) {
    array_push($errors, "Please select a topic");
  }
  $existingPost = selectOne('posts', ['title' => $post['title']]);
  if ($existingPost) {
    if (isset($post['update-post']) && $existingPost['id'] != $post['id']) {
      array_push($errors, "Post with same title already exists!!");
    }
    if (isset($post['save-post'])) {
      array_push($errors, "Post with same title already exists!!");
    }
  }
  return $errors;
}

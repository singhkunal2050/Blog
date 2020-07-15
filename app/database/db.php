<?php

session_start();
require('connect.php');


function dd($value)
{
  echo "<pre>" . print_r($value, TRUE) . "</pre>";
  die();
}
// display and die
// on;y for testing

function executeQuery($sql, $data)
{
  global $conn;
  $stmt = $conn->prepare($sql);
  $values = array_values($data);
  $types = str_repeat('s', count($values));
  // dd($sql);
  $stmt->bind_param($types, ...$values);
  $stmt->execute();
  return $stmt;
}

function selectAll($table, $conditions = [])
{
  global $conn;
  $sql = "SELECT * from $table";
  if (empty($conditions)) {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
  } else {
    $i = 0;
    foreach ($conditions as $key => $value) {
      if ($i === 0) {
        $sql = $sql . " WHERE $key = ?";
      } else {
        $sql = $sql . " AND $key = ?";
      }
      $i++;
    }
    $stmt = executeQuery($sql, $conditions);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
  }
}

function selectOne($table, $conditions)
{
  global $conn;
  $sql = "SELECT * from $table";

  $i = 0;
  foreach ($conditions as $key => $value) {
    if ($i === 0) {
      $sql = $sql . " WHERE $key = ?";
    } else {
      $sql = $sql . " AND $key = ?";
    }
    $i++;
  }

  $sql = $sql . ' LIMIT 1';
  $stmt = executeQuery($sql, $conditions);
  $records = $stmt->get_result()->fetch_assoc();
  return $records;
}

function create($table, $data)
{
  global $conn;
  $sql = "INSERT INTO $table SET ";

  $i = 0;
  foreach ($data as $key => $value) {
    if ($i === 0) {
      $sql = $sql . " $key = ?";
    } else {
      $sql = $sql . ", $key = ?";
    }
    $i++;
  }
  $stmt = executeQuery($sql, $data);
  $id = $stmt->insert_id;
  return $id;
}

function update($table, $id, $data)
{
  global $conn;
  $sql = "UPDATE $table SET ";

  $i = 0;
  foreach ($data as $key => $value) {
    if ($i === 0) {
      $sql = $sql . " $key = ?";
    } else {
      $sql = $sql . ", $key = ?";
    }
    $i++;
  }
  $sql = $sql . ' where id=?';
  $data['id'] = $id;
  $stmt = executeQuery($sql, $data);
  return $stmt->affected_rows;
}


function delete($table, $id)
{
  global $conn;
  $sql = "DELETE FROM $table WHERE id=?";
  $stmt = executeQuery($sql, ['id' => $id]);
  return $stmt->affected_rows;
}

$data = [
  'username' => 'sam new',
  'admin' => 0,
  'email' => 'demo@da.com',
  'password' => '122222',
];

// $users = selectAll('users', $data);
// dd($users);

// $new = update('users', 7 , $data);
// $new = delete('users', 7);
// dd($new);

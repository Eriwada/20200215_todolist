<?php
// DB接続関数（PDO）
function connectToDb()
{
  $dbn = 'mysql:dbname=gsacfd05_01;charset=utf8;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';
  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    exit('dbError:' . $e->getMessage());
  }
}

// SQL処理エラー
function showSqlErrorMsg($stmt)
{
  $error = $stmt->errorInfo();
  echo json_encode($error[2]);
  http_response_code(500);
  exit();
}

// $_SESSIONに値をセットする関数
function setSession($key, $value)
{
  session_start();
  $_SESSION[$key] = $value;
  session_write_close();
}

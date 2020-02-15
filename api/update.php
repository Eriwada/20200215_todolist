<?php
// 関数ファイル読み込み
include('functions.php');

// var_dump($_POST);
// var_dump($_GET);
// exit();

if (
  !isset($_POST['task']) || $_POST['task'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == '' ||
  !isset($_GET['id']) || $_GET['id'] == ''
) {
  echo json_encode('param error');
  http_response_code(500);
  exit();
}

$task = $_POST['task'];
$deadline = $_POST['deadline'];
$comment = $_POST['comment'];
$id = $_GET['id'];

//DB接続
$pdo = connectToDb();

// データ更新SQL作成
$sql = 'UPDATE todo_table SET task=:task, deadline=:deadline, comment=:comment, updated_at=sysdate() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':task', $task, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ更新処理後
if ($status == false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  showSqlErrorMsg($stmt);
} else {
  echo json_encode(['msg' => 'Update successful!']);
  exit();
}

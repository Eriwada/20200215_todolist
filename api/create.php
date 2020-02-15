<?php
// 関数ファイル読み込み
include('functions.php');

// 必須項目のチェック
if (
  !isset($_POST['task']) || $_POST['task'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  echo json_encode('param error!');
  http_response_code(500);
  exit();
}

$task = $_POST['task'];
$deadline = $_POST['deadline'];
$comment = $_POST['comment'];

//DB接続
$pdo = connectToDb();

//データ登録SQL作成
$sql = 'INSERT INTO todo_table(id, task, deadline, comment, created_at, updated_at) VALUES(NULL, :task, :deadline, :comment, sysdate(), sysdate())';

// SQL実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':task', $task, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$status = $stmt->execute();

//データ登録処理後
if ($status == false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  showSqlErrorMsg($stmt);
} else {
  echo json_encode(['msg' => 'Create successful!']);
  exit();
}

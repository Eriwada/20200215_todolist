<?php
// 関数ファイル読み込み
include('functions.php');

// GETデータ取得
$id = $_GET['id'];

// DB接続
$pdo = connectToDb();

// 削除SQL作成
$sql = 'DELETE FROM todo_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ削除処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  echo json_encode(['msg' => 'Delete successful!']);
  exit();
}

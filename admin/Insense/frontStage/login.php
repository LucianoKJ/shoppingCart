<?php
session_start();

//引用資料庫連線
require_once('../action/db.inc.php');

if (isset($_POST['username']) && isset($_POST['pwd'])) {

  //SQL 語法
  $sql = "SELECT `username`, `pwd`, `name`
                    FROM `users`
                    WHERE `username` = ? 
                    AND `pwd` = ? ";

  $arrParam = [
    $_POST['username'],
    sha1($_POST['pwd'])
  ];

  $stmt = $pdo->prepare($sql);
  $stmt->execute($arrParam);

  if ($stmt->rowCount() > 0) {
    //取得資料
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header("Refresh: 0; url=./index.php");
    //3 秒後跳頁

    //將傳送過來的 post 變數資料，放到 session，
    $_SESSION['username'] = $arr[0]['username'];
    $_SESSION['name'] = $arr[0]['name'];

    echo "<script>alert('登入成功!!!')</script>";
    exit();
  }

  header("Refresh: 0; url=./index.php");
  echo "<script>alert('登入失敗!!!')</script>";
} else {
  header("Refresh: 0; url=./index.php");
  echo "<script>alert('請確實登入!!!')</script>";
}

<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


//SQL 敘述
$sql = "INSERT INTO `coupon` (`couponName`, `couponMoney`, `Remarks`) 
        VALUES (?, ?, ?)";

//細節用陣列
$arrParam = [
    $_POST['couponName'],
    $_POST['couponMoney'],
    $_POST['Remarks']
];

// echo"<pre>";
// print_r($arrParam);
// echo"</pre>";
// exit();

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./coupon.php");
    echo "新增成功";
    exit();
} else {
    header("Refresh: 3; url=./coupon.php");
    echo "沒有新增資";
    exit();
}
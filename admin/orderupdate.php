<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線



//回傳狀態
$objResponse = [];

//用在繫結 SQL 用的陣列
$arrParam = [];


//SQL 語法
$sql = "UPDATE `orders` SET ";


//itemPrice SQL 語句和資料繫結
$sql.= "`orders`.`orderId` = ? , ";
$arrParam[] = $_POST['orderId'];



$sql.= "`itemName` = ? ,";
$arrParam[] = $_POST['itemName'];
//itemCategoryId SQL 語句和資料繫結
$sql.= "`categoryName` = ?,  ";
$arrParam[] = $_POST['categoryName'];

$sql.= "`checkPrice` = ?,  ";
$arrParam[] = $_POST['checkPrice'];

$sql.= "`checkQty` = ?,  ";
$arrParam[] = $_POST['checkQty'];

$sql.= "`checkSubtotal` = ?  ";
$arrParam[] = $_POST['checkSubtotal'];

$sql.= "WHERE `orders`.`orderId` = ? ";
$arrParam[] = (int)$_POST['orderId'];


$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);



if( $stmt->rowCount()> 0 ){
    header("Refresh: 2; url=./orderedit.php?orderId={$_POST['orderId']}");
    $objResponse['success'] = true;
    $objResponse['code'] = 204;
    $objResponse['info'] = "更新成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 2; url=./orderedit.php?orderId={$_POST['orderId']}");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "沒有任何更新";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
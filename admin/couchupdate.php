<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
    body{
                background: #292B2B !important;
                color:white !important;
                font-family: 微軟正黑體 !important;
            }
          </style>  
</head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();


//回傳狀態
$objResponse = [];

//用在繫結 SQL 用的陣列
$arrParam = [];


//SQL 語法
$sql = "UPDATE `couch` SET ";
//itemName SQL 語句和資料繫結

$sql.= "`c_pwd` = ? ,";
$arrParam[] = sha1($_POST['c_pwd']);

$sql.= "`c_name` = ? ,";
$arrParam[] = $_POST['c_name'];

if ($_FILES["c_img"]["error"] === 0) {
    //為上傳檔案命名
    $strDatetime = "couch_" . date("YmdHis");

    //找出副檔名
    $extension = pathinfo($_FILES["c_img"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $c_img = $strDatetime . "." . $extension;

    //若上傳成功 (有夾帶檔案上傳)，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if (move_uploaded_file($_FILES["c_img"]["tmp_name"], "../images/couch/{$c_img}")) {
        //先查詢出特定 id (itemId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `c_img` FROM `couch` WHERE `c_id` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            (int) $_POST['c_id']
        ];

        //執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        //若有找到 itemImg 的資料
        if ($stmtGetImg->rowCount() > 0) {
            //取得指定 id 的商品資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

            //若是 itemImg 裡面不為空值，代表過去有上傳過
            if ($arrImg[0]['c_img'] !== NULL) {
                //刪除實體檔案
                @unlink("./images/couch/" . $arrImg[0]['c_img']);
            }

            //itemImg SQL 語句字串
            $sql .= "`c_img` = ? ,";

            //僅對 itemImg 進行資料繫結
            $arrParam[] = $c_img;
        }
    }
}


$sql.= "`c_email` = ?, ";
$arrParam[] = $_POST['c_email'];

$sql.= "`c_gender` = ? ,";
$arrParam[] = $_POST['c_gender'];

$sql.= "`c_phoneNumber` = ?, ";
$arrParam[] = $_POST['c_phoneNumber'];

$sql.= "`c_birthday` = ? ,";
$arrParam[] = $_POST['c_birthday'];

$sql.= "`c_address` = ? ";
$arrParam[] = $_POST['c_address'];

$sql.= "WHERE `c_id` = ? ";
$arrParam[] = (int)$_POST['c_id'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if( $stmt->rowCount()> 0 ){
    header("Refresh: 3; url=./couch.php?c_id={$_POST['c_id']}");
    ?><body>
        
    
    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-border text-success" style="margin-top:3px ;width:50px ; height:50px" role="status">
            </div>
            <div class="ml-3" style="font-size: 36px">
                資料更新成功
            </div>
        </div>
    </div></body>
    <?php
    exit();
} else {
    header("Refresh: 3; url=./couchedit.php?c_id={$_POST['c_id']}");
    ?><body>
    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" style="margin-top:3px ;width:50px ; height:50px" role="status">
            </div>
            <div class="ml-3" style="font-size: 36px">
                資料無更新
            </div>
        </div>
    </div>
    </body><?php
    exit();
}
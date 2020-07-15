<?php
require_once('../checkAdmin.php'); //引入登入判斷
require_once('../../db.inc.php'); //引用資料庫連線

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();


//回傳狀態
$objResponse = [];

//用在繫結 SQL 用的陣列
$arrParam = [];


//SQL 語法
$sql = "UPDATE `courses` SET ";

//itemName SQL 語句和資料繫結
$sql.= "`coursesName` = ? ,";
$arrParam[] = $_POST['coursesName'];

if( $_FILES["coursesImg"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = "courses_".date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["coursesImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $coursesImg = $strDatetime.".".$extension;

    //若上傳成功 (有夾帶檔案上傳)，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if( move_uploaded_file($_FILES["coursesImg"]["tmp_name"], "../../images/courses/{$coursesImg}") ) {
        //先查詢出特定 id (itemId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `coursesImg` FROM `courses` WHERE `coursesId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            (int)$_POST['coursesId']
        ];

        //執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        //若有找到 itemImg 的資料
        if($stmtGetImg->rowCount() > 0) {
            //取得指定 id 的商品資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

            //若是 itemImg 裡面不為空值，代表過去有上傳過
            if($arrImg[0]['coursesImg'] !== NULL){
                //刪除實體檔案
                @unlink("../../images/courses/".$arrImg[0]['coursesImg']);
            } 

            //itemImg SQL 語句字串
            $sql.= "`coursesImg` = ? ,";

            //僅對 itemImg 進行資料繫結
            $arrParam[] = $coursesImg;
            
        }
    }
}

//itemPrice SQL 語句和資料繫結
$sql.= "`coursesContent` = ? , ";
$arrParam[] = $_POST['coursesContent'];

//itemQty SQL 語句和資料繫結
$sql.= "`coursesHours` = ? , ";
$arrParam[] = $_POST['coursesHours'];

//itemCategoryId SQL 語句和資料繫結
$sql.= "`coursesCategoryId` = ? ";
$arrParam[] = $_POST['coursesCategoryId'];


$sql.= "WHERE `coursesId` = ? ";
$arrParam[] = (int)$_POST['coursesId'];


$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);


if( $stmt->rowCount()> 0 ){
    header("Refresh: 3; url=./coursesEdit.php?coursesId={$_POST['coursesId']}");
    $objResponse['success'] = true;
    $objResponse['code'] = 204;
    $objResponse['info'] = "更新成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 3; url=./coursesEdit.php?coursesId={$_POST['coursesId']}");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "沒有任何更新";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
<?php
require_once('../checkAdmin.php'); //引入登入判斷
require_once('../../db.inc.php'); //引用資料庫連線

//若沒填寫商品種類時的行為
if( $_POST['coursesCategoryName'] == '' ){
    header("Refresh: 3; url=./coursesCategory.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "請填寫課程種類";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

//新增類別
if( isset($_POST['coursesCategoryId']) ){
    $sql = "INSERT INTO `coursescategory` (`coursesCategoryName`, `coursesCategoryParentId`) VALUES (?,?)";
    $stmt = $pdo->prepare($sql);
    $arrParam = [
        $_POST['coursesCategoryName'], 
        $_POST['coursesCategoryId']
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        header("Refresh: 3; url=./coursesNew.php");
        $objResponse['success'] = true;
        $objResponse['code'] = 200;
        $objResponse['info'] = "新增成功";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    } else {
        header("Refresh: 3; url=./coursesNew.php");
        $objResponse['success'] = false;
        $objResponse['code'] = 400;
        $objResponse['info'] = "新增失敗";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    }

} else {
    $sql = "INSERT INTO `coursescategory` (`coursesCategoryName`) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$_POST['coursesCategoryName']];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        header("Refresh: 3; url=./coursesNew.php");
        $objResponse['success'] = true;
        $objResponse['code'] = 200;
        $objResponse['info'] = "新增成功";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    } else {
        header("Refresh: 3; url=./coursesNew.php");
        $objResponse['success'] = false;
        $objResponse['code'] = 400;
        $objResponse['info'] = "新增失敗";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    }
}
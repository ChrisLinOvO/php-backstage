<?php
require_once('../checkAdmin.php'); //引入登入判斷
require_once('../../db.inc.php'); //引用資料庫連線

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

//回傳狀態
$objResponse = [];

if ($_FILES["coursesImg"]["error"] === 0) {
    //為上傳檔案命名
    $strDatetime = "courses_" . date("YmdHis");

    //找出副檔名
    $extension = pathinfo($_FILES["coursesImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $coursesImg = $strDatetime . "." . $extension;

    //若上傳失敗，則回報錯誤訊息
    if (!move_uploaded_file($_FILES["coursesImg"]["tmp_name"], "../../images/courses/{$coursesImg}")) {
        $objResponse['success'] = false;
        $objResponse['code'] = 500;
        $objResponse['info'] = "上傳圖片失敗";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    }
}

//SQL 敘述
$sql = "INSERT INTO `courses` (`coursesName`, `coursesImg`, `coursesContent`, `coursesHours`, `coursesCategoryId`) 
        VALUES (?, ?, ?, ?, ?)";

//繫結用陣列
$arrParam = [
    $_POST['coursesName'],
    $coursesImg,
    $_POST['coursesContent'],
    $_POST['coursesHours'],
    $_POST['coursesCategoryId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if ($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./coursesPage.php");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 3; url=./coursesPage.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 500;
    $objResponse['info'] = "沒有新增資料";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

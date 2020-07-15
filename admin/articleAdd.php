<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

//回傳狀態
$objResponse = [];

if( $_FILES["articleImg"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = "article_".date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["articleImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $articleImg = $strDatetime.".".$extension;

    //若上傳失敗，則回報錯誤訊息
    if( !move_uploaded_file($_FILES["articleImg"]["tmp_name"], "../images/articles/{$articleImg}") ) {
        $objResponse['success'] = false;
        $objResponse['code'] = 500;
        $objResponse['info'] = "上傳圖片失敗";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    }
}

//SQL 敘述
$sql = "INSERT INTO `articles` (`articleName`, `articleContents`, `articleImg`, `articleCategoryId`) 
        VALUES (?, ?, ?, ?)";

//繫結用陣列
$arrParam = [
    $_POST['articleName'],
    $_POST['articleContents'],
    @$articleImg,
    $_POST['articleCategoryId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if ($stmt->rowCount() > 0) {
    header("Refresh: 1; url=./article.php");
?>
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    新增成功
                </div>
            </div>

        </div>
     
<?php
    exit();
} else {
    header("Refresh: 1; url=./articleNew.php");
?>
  
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    沒有新增資料
                </div>
            </div>

        </div>
    
<?php
    exit();
}
?>
<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

$objResponse = [];

//若沒填寫商品種類時的行為
if( $_POST['articleCategoryName'] == '' ){
    header("Refresh: 3; url=./editArticleCategory.php?editArticleCategoryId={$_POST["editArticleCategoryId"]}");
    $objResponse['success'] = false;
    $objResponse['code'] = 400;
    $objResponse['info'] = "請填寫文章種類";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

$sql = "UPDATE `articleCategories` SET `articleCategoryName` = ? WHERE `articleCategoryId` = ?";
$stmt = $pdo->prepare($sql);
$arrParam = [
    $_POST['articleCategoryName'], 
    $_POST["editArticleCategoryId"]
];
$stmt->execute($arrParam);
if($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./articleCategory.php?editArticleCategoryId={$_POST["editArticleCategoryId"]}");
    ?>
    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
            </div>
            <div class="ml-3 mb-3" style="font-size:36px;">
                更新成功
            </div>
        </div>
    </div>
<?php
    exit();
} else {
    header("Refresh: 3; url=./editArticleCategory.php?editArticleCategoryId={$_POST["editArticleCategoryId"]}");
    ?>
    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
            </div>
            <div class="ml-3 mb-3" style="font-size:36px;">
                沒有任何更新
            </div>
        </div>
    </div>
<?php
    exit();
}
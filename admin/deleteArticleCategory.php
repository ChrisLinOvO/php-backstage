<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

//刪除類別
if(isset($_GET['deleteArticleCategoryId'])){
    $strArticleCategoryIds = "";;
    $strArticleCategoryIds.= $_GET['deleteArticleCategoryId'];
    getRecursiveCategoryIds($pdo, $_GET['deleteArticleCategoryId']);
    
    $sql = "DELETE FROM `articleCategories` WHERE `articleCategoryId` in ( {$strArticleCategoryIds} )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        header("Refresh: 3; url=./articleCategory.php");
        ?>
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    刪除成功
                </div>
            </div>
        </div>
    <?php
        exit();
    } else {
        header("Refresh: 3; url=./articleCategory.php");
        ?>
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    刪除失敗
                </div>
            </div>
        </div>
    <?php
        exit();
    }
}

//搭配全域變數，遞迴取得上下階層的 id 字串集合
function getRecursiveCategoryIds($pdo, $articleCategoryId){
    global $strArticleCategoryIds;
    $sql = "SELECT `articleCategoryId`
            FROM `articleCategories` 
            WHERE `articleCategoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$articleCategoryId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            $strArticleCategoryIds.= ",".$arr[$i]['articleCategoryId'];
            getRecursiveCategoryIds($pdo, $arr[$i]['articleCategoryId']);
        }
    }
}
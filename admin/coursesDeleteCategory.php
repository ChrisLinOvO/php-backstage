<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

//刪除類別
if(isset($_GET['coursesDeleteCategoryId'])){
    $strCategoryIds = "";;
    $strCategoryIds.= $_GET['coursesDeleteCategoryId'];
    getRecursiveCategoryIds($pdo, $_GET['coursesDeleteCategoryId']);
    
    $sql = "DELETE FROM `coursescategory` WHERE `coursesCategoryId` in ( {$strCategoryIds} )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        header("Refresh: 3; url=./coursesCategory.php");
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
        header("Refresh: 3; url=./coursesCategory.php");
        ?>
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-border text-danger" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    刪除成功
                </div>
            </div>
        </div>
    <?php
        exit();
    }
}

//搭配全域變數，遞迴取得上下階層的 id 字串集合
function getRecursiveCategoryIds($pdo, $categoryId){
    global $strCategoryIds;
    $sql = "SELECT `coursesCategoryId`
            FROM `coursescategory` 
            WHERE `coursesCategoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$categoryId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            $strCategoryIds.= ",".$arr[$i]['coursesCategoryId'];
            getRecursiveCategoryIds($pdo, $arr[$i]['coursesCategoryId']);
        }
    }
}
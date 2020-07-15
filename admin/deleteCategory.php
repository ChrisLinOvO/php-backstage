<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

//刪除類別
if(isset($_GET['deleteCategoryId'])){
    $strCategoryIds = "";;
    $strCategoryIds.= $_GET['deleteCategoryId'];
    getRecursiveCategoryIds($pdo, $_GET['deleteCategoryId']);
    
    $sql = "DELETE FROM `categories` WHERE `categoryId` in ( {$strCategoryIds} )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        header("Refresh: 3; url=./category.php");
        ?>
  
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-2"  style="font-size:36px;">
                    刪除成功
                </div>
            </div>

        </div>
     
<?php
        exit();
    } else {
        header("Refresh: 3; url=./category.php");
        ?>

        <div class="container">
            <div class="d-flex justify-content-center align-items-center" style="margin-top: 40vh;">
                <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-2" style="font-size:36px;">
                    刪除失敗
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
    $sql = "SELECT `categoryId`
            FROM `categories` 
            WHERE `categoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$categoryId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            $strCategoryIds.= ",".$arr[$i]['categoryId'];
            getRecursiveCategoryIds($pdo, $arr[$i]['categoryId']);
        }
    }
}
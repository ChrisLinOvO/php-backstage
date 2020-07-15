<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

$count = 0;

if(!isset($_POST['chk'])){
    header("Refresh: 2; url=./coursesPage.php");?>
  
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

for($i = 0; $i < count($_POST['chk']); $i++){
    //加入繫結陣列
    $arrParam = [
        $_POST['chk'][$i]
    ];

    //找出特定 itemId 的資料
    $sqlImg = "SELECT `coursesId` FROM `courses` WHERE `coursesId` = ? ";
    $stmt_img = $pdo->prepare($sqlImg);
    $stmt_img->execute($arrParam);

    //有資料，則進行檔案刪除
    if($stmt_img->rowCount() > 0) {
        //取得檔案資料 (單筆)
        $arr = $stmt_img->fetchAll();
        
        //刪除檔案
        // $bool = @unlink("../images/articles/".$arr[0]['articleImg']);

        //若檔案刪除成功，則刪除資料
        if (isset($arr)) {
            //SQL 語法
            $sql = "DELETE FROM `courses` WHERE `coursesId` = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            //累計每次刪除的次數
            $count += $stmt->rowCount();
        };
    }
}

if ($count > 0) {
    header("Refresh: 2; url=./coursesPage.php");
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
 
    exit();
}

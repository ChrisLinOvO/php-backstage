<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

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
        header("Refresh: 3; url=./coursesCategory.php");
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
        header("Refresh: 3; url=./coursesCategory.php");
        ?>
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    新增失敗
                </div>
            </div>
        </div>
    <?php
        exit();
    }

} else {
    $sql = "INSERT INTO `coursescategory` (`coursesCategoryName`) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$_POST['coursesCategoryName']];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        header("Refresh: 3; url=./coursesCategory.php");
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
        header("Refresh: 3; url=./coursesCategory.php");
        ?>
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    新增失敗
                </div>
            </div>
        </div>
    <?php
        exit();
    }
}
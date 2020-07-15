<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

//若沒填寫商品種類時的行為
if( $_POST['categoryName'] == '' ){
    header("Refresh: 2; url=./category.php");
    ?>

    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
            </div>
            <div class="ml-3 mb-2" style="font-size:36px;">
                請填寫商品種類
            </div>
        </div>

    </div>

<?php
    exit();
}

//新增類別
if( isset($_POST['categoryId']) ){
    $sql = "INSERT INTO `categories` (`categoryName`, `categoryParentId`) VALUES (?,?)";
    $stmt = $pdo->prepare($sql);
    $arrParam = [
        $_POST['categoryName'], 
        $_POST['categoryId']
    ];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        header("Refresh: 2; url=./category.php");
        ?>
  
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-2"  style="font-size:36px;">
                    新增成功
                </div>
            </div>

        </div>
     
<?php
        exit();
    } else {
        header("Refresh: 2; url=./category.php");
        ?>

    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
            </div>
            <div class="ml-3 mb-2" style="font-size:36px;">
                新增失敗
            </div>
        </div>

    </div>

<?php
        exit();
    }

} else {
    $sql = "INSERT INTO `categories` (`categoryName`) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$_POST['categoryName']];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        header("Refresh: 2; url=./category.php");
        ?>
  
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-2"  style="font-size:36px;">
                    新增成功
                </div>
            </div>

        </div>
     
<?php
        exit();
    } else {
        header("Refresh: 2; url=./category.php");
        ?>

    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
            </div>
            <div class="ml-3 mb-2" style="font-size:36px;">
                新增失敗
            </div>
        </div>

    </div>

<?php
        exit();
    }
}
<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');


//回傳狀態
$objResponse = [];

//用在繫結 SQL 用的陣列
$arrParam = [];


//SQL 語法
$sql = "UPDATE `payment_types` SET ";

//paymentTypeName SQL 語句和資料繫結
$sql.= "`paymentTypeName` = ? ";
$arrParam[] = $_POST['paymentTypeName'];

if( $_FILES["paymentTypeImg"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = "payment_type_".date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["paymentTypeImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $paymentTypeImg = $strDatetime.".".$extension;

    //若上傳成功 (有夾帶檔案上傳)，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if( move_uploaded_file($_FILES["paymentTypeImg"]["tmp_name"], "../images/payment_types/{$paymentTypeImg}") ) {
        //paymentTypeImg SQL 語句和資料繫結
        $sql.= ",";
        $sql.= "`paymentTypeImg` = ? ";
        $arrParam[] = $paymentTypeImg;
    }
}

$sql.= "WHERE `paymentTypeId` = ? ";
$arrParam[] = $_POST['paymentTypeId'];


$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);


if( $stmt->rowCount()> 0 ){
    header("Refresh: 3; url=./editPaymentType.php?paymentTypeId={$_POST['paymentTypeId']}");
    ?>
  
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-2"  style="font-size:36px;">
                    更新成功
                </div>
            </div>

        </div>
     
<?php
    exit();
} else {
    header("Refresh: 3; url=./editPaymentType.php?paymentTypeId={$_POST['paymentTypeId']}");
    ?>
  
    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" style="width:50px;height:50px;" role="status">
            </div>
            <div class="ml-3 mb-2" style="font-size:36px;">
                沒有任何更新
            </div>
        </div>

    </div>

<?php
    exit();
}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
    body{
                background: #292B2B !important;
                color:white !important;
                font-family: 微軟正黑體 !important;
            }
          </style>  
</head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

$objResponse = [];

// print_r($_FILES["c_img"]);
// exit();

if ($_FILES["c_img"]["error"] === 0) {
    //為上傳檔案命名
    $strDatetime = "couch_" . date("YmdHis");

    //找出副檔名
    $extension = pathinfo($_FILES["c_img"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $c_img = $strDatetime . "." . $extension;

    //若上傳失敗，則回報錯誤訊息
    if (!move_uploaded_file($_FILES["c_img"]["tmp_name"], "../images/couch/{$c_img}")) {
        header("Refresh: 3; url=./couchnew.php");?>
        <body>
            
        <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" role="status">
            </div>
            <div class="ml-3">
                上傳照片失敗
            </div>
        </div>
    </div>
    </body><?php
        exit();
    }
} elseif ($_FILES["c_img"]["error"] === 4) {
    header("Refresh: 3; url=./couchnew.php");?>
    <body>
    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" style="margin-top:3px ;width:50px ; height:50px" role="status">
            </div>
            <div class="ml-3" style="font-size: 36px">
                請上傳照片
            </div>
        </div>
    </div>
    </body><?php
    exit();
}

$sql = "INSERT INTO `couch` (`c_username`,`c_pwd`,`c_name`,`c_img`,`c_email`,`c_gender`,`c_phoneNumber`,`c_birthday`,`c_address`) 
        VALUES (?,?,?,?,?,?,?,?,?)";

//細節用陣列
$arrParam = [
    $_POST['c_username'],
    sha1($_POST['c_pwd']),
    $_POST['c_name'],
    $c_img,
    $_POST['c_email'],
    $_POST['c_gender'],
    $_POST['c_phoneNumber'],
    $_POST['c_birthday'],
    $_POST['c_address']
];

if ($arrParam[0] != "" && $arrParam[1] != "" && $arrParam[2] != "") {

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
} else {
    header("Refresh: 3; url=./couchnew.php"); ?>
    <body>
        

    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-grow" role="status">
            </div>
            <div class="ml-3">
                請輸入資料
            </div>
        </div>
    </div>
    </body>
<?php
    exit();
}


if ($stmt->rowCount() > 0) {
    header("Refresh: 3; url=./couch.php");
?>
<body>
    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-border text-success" style="margin-top:3px ;width:50px ; height:50px" role="status">
            </div>
            <div class="ml-3" style="font-size: 36px">
                新增成功
            </div>
        </div>
    </div>
    </body>
<?php
    exit();
} else {
    header("Refresh: 3; url=./couchnew.php");
?>
<body>
    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-grow text-danger" style="margin-top:3px ;width:50px ; height:50px" role="status">
            </div>
            <div class="ml-3" style="font-size: 36px">
                帳號已存在，請重新輸入
            </div>
        </div>
    </div>
    </body>
<?php
    exit();
}
?>

</html>
<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


$count = 0;


if (!isset($_POST['chk'])) {
    header('refresh:3;url=./orders.php');


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <style>
            .con {
                width: 300px;
                margin: auto;
                margin-top: 60px;
                text-align: center;

            }

            .card-text {


                margin: 20px;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>訂單一覽</title>
    </head>

    <body>
        <div class="con">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">訂單一覽</div>
                <div class="card-body">
                    <span class="badge badge-warning">Warning</span>
                    <p class="card-text">請先勾選要刪除訂單</p>
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </div>
        </div>
    </body>

    </html>


<?php

    exit();
}
?>
<?php
for ($i = 0; $i < count($_POST['chk']); $i++) {
    //加入繫結陣列
    $arrParam = [
        $_POST['chk'][$i]
    ];

    // echo "<pre>";
    // print_r($arrParam);
    // echo "</pre>";
    // exit();


    //找出特定 itemId 的資料
    $sqlImg = "SELECT `itemId` FROM `items` WHERE `itemId` = ? ";
    $stmt_img = $pdo->prepare($sqlImg);
    $stmt_img->execute($arrParam);
    // echo "<pre>";
    // print_r($stmt_img);
    // echo "</pre>";
    // exit();

    //有資料，則進行檔案刪除
    if ($stmt_img->rowCount() > 0) {
        //取得檔案資料 (單筆)
        $arr = $stmt_img->fetchAll();
        // echo "<pre>";
        // print_r($arr);
        // echo "</pre>";
        // exit();

        //刪除檔案
        // $bool = unlink("../images/items/" . $arr[0]['itemImg']);

        //若檔案刪除成功，則刪除資料
        if (isset($arr)) {
            //SQL 語法
            $sql = "DELETE FROM `items` WHERE `itemId` = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            //累計每次刪除的次數
            $count += $stmt->rowCount();
        };
    }
}

if ($count > 0) {
    header("Refresh:2; url=./admin.php");
    $objResponse['success'] = true;
    $objResponse['code'] = 200;
    $objResponse['info'] = "刪除成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh:2; url=./admin.php");
    $objResponse['success'] = false;
    $objResponse['code'] = 500;
    $objResponse['info'] = "刪除失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
?>
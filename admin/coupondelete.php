<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

$count = 0;

if (!isset($_POST['chk'])) {
    header("Refresh: 2; url=./coupon.php");
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


for ($i = 0; $i < count($_POST['chk']); $i++) {
    //加入繫結陣列
    $arrParam = [
        $_POST['chk'][$i]
    ];
    // echo "<pre>";
    // print_r($arrParam);
    // echo "</pre>";

    $sqlImg = "SELECT `couponID` FROM `coupon` WHERE `couponID` = ? ";
    $stmt_img = $pdo->prepare($sqlImg);
    $stmt_img->execute($arrParam);
    // echo "<pre>";
    // print_r($stmt_img);
    // echo "</pre>";
    // exit();

    if ($stmt_img->rowCount() > 0) {
        //取得檔案資料 (單筆)
        $arr = $stmt_img->fetchAll();
        // echo "<pre>";
        // print_r($arr);
        // echo "</pre>";
        // exit();


        if (isset($arr)) {
            //SQL 語法
            $sql = "DELETE FROM `coupon` WHERE `couponID` = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            //累計每次刪除的次數
            $count += $stmt->rowCount();
        };
    }
}

if ($count > 0) {
    header("Refresh: 2; url=./coupon.php");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        <div class="container">
            <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    刪除成功
                </div>
            </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
    exit();
} else {
    header("Refresh: 2; url=./coupon.php");
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
    // echo "<script>alert('刪除失敗')</script>";
    exit();
}

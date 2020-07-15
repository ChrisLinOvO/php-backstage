<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();


//回傳狀態
$objResponse = [];

//用在繫結 SQL 用的陣列
$arrParam = [];


//SQL 語法
$sql = "UPDATE `articles` SET ";

//itemName SQL 語句和資料繫結
$sql .= "`articleName` = ? ,";
$arrParam[] = $_POST['articleName'];

if ($_FILES["articleImg"]["error"] === 0) {
    //為上傳檔案命名
    $strDatetime = "article_" . date("YmdHis");

    //找出副檔名
    $extension = pathinfo($_FILES["articleImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $articleImg = $strDatetime . "." . $extension;

    //若上傳成功 (有夾帶檔案上傳)，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if (move_uploaded_file($_FILES["articleImg"]["tmp_name"], "../images/articles/{$articleImg}")) {
        //先查詢出特定 id (itemId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `articleImg` FROM `articles` WHERE `articleId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            (int) $_POST['articleId']
        ];

        //執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        //若有找到 itemImg 的資料
        if ($stmtGetImg->rowCount() > 0) {
            //取得指定 id 的商品資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

            //若是 itemImg 裡面不為空值，代表過去有上傳過
            if ($arrImg[0]['articleImg'] !== NULL) {
                //刪除實體檔案
                @unlink("./images/articles/" . $arrImg[0]['articleImg']);
            }

            //itemImg SQL 語句字串
            $sql .= "`articleImg` = ? ,";

            //僅對 itemImg 進行資料繫結
            $arrParam[] = $articleImg;
        }
    }
}

//itemPrice SQL 語句和資料繫結
$sql .= "`articleContents` = ? , ";
$arrParam[] = $_POST['articleContents'];

//itemCategoryId SQL 語句和資料繫結
$sql .= "`articleCategoryId` = ? ";
$arrParam[] = $_POST['articleCategoryId'];


$sql .= "WHERE `articleId` = ? ";
$arrParam[] = (int) $_POST['articleId'];


$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);


if ($stmt->rowCount() > 0) {
    header("Refresh: 1; url=./article.php?articleId={$_POST['articleId']}");
?>
   
    

   <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 40vh;">
            <div class="spinner-border text-success" style="width:50px;height:50px; margin-top:3px" role="status">
            </div>
            <div class="ml-3 " style="font-size:36px;">
                更新成功
            </div>
        </div>

    </div>
<?php
    exit();
} else {
    header("Refresh: 1; url=./articleEdit.php?articleId={$_POST['articleId']}");
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
                <div class="spinner-grow text-danger"style="width:50px;height:50px;" role="status">
                </div>
                <div class="ml-3 mb-3" style="font-size:36px;">
                    請更新資料
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
}
?>
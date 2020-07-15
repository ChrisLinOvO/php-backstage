<?php
session_start();



//引用資料庫連線
require_once('./db.inc.php');

if (isset($_POST['username']) && isset($_POST['pwd'])) {
    switch ($_POST['identity']) {
        case 'admin':
            //SQL 語法
            $sql = "SELECT `username`, `pwd`, `name`
                    FROM `admin` 
                    WHERE `username` = ? 
                    AND `pwd` = ? ";
            break;

        case 'users':
            //SQL 語法
            $sql = "SELECT `username`, `pwd`, `name`
                    FROM `users`
                    WHERE `username` = ? 
                    AND `pwd` = ? ";
            break;
    }

    $arrParam = [
        $_POST['username'],
        sha1($_POST['pwd'])
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    if ($stmt->rowCount() > 0) {
        //取得資料
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //3 秒後跳頁
        if ($_POST['identity'] === 'admin')
            header("Refresh: 3; url=./admin/admin.php");
        elseif ($_POST['identity'] === 'users')
            header("Refresh: 3; url=./index.php");


        //將傳送過來的 post 變數資料，放到 session，
        $_SESSION['username'] = $arr[0]['username'];
        $_SESSION['name'] = $arr[0]['name'];
        $_SESSION['identity'] = $_POST['identity'];
?>  
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

            body {


                background: #292B2B !important;
                color: white !important;
                font-family: 微軟正黑體 !important;

            }
        </style>





        <body>
            <div class="container">
                <div class="d-flex justify-content-center" style="margin-top: 40vh;">
                    <div class="spinner-border text-success" style="width:50px;height:50px;" role="status">
                    </div>
                    <div class="ml-3 mb-3" style="font-size:36px;">
                        <?php echo "登入成功  權限為「{$_SESSION['identity']}」"; ?>
                    </div>
                </div>

            </div>
            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        </body>

<?php
        exit();
    }

    header("Refresh: 3; url=./index.php");
    echo "登入失敗…3秒後自動回登入頁";
} else {
    header("Refresh: 3; url=./index.php");
    echo "請確實登入…3秒後自動回登入頁";
}

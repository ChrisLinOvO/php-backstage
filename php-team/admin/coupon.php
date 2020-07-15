<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


$sqlTotal = "SELECT count(1) FROM `coupon`"; //SQL 敘述
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0]; //取得總筆數
$numPerPage = 5; //每頁幾筆
$totalPages = ceil($total / $numPerPage); // 總頁數
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; //目前第幾頁
$page = $page < 1 ? 1 : $page; //若 page 小於 1，則回傳 1



//商品種類 SQL 敘述
$sqlTotalCatogories = "SELECT count(1) FROM `categories`";

//取得商品種類總筆數
$totalCatogories = $pdo->query($sqlTotalCatogories)->fetch(PDO::FETCH_NUM)[0];
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>我的 PHP 程式</title>
        <style>
            .border {
                border: 1px solid;
            }

            img.itemImg {
                width: 250px;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-3">
            <h3>優惠列表</h3>
            <?php
            //若有建立商品種類，則顯示商品清單
            if ($totalCatogories > 0) {
            ?>
                <form name="myForm" entype="multipart/form-data" method="POST" action="coupondelete.php">
                    <table class="border table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border">勾選</th>
                                <th class="border">優惠名稱</th>
                                <th class="border">折抵金額</th>
                                <th class="border">備註</th>
                                <th class="border">新增時間</th>
                                <th class="border">更新時間</th>
                                <th class="border">功能</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //SQL 敘述
                            $sql = "SELECT `coupon`.`couponID`, `coupon`.`couponName`, `coupon`.`couponMoney`, `coupon`.`Remarks`, 
                        `coupon`.`created_at`, `coupon`.`updated_at`
                FROM `coupon`
                ORDER BY `coupon`.`couponID` ASC 
                LIMIT ?, ? ";

                            //設定繫結值
                            $arrParam = [($page - 1) * $numPerPage, $numPerPage];

                            //查詢分頁後的商品資料
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($arrParam);

                            //若數量大於 0，則列出商品
                            if ($stmt->rowCount() > 0) {
                                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                for ($i = 0; $i < count($arr); $i++) {
                            ?>
                                    <tr>
                                        <td class="border">
                                            <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['couponID']; ?>" />
                                        </td>
                                        <td class="border"><?php echo $arr[$i]['couponName']; ?></td>
                                        <td class="border"><?php echo $arr[$i]['couponMoney']; ?></td>
                                        <td class="border"><?php echo $arr[$i]['Remarks']; ?></td>
                                        <td class="border"><?php echo $arr[$i]['created_at']; ?></td>
                                        <td class="border"><?php echo $arr[$i]['updated_at']; ?></td>
                                        <td class="border">
                                            <a href="./couponedit.php?couponID=<?php echo $arr[$i]['couponID']; ?>">修改</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="border" colspan="9">沒有資料</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="border" colspan="9">
                                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                        <a href="?page=<?= $i ?>"><?= $i ?></a>
                                    <?php } ?>
                                </td>
                            </tr>

                            <?php if ($total > 0) { ?>
                                <tr>
                                    <td class="border" colspan="9"><button class="btn btn-outline-dark" type="submit" name="smb">刪除</button></td>
                                </tr>
                            <?php } ?>

                            </tfoo>
                    </table>
                </form>
            <?php
            } else {
                //引入尚未建立商品種類的文字描述
                require_once('./templates/noCategory.php');
            } ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>

    </html>
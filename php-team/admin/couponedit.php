<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//建立種類列表
function buildTree($pdo, $parentId = 0)
{
    $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`
            FROM `categories` 
            WHERE `categoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if ($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($arr); $i++) {
            echo "<option value='" . $arr[$i]['categoryId'] . "'>";
            echo $arr[$i]['categoryName'];
            echo "</option>";
            buildTree($pdo, $arr[$i]['categoryId']);
        }
    }
}
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
            <form name="myForm" enctype="multipart/form-data" method="POST" action="couponupdate.php">
                <table class="border  table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border">優惠名稱</th>
                            <th class="border">折抵金額</th>
                            <th class="border">備註</th>
                            <th class="border">新增時間</th>
                            <th class="border">更新時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //SQL 敘述
                        $sql = "SELECT `coupon`.`couponID`, `coupon`.`couponName`, `coupon`.`couponMoney`, `coupon`.`Remarks`, 
                        `coupon`.`created_at`, `coupon`.`updated_at`
                FROM `coupon`
                WHERE `couponID` = ? ";

                        $arrParam = [
                            (int) $_GET['couponID']
                        ];

                        //查詢
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($arrParam);

                        //資料數量大於 0，則列出相關資料
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                            <tr>
                                <td class="border">
                                    <input type="text" name="couponName" value="<?php echo $arr[0]['couponName']; ?>" maxlength="100" />
                                </td>
                                <td class="border">
                                    <input type="text" name="couponMoney" value="<?php echo $arr[0]['couponMoney']; ?>" maxlength="11" />
                                </td>
                                <td class="border">
                                    <input type="text" name="Remarks" value="<?php echo $arr[0]['Remarks']; ?>" maxlength="3" />
                                </td>
                                <td class="border"><?php echo $arr[0]['created_at']; ?></td>
                                <td class="border"><?php echo $arr[0]['updated_at']; ?></td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td colspan="7">沒有資料</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border" colspan="7"><button class="btn btn-outline-dark" type="submit" name="smb">更新</button></td>
                        </tr>

                        </tfoo>
                </table>
                <input type="hidden" name="couponID" value="<?php echo (int) $_GET['couponID']; ?>">
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>

    </html>
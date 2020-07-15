<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>付款方式</title>
        <style>
            img.payment_type_icon {
                width: 50px;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>

        <div class="container mt-3">
            <h3>付款方式</h3>
            <form name="myForm" method="POST" action="./deletePaymentType.php">
                <table class="border table table-hover">
                    <thead class="">
                        <tr>
                            <th class="border">選擇</th>
                            <th class="border">付款方式名稱</th>
                            <th class="border">付款方式圖片</th>
                            <th class="border">功能</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT `paymentTypeId`, `paymentTypeName`, `paymentTypeImg`
        FROM `payment_types`
        ORDER BY `paymentTypeId` ASC";
                        $stmt = $pdo->prepare($sql);
                        $arrParam = [];
                        $stmt->execute($arrParam);
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            for ($i = 0; $i < count($arr); $i++) {
                        ?>
                                <tr>
                                    <td class="border p-3">
                                        <input type="checkbox" name="chk[]" class="form-control" value="<?php echo $arr[$i]['paymentTypeId']; ?>" />
                                    </td>
                                    <td class="border p-3"><?php echo $arr[$i]['paymentTypeName'] ?></td>
                                    <td class="border p-3">
                                        <img class="payment_type_icon" src="../images/payment_types/<?php echo $arr[$i]['paymentTypeImg'] ?>">
                                    </td>
                                    <td class="border p-3">
                                    <button class="smbtn btn btn-outline-light m-2" type="button" onclick="location.href=('./editPaymentType.php?paymentTypeId=<?php echo $arr[$i]['paymentTypeId'] ?>')"><span class="update">修改</span></button>
                                    </td>
                                </tr>

                            <?php
                            }
                        } else {
                            ?>

                            <tr>
                                <td class="border" colspan="4">尚未建立付款方式</td>
                            </tr>

                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="4">

                                <button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb_delete">刪除</button>
                            </td>
                        </tr>
            </form>

            <hr />

            <form name="myForm" method="POST" action="./insertPaymentType.php" enctype="multipart/form-data">
                <table class="border table table-hover">
                    <thead class="">
                        <tr>
                            <th class="border p-3">付款方式名稱</th>
                            <th class="border p-3">付款方式圖片</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border p-3">
                                <input class="form-control" type="text" name="paymentTypeName" value="" maxlength="100" />
                            </td>
                            <td class="border p-3">
                                <input type="file" name="paymentTypeImg" value="" />
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border" colspan="2"><button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb_add">新增</button></td>
                        </tr>
                    </tfoot>
                </table>

            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>

    </html>
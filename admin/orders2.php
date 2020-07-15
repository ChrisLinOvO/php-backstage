<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>訂單一覽</title>
        <style>
            .border {
                border: 1px solid;
            }

            img.payment_type_icon {
                width: 50px;
            }

            .check {
                width: 40px;
                height: 40px;

            }

            .border {
                text-align: center;
                font-size: 20px;

            }

            .title {

                margin-bottom: 20px
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-3">
            <div class="title">
                <a href="./orders.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">訂單一覽</a>
            </div>
            <p>
                <p>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">訂單編號搜尋</button>
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <form name="myForm" method="POST" action="./Search.php">
                            <tr>
                                訂單編號 <input type="text" name="search" required>
                                <td class="border" colspan="2"><button class="btn btn-outline-dark" type="submit" name="smb_add">搜尋</button> </td>

                            </tr>

                        </form>
                    </div>
                </div>


                <form name="myForm" method="POST" action="./deleteCheck.php">
                    <table class="border table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="border">
                                    <div class="py-2 text-uppercase">項目</div>
                                </th>
                                <th scope="col" class="border">
                                    <div class="p-2 px-3 text-uppercase">訂單編號</div>
                                </th>
                                <th scope="col" class="border">
                                    <div class="py-2 text-uppercase">付款方式</div>
                                </th>
                                <th scope="col" class="border">
                                    <div class="py-2 text-uppercase">詳細資訊</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlOrder = "SELECT `orders`.`orderId`,`orders`.`created_at`,`orders`.`updated_at`,`payment_types`.`paymentTypeName`
                                    FROM `orders` INNER JOIN `payment_types`
                                    ON `orders`.`paymentTypeId` = `payment_types`.`paymentTypeId`
                                ORDER BY `orders`.`orderId` DESC";
                            $stmtOrder = $pdo->prepare($sqlOrder);
                            $stmtOrder->execute();
                            if ($stmtOrder->rowCount() > 0) {
                                $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
                                for ($i = 0; $i < count($arrOrders); $i++) {
                            ?>
                                    <tr>
                                        <td class="border">
                                            <input type="checkbox" name="chk[]" value="<?php echo $arrOrders[$i]["orderId"]; ?>" class="check" />
                                        </td>
                                        <th scope="row" class="border"><?php echo $arrOrders[$i]["orderId"] ?></th>
                                        <td class="border"><?php echo $arrOrders[$i]["paymentTypeName"] ?></td>
                                        <td class="border">
                                            <?php
                                            $sqlItemList = "SELECT `item_lists`.`checkPrice`,`item_lists`.`checkQty`,`item_lists`.`checkSubtotal`,
                                        `items`.`itemName`,`categories`.`categoryName`
                                            FROM `item_lists` 
                                            INNER JOIN `items`
                                            ON `item_lists`.`itemId` = `items`.`itemId`
                                            INNER JOIN `categories` 
                                            ON `items`.`itemCategoryId` = `categories`.`categoryId`
                                            WHERE `item_lists`.`orderId` = ? 
                                            ORDER BY `item_lists`.`itemListId` ASC";
                                            $stmtItemList = $pdo->prepare($sqlItemList);
                                            $arrParamItemList = [
                                                $arrOrders[$i]["orderId"]
                                            ];
                                            $stmtItemList->execute($arrParamItemList);
                                            if ($stmtItemList->rowCount() > 0) {
                                                $arrItemList = $stmtItemList->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable">
                                                    內容 
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                for ($j = 0; $j < count($arrItemList); $j++) {
                                                                ?>


                                                                    <p>商品名稱: <?php echo $arrItemList[$j]["itemName"] ?></p>
                                                                    <p>商品種類: <?php echo $arrItemList[$j]["categoryName"] ?></p>
                                                                    <p>單價: <?php echo $arrItemList[$j]["checkPrice"] ?></p>
                                                                    <p>數量: <?php echo $arrItemList[$j]["checkQty"] ?></p>
                                                                    <p>小計: <?php echo $arrItemList[$j]["checkSubtotal"] ?></p>
                                                                    <br />


                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                            <?php
                                }
                            }
                            ?>

                        </tbody>



                    </table>

                    <form name="myForm" method="GET" action="./Alldelete.php">
                        <td class="border" colspan="2"><button class="btn btn-outline-dark" type="submit" name="smb_add">刪除</button></td>
                    </form>
        </div>

        </form>

        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>

    </html>
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

            .searhbtn {

                width: 320px;

            }

            .listcard {
                color: black;
                text-align: left;

            }

            .producttitle {
                font-family: 'Noto Sans TC', sans-serif;

                color: black;

            }

            .update {

                color: wheat;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-3">
            <h3>訂單列表</h3>
            <div class="title">
                <a href="./orders.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">訂單一覽</a>
            </div>
            <form name="myForm" method="POST" action="./Search.php">



                <tr>
                    <td class="border" colspan="2">
                        <div class="searhbtn">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="訂單編號" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" required>
                                <div class="input-group-append">
                                    <button class="smbtn btn btn-outline-light" type="submit" id="button-addon2">搜尋</button>
                                    <button class="smbtn btn btn-outline-light" type="reset" id="button-addon2">重設</button>

                                    <button class="smbtn btn btn-outline-light" type="submit" id="button-addon2" onclick="location.href='./orders.php';">回訂單</button>

                                </div>
                            </div>
                        </div>
                </tr>
            </form>
            <form name="myForm" method="POST" action="./Searchdel.php">
                <table class="border table table-hover">
                    <thead class="">
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
                            <th scope="col" class="border">
                                <div class="py-2 text-uppercase">功能</div>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $_SESSION['search'] = $_POST['search'];
                        $sqlOrder = "SELECT `orders`.`orderId`,`orders`.`created_at`,`orders`.`updated_at`,`payment_types`.`paymentTypeName`
                            FROM `orders` 
                            INNER JOIN `payment_types` ON `orders`.`paymentTypeId` = `payment_types`.`paymentTypeId`
                            WHERE `orderId` LIKE '%{$_SESSION['search']}%'
                            ORDER BY `orders`.`orderId`";

                        $stmtOrder = $pdo->prepare($sqlOrder);
                        $stmtOrder->execute();


                        if ($stmtOrder->rowCount() > 0) {
                            $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
                            for ($i = 0; $i < count($arrOrders); $i++) {

                        ?>
                                <input type="hidden" name="search2" id="2">
                                <tr>
                                    <td class="border">
                                        <input type="checkbox" name="chk[]" class="check" value="<?php echo $arrOrders[$i]["orderId"]; ?>" />
                                    </td>

                                    <td scope="row" class="border"><?php echo $arrOrders[$i]["orderId"] ?>
                                    </td>
                                    <td class="border"><?php echo $arrOrders[$i]["paymentTypeName"] ?>
                                    </td>
                                    <td class="border">

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable">
                                            內容
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <span class="producttitle">
                                                            <h5 class="modal-title" id="exampleModalScrollableTitle">WoW GYM</h5>
                                                        </span>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">



                                                        <?php
                                                        $sqlItemList = "SELECT `orders`.`checkPrice`,`orders`.`checkQty`,`orders`.`checkSubtotal`, `items`.`itemName`,`categories`.`categoryName`,`orders`.`checkPrice` FROM `item_lists` INNER JOIN `items` ON `item_lists`.`itemId` = `items`.`itemId` INNER JOIN `categories` ON `items`.`itemCategoryId` = `categories`.`categoryId` INNER JOIN `orders` ON`item_lists`.`orderId` = `orders`.`orderId` WHERE `item_lists`.`orderId` = ? ORDER BY `item_lists`.`itemListId` ASC";


                                                        $stmtItemList = $pdo->prepare($sqlItemList);
                                                        $arrParamItemList = [

                                                            $arrOrders[$i]["orderId"]

                                                        ];

                                                        $stmtItemList->execute($arrParamItemList);
                                                        if ($stmtItemList->rowCount() > 0) {
                                                            $arrItemList = $stmtItemList->fetchAll(PDO::FETCH_ASSOC);

                                                            for ($j = 0; $j < count($arrItemList); $j++) {
                                                        ?>
                                                                <div class="listcard">

                                                                    <ul class="list-group">
                                                                        <li class="list-group-item">
                                                                            <p>商品名稱: <?php echo $arrItemList[$j]["itemName"] ?></p>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <p>商品種類: <?php echo $arrItemList[$j]["categoryName"] ?></p>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <p>商品單價: <?php echo $arrItemList[$j]["checkPrice"] ?></p>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <p>商品數量: <?php echo $arrItemList[$j]["checkQty"] ?></p>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <p>商品小計: <?php echo $arrItemList[$j]["checkSubtotal"] ?></p>
                                                                        </li>
                                                                    </ul>

                                                                </div>

                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border">
                                        <button class="smbtn btn btn-outline-light  m-2" type="button" id="button-addon2" onclick="location.href=('./orderedit.php?orderId=<?php echo $arrOrders[$i]["orderId"] ?>')">修改</button>
                                        <button class="smbtn btn btn-outline-light  m-2" type="submit" name="smb_add">刪除</button>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>


                    </tbody>
                </table>


        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>

    </html>
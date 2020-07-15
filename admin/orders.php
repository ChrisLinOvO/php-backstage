<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>訂單一覽</title>
        <style>
            body {
                font-family: 'Righteous', cursive;
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

                margin-bottom: 20px;

            }

            .btn-search{
                width:150px;
                height:47.95px;
                font-size:18px !important;
                padding:0 !important;
            }

            .search {
                font-size: 20px;

                color: black;
            }


            .searhbtn {

                width: 288px;

            }

            .listcard {
                color: #D0D0D0;
                text-align: left;
                margin: 20px;
            }

            .producttitle {
                font-family: 'Noto Sans TC', sans-serif;

                color: black;

            }

            .update {

                color: wheat;
            }

            .loader3 {
                position: fixed;
                top: 45%;
                right: 45%;
                width: 100px;
                margin: 20px auto;
                font-size: 10px;
                text-indent: -9999em;
                border-top: 1.1em solid rgba(64, 128, 128, .2);
                border-right: 1.1em solid rgba(64, 128, 128, .2);
                border-bottom: 1.1em solid rgba(64, 128, 128, .2);
                border-left: 1.1em solid #408080;
                -webkit-transform: translateZ(0);
                -ms-transform: translateZ(0);
                transform: translateZ(0);
                -webkit-animation: loader3 1.1s infinite linear;
                animation: loader3 1.1s infinite linear
            }

            .loader3,
            .loader3:after {
                border-radius: 50%;
                width: 10em;
                height: 10em
            }

            @-webkit-keyframes loader3 {
                0% {
                    -webkit-transform: rotate(0);
                    transform: rotate(0)
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg)
                }
            }

            @keyframes loader3 {
                0% {
                    -webkit-transform: rotate(0);
                    transform: rotate(0)
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg)
                }
            }

            .listcardbody {
                margin-top: 10px;
                padding: 20px;
                border: 2px white solid;
                border-radius: 10px;
                box-shadow: 2px 2px 2px;

            }

            .card-body {
                background: #454747 !important;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-5">
            <h3>訂單列表</h3>
            <div class="title d-flex mt-3">
                <p><a href="./orders.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">訂單一覽</a></p>
                <p>
                    <button class="btn btn-primary btn-search mx-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">訂單編號搜尋</button>
                </p>
            </div>
            <p>
                
                <div class="back">
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body mb-4">
                            <form name="myForm" method="POST" action="./Search.php">
                                <tr>
                                    <td class="border" colspan="2">
                                        <div class="searhbtn">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="訂單編號" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" required>
                                                <div class="input-group-append">
                                                    <button class="smbtn btn btn-outline-light mx-2" type="submit" id="button-addon2">搜尋</button>
                                                    <button class="smbtn btn btn-outline-light mx-2" type="reset" id=" button-addon2">重設</button>

                                                </div>
                                            </div>
                                        </div>
                                </tr>
                            </form>
                        </div>
                    </div>
                </div>

                <form name="myForm" method="POST" action="./deleteCheck.php">
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
                                        <td scope="row" class="border"><?php echo $arrOrders[$i]["orderId"] ?></td>
                                        <td class="border"><?php echo $arrOrders[$i]["paymentTypeName"] ?></td>
                                        <td class="border">


                                            <?php
                                            $sqlItemList = "SELECT `orders`.`checkPrice`,`orders`.`checkQty`,`orders`.`checkSubtotal`, 
                      `items`.`itemName`,`categories`.`categoryName`,`orders`.`checkPrice` 
                      FROM `item_lists` INNER JOIN `items` ON `item_lists`.`itemId` = `items`.`itemId` 
                      INNER JOIN `categories` ON `items`.`itemCategoryId` = `categories`.`categoryId` 
                      INNER JOIN `orders` ON`item_lists`.`orderId` = `orders`.`orderId` WHERE 
                      `item_lists`.`orderId` = ? ORDER BY `item_lists`.`itemListId` ";

                                            $stmtItemList = $pdo->prepare($sqlItemList);
                                            $arrParamItemList = [
                                                $arrOrders[$i]["orderId"]
                                            ];
                                            $stmtItemList->execute($arrParamItemList);
                                            ?>
                                            <?php
                                            if ($stmtItemList->rowCount() > 0) {
                                                $arrItemList = $stmtItemList->fetchAll(PDO::FETCH_ASSOC);
                                                $co1 = 0;
                                                for ($j = 0; $j < count($arrItemList); $j++) {
                                                    $co1++;
                                            ?>




                                                    <div class="listcard">
                                                        <div>商品項目：<?php echo $co1 ?></div>
                                                        <div class="listcardbody">
                                                            <div>商品名稱: <?php echo $arrItemList[$j]["itemName"] ?></div>
                                                            <div>商品種類: <?php echo $arrItemList[$j]["categoryName"] ?></div>
                                                            <div>商品單價: <?php echo $arrItemList[$j]["checkPrice"] ?></div>
                                                            <div>商品數量: <?php echo $arrItemList[$j]["checkQty"] ?></div>
                                                            <div>商品小計: <?php echo $arrItemList[$j]["checkSubtotal"] ?></div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="border">
                                            <button class="smbtn btn btn-outline-light  m-2" type="button" id="button-addon2" onclick="location.href=('./orderedit.php?orderId=<?php echo $arrOrders[$i]['orderId'] ?>')"><span class="update">修改</span></button>
                                            <button class="smbtn btn btn-outline-light  m-2" type="submit" name="smb_add"><span class="update">刪除</span></button>
                                        </td>



                                    </tr>
                            <?php

                                };
                            };
                            ?>
                        </tbody>
                    </table>
        </div>

        </form>


        </div>

    </body>

    </html>
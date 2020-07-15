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
        <title>訂單一覽</title>
        <style>
            body {
                font-family: 'Righteous', cursive;
            }

            .update {

                color: wheat;
            }

            .border {
                border: 1px solid;
            }

            img.itemImg {
                width: 250px;
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


            input {

                padding: 5px 15px;
                background: #ccc;
                border: 0 none;
                cursor: pointer;
                -webkit-border-radius: 5px;
                border-radius: 5px;

            }

            input[type="text"] {
                padding: 5px 15px;
                cursor: pointer;
                -webkit-border-radius: 5px;
                border-radius: 5px;
                text-align: center;
            }

            .listcard {
                color: black;
                text-align: left;

            }

            .producttitle {
                font-family: 'Noto Sans TC', sans-serif;

                color: black;

            }

            .loader3 {
                width: 100px;
                margin: 20px auto;
                font-size: 10px;
                position: fixed;
                top: 45%;
                right: 45%;
                width: 100px;
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
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>

        <?php require_once('./templates/title.php'); ?>
        <hr />

        <div class="container ">
            <h3>訂單列表</h3>
            <div class="title">
                <a href="./orders.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">訂單列表</a>
            </div>
            <form name="myForm" enctype="multipart/form-data" method="POST" action="orderupdate.php">
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
                                <div class="py-2 text-uppercase">訂單建立時間</div>
                            </th>
                            <th scope="col" class="border">
                                <div class="py-2 text-uppercase">訂單修改時間</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //SQL 敘述
                        $sql = "SELECT `orders`.`orderId`,`orders`.`created_at`,`orders`.`updated_at`,`payment_types`.`paymentTypeName`
                            FROM `orders` INNER JOIN `payment_types`
                            ON `orders`.`paymentTypeId` = `payment_types`.`paymentTypeId`
                                    WHERE `orderId` = ? ";

                        $arrParam = [
                            (int) $_GET['orderId']
                        ];

                        //查詢
                        $stmtOrder = $pdo->prepare($sql);
                        $stmtOrder->execute($arrParam);

                        //資料數量大於 0，則列出相關資料
                        if ($stmtOrder->rowCount() > 0) {
                            $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
                            for ($i = 0; $i < count($arrOrders); $i++) {

                        ?>
                                <tr>
                                    <td class="border ">
                                        <input type="checkbox" name="chk[]" value="<?php echo $arrOrders[$i]["orderId"]; ?>" class="check" />
                                    </td>
                                    <td class="border">
                                        <input type="text" name="orderId" value="<?php echo $arrOrders[$i]["orderId"] ?>" maxlength="11" />
                                    </td>
                                    <td class="border">
                                        <span><?php echo $arrOrders[0]['paymentTypeName']; ?></span>
                                    </td>
                                    <td class="border">
                                        <?php
                                        $sqlItemList = "SELECT `orders`.`checkPrice`,`orders`.`checkQty`,`orders`.`checkSubtotal`, `items`.`itemName`,`categories`.`categoryName`,`orders`.`checkPrice` FROM `item_lists` INNER JOIN `items` ON `item_lists`.`itemId` = `items`.`itemId` INNER JOIN `categories` ON `items`.`itemCategoryId` = `categories`.`categoryId` INNER JOIN `orders` ON`item_lists`.`orderId` = `orders`.`orderId` WHERE `item_lists`.`orderId` = ? ORDER BY `item_lists`.`itemListId` ASC
                                    ";
                                        $stmtItemList = $pdo->prepare($sqlItemList);
                                        $arrParamItemList = [
                                            $arrOrders[$i]["orderId"]
                                        ];
                                        $stmtItemList->execute($arrParamItemList);
                                        if ($stmtItemList->rowCount() > 0) {
                                            $arrItemList = $stmtItemList->fetchAll(PDO::FETCH_ASSOC);

                                        ?>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="smbtn btn btn-outline-light m-3" data-toggle="modal" data-target="#exampleModalScrollable">
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
                                                            for ($j = 0; $j < count($arrItemList); $j++) {
                                                            ?>
                                                                <div class="listcard">
                                                                    <ul class="list-group">
                                                                        <li class="list-group-item">商品名稱： <input type="text" name="itemName" value="<?php echo $arrItemList[0]['itemName']; ?>" maxlength="10" />
                                                                        </li>
                                                                        <li class="list-group-item"> 商品種類： <input type="text" name="categoryName" value="<?php echo $arrItemList[0]['categoryName']; ?>" maxlength="10" />
                                                                        </li>
                                                                        <li class="list-group-item"> 商品單價： <input type="text" name="checkPrice" value="<?php echo $arrItemList[0]['checkPrice']; ?>" maxlength="10" />
                                                                        </li>
                                                                        <li class="list-group-item"> 商品數量： <input type="text" name="checkQty" value="<?php echo $arrItemList[0]['checkQty']; ?>" maxlength="10" />
                                                                        </li>
                                                                        <li class="list-group-item"> 商品小計： <input type="text" name="checkSubtotal" value="<?php echo $arrItemList[0]['checkSubtotal']; ?>" maxlength="10" />
                                                                        </li>
                                                                    </ul>
                                                                </div>






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
                                    <td class="border"><?php echo $arrOrders[0]['created_at']; ?></td>
                                    <td class="border"><?php echo $arrOrders[0]['updated_at']; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>

                        </tr>

                    </tfoot>

                </table>
                <input type="hidden" name="orderId" value="<?php echo (int) $_GET['orderId']; ?>">
                <button class="smbtn btn btn-outline-light m-2" type="submit" class="btn btn-primary btn-lg  m-2" name="smb" value="更新"><span class="update">修改</span></button>

            </form>

            <div id="dd" style="display:none" class="loader3"><img src="./css/831.gif">loading..</div>

        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            $('form').on('submit', function() {

                $.ajax({
                    url: 'orderupdate.php', // 要傳送的頁面
                    method: 'POST', // 使用 POST 方法傳送請求
                    dataType: 'json', // 回傳資料會是 json 格式
                    data: $('form').serialize(), // 將表單資料用打包起來送出去
                    success: function(res) {
                        if (res.success === true) {
                            alert('更新成功');
                        } else {
                            alert('請先修改資料');
                        }
                    },
                    beforeSend: function() {
                        $('#dd').show()
                    },
                    complete: function() {

                        $('#dd').hide()

                    }


                });
                return false; 
            });
        </script>
        
    </body>

    </html>
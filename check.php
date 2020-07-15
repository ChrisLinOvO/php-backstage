<?php
session_start();
require_once("./checkSession.php");
require_once('./db.inc.php');
// require_once('./tpl/tpl-html-head.php'); 
require_once('./tpl/header.php');
require_once("./tpl/func-buildTree.php");
require_once("./tpl/func-getRecursiveCategoryIds.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="./css/carousel.css">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/footer.css">
        
        <link rel="stylesheet" href="./my_shopping_cart/css/root.css">
        <style>
            body{
                /* background: #292B2B !important; */
                color:white !important;
                font-family: 微軟正黑體 !important;
            }
        </style>
</head>
<body>

<form name="myForm" method="POST" action="./deleteCheck.php">

<div class="container-fluid">
    <div class="row">
        <!-- 樹狀商品種類連結 -->
        <div class="col-md-2 col-sm-3"><?php buildTree($pdo, 0); ?></div>

        <!-- 商品項目清單 -->
        <div class="col-md-10 col-sm-9">
            <div class="table-responsive">

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col" class="border-0 bg-light">
                                <div class="p-2 px-3 text-uppercase" style="color:white">訂單編號</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">付款方式</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">詳細資訊</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">功能</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sqlOrder = "SELECT `orders`.`orderId`,`orders`.`created_at`,`orders`.`updated_at`, `payment_types`.`paymentTypeName`
                                FROM `orders` INNER JOIN `payment_types`
                                ON `orders`.`paymentTypeId` = `payment_types`.`paymentTypeId`
                                WHERE `orders`.`username` = ? 
                                ORDER BY `orders`.`orderId` DESC";
                    $stmtOrder = $pdo->prepare($sqlOrder);
                    $arrParamOrder = [
                        $_SESSION["username"]
                    ];
                    $stmtOrder->execute($arrParamOrder);
                    if($stmtOrder->rowCount() > 0){
                        $arrOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
                        for($i = 0; $i < count($arrOrders); $i++) {
                    ?>
                        <tr>
                            <th scope="row" class="border-0"><?php echo $arrOrders[$i]["orderId"] ?></th>
                            <td class="border-0 align-middle"><?php echo $arrOrders[$i]["paymentTypeName"] ?></td>
                            <td class="border-0 align-middle">
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
                            if($stmtItemList->rowCount() > 0) {
                                $arrItemList = $stmtItemList->fetchAll(PDO::FETCH_ASSOC);
                                for($j = 0; $j < count($arrItemList); $j++) {
                            ?>
                                <p>商品名稱: <?php echo $arrItemList[$j]["itemName"] ?></p>
                                <p>商品種類: <?php echo $arrItemList[$j]["categoryName"] ?></p>
                                <p>單價: <?php echo $arrItemList[$j]["checkPrice"] ?></p>
                                <p>數量: <?php echo $arrItemList[$j]["checkQty"] ?></p>
                                <p class="mb-5">小計: <?php echo $arrItemList[$j]["checkSubtotal"] ?></p>
                            <?php
                                }
                            }
                            ?>
                            </td>
                            <td class="border-0 align-middle"><a href="./deleteCheck.php?orderId=<?php echo $arrOrders[$i]["orderId"] ?>" class="text-dark">刪除</a></td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

</form>

<?php
require_once('./tpl/footer.php');
require_once('./tpl/tpl-html-foot.php'); 
?>
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Bootstrap Dropdown Hover JS -->
        <script src="js/bootstrap-dropdownhover.min.js"></script>
    </body>
</html>
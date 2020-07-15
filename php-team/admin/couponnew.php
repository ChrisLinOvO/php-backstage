<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//建立種類列表
// function buildTree($pdo, $parentId = 0){
//     $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`
//             FROM `categories` 
//             WHERE `categoryParentId` = ?";
//     $stmt = $pdo->prepare($sql);
//     $arrParam = [$parentId];
//     $stmt->execute($arrParam);
//     if($stmt->rowCount() > 0) {
//         $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         for($i = 0; $i < count($arr); $i++) {
//             echo "<option value='".$arr[$i]['categoryId']."'>";
//             echo $arr[$i]['categoryName'];
//             echo "</option>";
//             buildTree($pdo, $arr[$i]['categoryId']); 
//         }
//     }
// }
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
            <h3>新增商品</h3>
            <form name="myForm" enctype="multipart/form-data" method="POST" action="couponadd.php">
                <table class="border  table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border">優惠名稱</th>
                            <th class="border">折抵金額</th>
                            <th class="border">備註</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border">
                                <input type="text" name="couponName" class="form-control" value="" maxlength="100" />
                            </td>
                            <td class="border">
                                <input type="text" name="couponMoney" class="form-control" value="" maxlength="11" />
                            </td>
                            <td class="border">
                                <input type="text" name="Remarks" class="form-control" value="" maxlength="10" />
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border" colspan="3"><button class="btn btn-outline-dark" type="submit" name="smb">新增</button></td>
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
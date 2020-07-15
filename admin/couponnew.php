<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');


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
        <title>新增優惠</title>
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
            <h3>新增優惠</h3>
            <form name="myForm" enctype="multipart/form-data" method="POST" action="couponadd.php">
                <table class="border  table table-hover">
                    <thead class="">
                        <tr>
                            <th class="border">優惠名稱</th>
                            <th class="border">折抵金額</th>
                            <th class="border">備註</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border p-3">
                                <input type="text" name="couponName" class="form-control" value="" maxlength="100" />
                            </td>
                            <td class="border p-3">
                                <input type="text" name="couponMoney" class="form-control" value="" maxlength="11" />
                            </td>
                            <td class="border p-3">
                                <input type="text" name="Remarks" class="form-control" value="" maxlength="10" />
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border" colspan="3"><button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb">新增</button></td>
                        </tr>

                    </tfoot>
                </table>
            </form>
        </div>
      

    </body>

    </html>
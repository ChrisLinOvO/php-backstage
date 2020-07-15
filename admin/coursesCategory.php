<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

//建立種類列表
function buildTree($pdo, $parentId = 0)
{
    $sql = "SELECT `coursesCategoryId`, `coursesCategoryName`, `coursesCategoryParentId`
            FROM `coursescategory` 
            WHERE `coursesCategoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($arr); $i++) {
            echo "<li>";
            echo "<input type='radio' name='coursesCategoryId' value='" . $arr[$i]['coursesCategoryId'] . "' />";
            echo $arr[$i]['coursesCategoryName'];
            echo " | <a href='./coursesEditCategory.php?coursesEditCategoryId=" . $arr[$i]['coursesCategoryId'] . "'>編輯</a>";
            echo " | <a href='./coursesDeleteCategory.php?coursesDeleteCategoryId=" . $arr[$i]['coursesCategoryId'] . "'>刪除</a>";
            buildTree($pdo, $arr[$i]['coursesCategoryId']);
            echo "</li>";
        }
        echo "</ul>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>課程類別</title>
    <style>
      
    </style>
</head>

<body>

    <?php require_once('./templates/title.php'); ?>
    <div class="container mt-3">
        <h3>編輯課程類別</h3>
        <form name="myForm" method="POST" action="./coursesInsertCategory.php">

            <?php buildTree($pdo, 0); ?>

            <table class="border table table-hover">
                <thead>
                    <tr>
                        <th class="border">課程類別名稱</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-3">
                            <input class="form-control" type="text" name="coursesCategoryName" value="" maxlength="100" required/>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="border"><button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb">新增</button></td>
                    </tr>
                </tfoot>
            </table>

        </form>
    </div>
</body>

</html>
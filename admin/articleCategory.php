<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//建立種類列表
function buildTree($pdo, $parentId = 0)
{
    $sql = "SELECT `articleCategoryId`, `articleCategoryName`, `articleCategoryParentId`
            FROM `articleCategories` 
            WHERE `articleCategoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($arr); $i++) {
            echo "<li>";
            echo "<input type='radio' name='articleCategoryId' value='" . $arr[$i]['articleCategoryId'] . "' />";
            echo $arr[$i]['articleCategoryName'];
            echo " | <a href='./editArticleCategory.php?editArticleCategoryId=" . $arr[$i]['articleCategoryId'] . "'>編輯</a>";
            echo " | <a href='./deleteArticleCategory.php?deleteArticleCategoryId=" . $arr[$i]['articleCategoryId'] . "'>刪除</a>";
            buildTree($pdo, $arr[$i]['articleCategoryId']);
            echo "</li>";
        }
        echo "</ul>";
    }
}
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>編輯文章類別</title>
        <style>
            .border {
                border: 1px solid;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-3">
            <h3>編輯文章類別</h3>
            <form name="myForm" method="POST" action="./insertArticleCategory.php">

                <?php buildTree($pdo, 0); ?>

                <table class="border table table-hover">
                    <thead class="">
                        <tr>
                            <th class="border">文章類別名稱</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border p-3">
                                <input class="form-control" type="text" name="articleCategoryName" value="" maxlength="100" required/>
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
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>

    </html>
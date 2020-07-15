<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>文章列表</title>
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
            <h3>文章列表</h3>
            <form name="myForm" method="POST" action="updateArticleCategory.php">
                <table class="border table table-hover">
                    <thead class="">
                        <tr>
                            <th class="border">主題名稱</th>
                            <th class="border">新增時間</th>
                            <th class="border">更新時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //SQL 敘述
                        $sql = "SELECT `articleCategories`.`articleCategoryId`, `articleCategories`.`articleCategoryName`, `articleCategories`.`created_at`, `articleCategories`.`updated_at`
                FROM  `articleCategories`
                WHERE `articleCategories`.`articleCategoryId` = ? ";

                        $arrParam = [
                            (int) $_GET['editArticleCategoryId']
                        ];

                        //查詢
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($arrParam);

                        //資料數量大於 0，則列出相關資料
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                            <tr>
                                <td class="border p-3">
                                    <input class="form-control" type="text" name="articleCategoryName" value="<?php echo $arr[0]['articleCategoryName']; ?>" maxlength="100" />
                                </td>
                                <td class="border"><?php echo $arr[0]['created_at']; ?></td>
                                <td class="border"><?php echo $arr[0]['updated_at']; ?></td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td colspan="3">沒有資料</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <?php if ($stmt->rowCount() > 0) { ?>
                                <td class="border" colspan="3"><input class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb" value="更新"></td>
                            <?php } ?>
                        </tr>
                        </tfoo>
                </table>
                <input type="hidden" name="editArticleCategoryId" value="<?php echo (int) $_GET['editArticleCategoryId']; ?>">
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>

    </html>
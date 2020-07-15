<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');

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
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($arr); $i++) {
            echo "<option value='" . $arr[$i]['articleCategoryId'] . "'>";
            echo $arr[$i]['articleCategoryName'];
            echo "</option>";
            buildTree($pdo, $arr[$i]['articleCategoryId']);
        }
    }
}
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

            img.articleImg {
                width: 250px;
                height: 200px;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-3">
            <h3>修改文章</h3>
            <form name="myForm" enctype="multipart/form-data" method="POST" action="articleUpdate.php">
                <table class="border table table-hover">
                    <thead class="">
                        <tr>
                            <th class="border">文章名稱</th>
                            <th class="border">文章照片路徑</th>
                            <th class="border">文章內容</th>
                            <th class="border">種類</th>
                            <th class="border">新增時間</th>
                            <th class="border">更新時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //SQL 敘述
                        $sql = "SELECT `articles`.`articleId`, `articles`.`articleName`, `articles`.`articleImg`, `articles`.`articleContents`, `articles`.`articleCategoryId`, `articles`.`created_at`, `articles`.`updated_at`,
                        `articleCategories`.`articleCategoryId`, `articleCategories`.`articleCategoryName`
                FROM `articles` INNER JOIN `articleCategories`
                ON `articles`.`articleCategoryId` = `articleCategories`.`articleCategoryId`
                WHERE `articleId` = ? ";

                        $arrParam = [
                            (int) $_GET['articleId']
                        ];

                        //查詢
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($arrParam);

                        //資料數量大於 0，則列出相關資料
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                            <tr>
                                <td class="border p-1">
                                    <input class="form-control" type="text" name="articleName" value="<?php echo $arr[0]['articleName']; ?>" maxlength="100" />
                                </td>
                                <td class="border p-1">
                                    <img class="articleImg" src="../images/articles/<?php echo $arr[0]['articleImg']; ?>" /><br />
                                    <input type="file" style="width: 250px" name="articleImg" value="" />
                                </td>
                                <td class="border p-1">
                                    <textarea class="form-control" type="text" name="articleContents" maxlength="500" rows="10" ><?php echo $arr[0]['articleContents']; ?></textarea>
                                </td>
                                <td class="border p-1">
                                    <select class="form-control p-1" name="articleCategoryId">
                                    <option value="<?php echo $arr[0]['articleCategoryId']; ?>"><?php echo $arr[0]['articleCategoryName']; ?></option>
                                        <?php buildTree($pdo, 0); ?>
                                    </select>
                                </td>
                                <td class="border p-1"><?php echo $arr[0]['created_at']; ?></td>
                                <td class="border p-1"><?php echo $arr[0]['updated_at']; ?></td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td colspan="6">沒有資料</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border" colspan="6">
                                <button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb" value="">更新</button>
                            </td>
                        </tr>
                        </tfoot>
                </table>
                <input type="hidden" name="articleId" value="<?php echo (int) $_GET['articleId']; ?>">
            </form>
        </div>
    </body>

    </html>
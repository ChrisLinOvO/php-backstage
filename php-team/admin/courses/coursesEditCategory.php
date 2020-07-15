<?php
require_once('../checkAdmin.php'); //引入登入判斷
require_once('../../db.inc.php'); //引用資料庫連線
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
</head>
<body>
<?php require_once('../templates/title.php'); ?>
<hr />
<h3>課程種類列表</h3>
<form name="myForm" method="POST" action="coursesUpdateCategory.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">種類名稱</th>
                <th class="border">新增時間</th>
                <th class="border">更新時間</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `coursescategory`.`coursesCategoryId`, `coursescategory`.`coursesCategoryName`, `coursescategory`.`created_at`, `coursescategory`.`updated_at`
                FROM  `coursescategory`
                WHERE `coursescategory`.`coursesCategoryId` = ? ";

        $arrParam = [
            (int)$_GET['coursesEditCategoryId']
        ];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出相關資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <tr>
                <td class="border">
                    <input type="text" name="coursesCategoryName" value="<?php echo $arr[0]['coursesCategoryName']; ?>" maxlength="100" />
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
            <?php if($stmt->rowCount() > 0){ ?>
                <td class="border" colspan="3"><input type="submit" name="smb" value="更新"></td>
            <?php } ?>
            </tr>
        </tfoo>
    </table>
    <input type="hidden" name="coursesEditCategoryId" value="<?php echo (int)$_GET['coursesEditCategoryId']; ?>">
</form>
</body>
</html>
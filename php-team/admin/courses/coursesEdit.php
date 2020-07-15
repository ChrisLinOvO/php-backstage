<?php
require_once('../checkAdmin.php'); //引入登入判斷
require_once('../../db.inc.php'); //引用資料庫連線

//建立種類列表
function buildTree($pdo, $parentId = 0){
    $sql = "SELECT `coursesCategoryId`, `coursesCategoryName`, `coursesCategoryParentId`
            FROM `coursescategory` 
            WHERE `coursesCategoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            echo "<option value='".$arr[$i]['coursesCategoryId']."'>";
            echo $arr[$i]['coursesCategoryName'];
            echo "</option>";
            buildTree($pdo, $arr[$i]['coursesCategoryId']); 
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
    img.itemImg {
        width: 250px;
    }
    </style>
</head>
<body>
<?php require_once('../templates/title.php'); ?>
<hr />
<h3>課程列表</h3>
<form name="myForm" enctype="multipart/form-data" method="POST" action="coursesUpdate.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">課程種類</th>
                <th class="border">課程名稱</th>
                <th class="border">課程照片</th>
                <th class="border">課程內容</th>
                <th class="border">課程時數</th>
                <th class="border">新增時間</th>
                <th class="border">更新時間</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `courses`.`coursesId`, `coursescategory`.`coursesCategoryName`, `courses`.`coursesName`, `courses`.`coursesImg`, `courses`.`coursesContent`, 
        `courses`.`coursesHours`, `courses`.`coursesCategoryId`, `courses`.`created_at`, `courses`.`updated_at`,
        `coursescategory`.`coursesCategoryId`
FROM `courses` INNER JOIN `coursescategory`
ON `courses`.`coursesCategoryId` = `coursescategory`.`coursesCategoryId`
                WHERE `coursesId` = ? ";

        $arrParam = [
            (int)$_GET['coursesId']
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
                    <select name="coursesCategoryId">
                    <option value="<?php echo $arr[0]['coursesCategoryId']; ?>"><?php echo $arr[0]['coursesCategoryName']; ?></option>
                    <?php buildTree($pdo, 0); ?>
                    </select>
                </td>
                <td class="border">
                    <input type="text" name="coursesName" value="<?php echo $arr[0]['coursesName']; ?>" maxlength="100" />
                </td>
                <td class="border">
                    <img class="coursesImg" src="../../images/courses/<?php echo $arr[0]['coursesImg']; ?>" /><br />
                    <input type="file" name="coursesImg" value="" />
                </td>
                <td class="border">
                    <input type="text" name="coursesContent" value="<?php echo $arr[0]['coursesContent']; ?>" maxlength="300" />
                </td>
                <td class="border">
                    <input type="text" name="coursesHours" value="<?php echo $arr[0]['coursesHours']; ?>" maxlength="3" />
                </td>
                <td class="border"><?php echo $arr[0]['created_at']; ?></td>
                <td class="border"><?php echo $arr[0]['updated_at']; ?></td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td colspan="7">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="border" colspan="7"><input type="submit" name="smb" value="更新"></td>
            </tr>
        </tfoo>
    </table>
    <input type="hidden" name="coursesId" value="<?php echo (int)$_GET['coursesId']; ?>">
</form>
</body>
</html>
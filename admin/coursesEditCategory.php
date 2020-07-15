<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>修改課程類別</title>
    <style>
        .td {
            height: 180;
            width: auto;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <?php require_once('./templates/title.php'); ?>
    <div class="container mt-5">
        <h3>修改課程類別</h3>
        <a href="./coursesCategory.php" class="btn btn-primary btn-lg active my-3" role="button" aria-pressed="true">課程類別一覽</a>
    
    <form name="myForm" method="POST" action="coursesUpdateCategory.php">
        <table class="border table table-hover">
            <thead class="">
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
                    (int) $_GET['coursesEditCategoryId']
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
                            <input class="form-control" type="text" name="coursesCategoryName" value="<?php echo $arr[0]['coursesCategoryName']; ?>" maxlength="100" />
                        </td>
                        <td class="border p-3"><?php echo $arr[0]['created_at']; ?></td>
                        <td class="border p-3"><?php echo $arr[0]['updated_at']; ?></td>
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
            </tfoot>
        </table>
        <input type="hidden" name="coursesEditCategoryId" value="<?php echo (int) $_GET['coursesEditCategoryId']; ?>">
    </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>
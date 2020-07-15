<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

// 建立種類列表
function buildTree($pdo, $parentId = 0)
{
    $sql = "SELECT `coursesCategoryId`, `coursesCategoryName`, `coursesCategoryParentId`
            FROM `coursescategory` 
            WHERE `coursesCategoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if ($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($arr); $i++) {
            echo "<option value='" . $arr[$i]['coursesCategoryId'] . "'>";
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
        <title>新增課程</title>
        <style>
            img.coursesImg {
                width: 250px;
                height: 200px;
            }

            thead {
                background: var(--title-bgColor);
                color: var(--title-textColor);
            }
            th{
                font-size:22px !important;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-5">
            <h3>新增課程</h3>
            <form class="mt-3" name="myForm" enctype="multipart/form-data" method="POST" action="coursesAdd.php">
                <table class="border table table-hover">
                    <thead>
                        <tr>
                            <th class="border">課程名稱</th>
                            <th class="border">課程照片路徑</th>
                            <th class="border">課程內容</th>
                            <th class="border">時數</th>
                            <th class="border">課程種類</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td class="border p-2">
                                <input type="text" name="coursesName" value=""  class="form-control" maxlength="100" required/>
                            </td>
                            <td class="border p-2">
                                <input type="file" name="coursesImg" value="" />
                            </td>
                            <td class="border p-2">
                                <textarea type="text" name="coursesContent" class="form-control" maxlength="500" rows=15 style="width:250px" required></textarea>
                            </td>
                            <td class="border p-2">
                                <input type="text" name="coursesHours" value=""  class="form-control" maxlength="3" required>
                            </td>
                            <td class="border p-2" style="width:200px">
                                <select name="coursesCategoryId" class="custom-select">
                                    <?php buildTree($pdo, 1); ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border" colspan="5"><button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb">新增</button></td>
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
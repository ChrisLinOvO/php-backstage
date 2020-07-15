<?php
require_once('../checkAdmin.php'); //引入登入判斷
require_once('../../db.inc.php'); //引用資料庫連線
require_once("./tpl/funcBuildTree.php");
require_once("./tpl/func-getRecursiveCategoryIds.php");



$sqlTotal = "SELECT count(1) FROM `courses`"; //SQL 敘述
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0]; //取得總筆數
$numPerPage = 5; //每頁幾筆
$totalPages = ceil($total / $numPerPage); // 總頁數
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; //目前第幾頁
$page = $page < 1 ? 1 : $page; //若 page 小於 1，則回傳 1



//商品種類 SQL 敘述
$sqlTotalCatogories = "SELECT count(1) FROM `coursescategory`";

//取得商品種類總筆數
$totalCatogories = $pdo->query($sqlTotalCatogories)->fetch(PDO::FETCH_NUM)[0];
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>我的 PHP 程式</title>
        <style>
            img.coursesImg {
                width: 250px;
                height: 200px;
            }

            .td {
                height: 180;
                width: auto;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <?php require_once('../templates/title.php'); ?>
        <div class="container mt-3">
            <h3>課程列表</h3>
            <div class="row">
                <div class="col-md-2 col-sm-3"><?php buildTree($pdo, 0); ?>
                </div>
                <!-- 商品項目清單 -->
                <div class="col-md-8 col-sm-6">
                    <div class="row">
                        <?php
                        if (isset($_GET['coursesCategoryId'])) {
                            $strCategoryIds = "";;
                            $strCategoryIds .= $_GET['coursesCategoryId'];
                            getRecursiveCategoryIds($pdo, $_GET['coursesCategoryId']);
                        };
                        //SQL 敘述
                        $sql = "SELECT `courses`.`coursesId`, `courses`.`coursesName`, `courses`.`coursesImg`, `courses`.`coursesContent`, 
                            `courses`.`coursesHours`, `courses`.`coursesCategoryId`, `courses`.`created_at`, `courses`.`updated_at`,
                            `coursescategory`.`coursesCategoryName`
                            FROM `courses` INNER JOIN `coursescategory`
                            ON `courses`.`coursesCategoryId` = `coursescategory`.`coursesCategoryId`";
                        //若網址有商品種類編號，則整合字串來操作 SQL 語法
                        if (isset($_GET['coursesCategoryId'])) {
                            $sql .= "WHERE `courses`.`coursesCategoryId` in ({$strCategoryIds})";
                        }
                        $sql .= "ORDER BY `courses`.`coursesId` ASC ";
                        //查詢分頁後的商品資料
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        ?>
                        <?php
                        //若商品項目個數大於 0，則列出商品
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>

                            <table class="border table table-hover">
                                <thead class="thead-dark ">
                                    <tr>
                                        <th class="border">勾選</th>
                                        <th class="border">課程類別</th>
                                        <th class="border">課程名稱</th>
                                        <th class="border">課程照片</th>
                                        <th class="border">課程內容</th>
                                        <th class="border">課程時數</th>
                                        <th class="border">新增時間</th>
                                        <th class="border">更新時間</th>
                                        <th class="border">功能</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($arr); $i++) {
                                    ?>
                                        <tr>
                                            <td class="border">
                                                <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['coursesId']; ?>" />
                                            </td>
                                            <td class="border"><?php echo $arr[$i]['coursesCategoryName']; ?></td>
                                            <td class="border"><?php echo $arr[$i]['coursesName']; ?></td>
                                            <td class="border"><img class="coursesImg" src="../../images/courses/<?php echo $arr[$i]['coursesImg']; ?>" /></td>
                                            <td class="border"><?php echo $arr[$i]['coursesContent']; ?></td>
                                            <td class="border"><?php echo $arr[$i]['coursesHours']; ?></td>
                                            <td class="border"><?php echo $arr[$i]['created_at']; ?></td>
                                            <td class="border"><?php echo $arr[$i]['updated_at']; ?></td>

                                            <td class="border">
                                                <div class="d-flex flex-column justify-content-between td-div">
                                                    <a href="./coursesEdit.php?coursesId=<?php echo $arr[$i]['coursesId']; ?>">課程編輯</a>
                                                    <a href="./coursesComments.php?coursesId=<?php echo $arr[$i]['coursesId']; ?>">回覆評論</a>
                                                </div>
                                            </td>
                                        </tr>
                                </tbody>
                                
                            <?php }?>
                            
                        <tfoot>
                                            <tr>
                                                <td class="border" colspan="9">
                                                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                                        <a href="?page=<?= $i ?>"><?= $i ?></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php if ($total > 0) { ?>
                                                <tr>
                                                    <td class="border " colspan="9"><button class="btn btn-outline-dark" type="submit" name="smb" value="">刪除</button></td>
                                                </tr>
                                            <?php } ?>

                                            </tfoot>
                        
                      <?php  }
                                ?>
                                    </table>
                                </form>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
                </div>
    </body>

    </html>
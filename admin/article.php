<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');


if (!isset($_GET['page'])) {
    $_SESSION['articleSearch'] = "";
    $_SESSION['option'] = "";
}

if (isset($_POST["articleSearch"])) {
    $_SESSION['option'] = $_POST['option'];
    $_SESSION['articleSearch'] = $_POST['articleSearch'];
}


$sqlarticleSearch = "   SELECT `articles`.`articleId`, `articles`.`articleName`,
                                `articles`.`articleImg`, `articles`.`articleContents`, 
                                `articles`.`articleCategoryId`,
                                `articles`.`created_at`, `articles`.`updated_at`,
                                `articleCategories`.`articleCategoryName`
                        FROM `articles` INNER JOIN `articleCategories`
                        ON `articles`.`articleCategoryId` = `articleCategories`.`articleCategoryId`";


$sqlTotal = "SELECT count(1) FROM `articles` INNER JOIN `articleCategories`  ON `articles`.`articleCategoryId` = `articleCategories`.`articleCategoryId`  "; //SQL 敘述



if (isset($_SESSION['option'])) {
    switch ($_SESSION['option']) {
        case "options1":
            $sqlarticleSearch .= " WHERE `articles`.`articleName`
                                       LIKE '%{$_SESSION['articleSearch']}%' ";


            $sqlTotal .= " WHERE `articles`.`articleName`
                                       LIKE '%{$_SESSION['articleSearch']}%' ";


            $NameCheck = 'checked="true"';
            break;
        case 'options2':
            $sqlarticleSearch .= " WHERE `articles`.`articleContents`
                                        LIKE '%{$_SESSION['articleSearch']}%' ";


            $sqlTotal .= " WHERE `articles`.`articleContents`
                                        LIKE '%{$_SESSION['articleSearch']}%' ";


            $QtyCheck = 'checked="true"';
            break;
        case 'options3':
            $sqlarticleSearch .= " WHERE `articlecategories`.`articleCategoryName`
                                       LIKE '%{$_SESSION['articleSearch']}%' ";


            $sqlTotal .= " WHERE `articlecategories`.`articleCategoryName`
            LIKE '%{$_SESSION['articleSearch']}%'";

            $kindCheck = 'checked="true"';
            break;
    }
} else {

    $sqlTotal .= "  WHERE `articles`.`articleName`
                                    LIKE '%{$_SESSION['articleSearch']}%' ";
    $sqlarticleSearch .= " WHERE `articles`.`articleName` 
                                   LIKE '%{$_SESSION['articleSearch']}%' ";
    $NameCheck = 'checked="true"';
}




$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0]; //取得總筆數
$numPerPage = 3; //每頁幾筆
$totalPages = ceil($total / $numPerPage); // 總頁數
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; //目前第幾頁
$page = $page < 1 ? 1 : $page; //若 page 小於 1，則回傳 1




$sqlarticleSearch .= "LIMIT ?, ? ";
$arrParam = [($page - 1) * $numPerPage, $numPerPage];
$stmtArticle = $pdo->prepare($sqlarticleSearch);
$stmtArticle->execute($arrParam);


?>

<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>我的 PHP 程式</title>
        <style>
            img.articleImg {
                width: 250px;
                height: 200px;
            }

            /* .td-div {
                width: 50px;
                height: 180;
            } */
            p {
                width: 100px;
            }

            .border {
                border: 1px solid;
            }

            .border {
                text-align: center;
                font-size: 18px;
            }

            /* .box {
                width: 30px;
            } */
            .check {
                width: 30px;
                height: 30px;
            }

            .checkbox {
                margin: 0 !important;
            }

            .card-body {
                background: #454747 !important;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-3">
            <h3>文章列表</h3>
            <div class="title mb-3">
                <a href="./article.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">文章一覽</a>
                <button class="btn btn-primary mx-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> 文章搜尋 </button>
                </p>
                <div class="collapse" id="collapseExample" style="width:1180px">
                    <div class="card card-body mb-4">
                        <form name="myForm" method="POST" action="./article.php">
                            <div class="btn-group btn-group-toggle my-4" data-toggle="buttons" name="titleMethod">
                                <label class="smbtn btn btn-outline-light">
                                    <input type="radio" name="option" value="options1" id="option1" checked> 名稱
                                </label>
                                <label class="smbtn btn btn-outline-light">
                                    <input type="radio" name="option" value="options2" id="option2"> 內容
                                </label>
                                <label class="smbtn btn btn-outline-light">
                                    <input type="radio" name="option" value="options3" id="option3"> 種類
                                </label>
                            </div>
                            <br>
                            <input style="width:300px" class="form-control mt-2" type="text" name="articleSearch" placeholder="請輸入關鍵字" required>
                            <tr>
                                <td class="border" colspan="2"><button class="smbtn btn btn-outline-light my-4" type="submit" name="smb_add">搜尋</button>
                                </td>
                                <td class="border" colspan="2"><button class="smbtn btn btn-outline-light my-4" type="reset" name="smb_reset">重設</button>
                                </td>
                            </tr>
                        </form>
                    </div>
                </div>
                <form name="myForm" entype="multipart/form-data" method="POST" action="articleDelete.php">
                    <table class="border table table-hover">
                        <thead class="">
                            <tr>
                                <th class="border">
                                    <input type="checkbox" id="chk1" class="check" name="chk[]" value="" />
                                </th>
                                <th class="border">名稱</th>
                                <th class="border">照片</th>
                                <th class="border">內容</th>
                                <th class="border">種類</th>
                                <th class="border">新增時間</th>
                                <th class="border">更新時間</th>
                                <th class="border">功能</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($stmtArticle->rowCount() > 0) {
                                $arr = $stmtArticle->fetchAll(PDO::FETCH_ASSOC);
                                for ($i = 0; $i < count($arr); $i++) {
                            ?>
                                    <tr>
                                        <td class="border">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <input type="checkbox" class="check" name="chk[]" value="<?php echo $arr[$i]['articleId']; ?>" />
                                            </div>
                                        </td>
                                        <td class="border mt-5 p-2">
                                            <div class="d-flex align-items-center " style="width:200px;height: 200px;text-align:left"><?php echo $arr[$i]['articleName']; ?></div>
                                        </td>
                                        <td class="border p-2"><img class="articleImg" src="../images/articles/<?php echo $arr[$i]['articleImg']; ?>" /></td>
                                        <td class="border mr-5 p-2" style="overflow: auto">
                                            <div class="d-flex " style="width:150px; height: 200px;text-align:left"><?php echo nl2br($arr[$i]['articleContents']); ?></div>
                                        </td>
                                        <td class="border p-2">
                                            <div class="d-flex align-items-center justify-content-center" style="width:80px;height: 200px"><?php echo $arr[$i]['articleCategoryName']; ?></div>
                                        </td>
                                        <td class="border p-2">
                                            <div class="d-flex align-items-center " style="width:100px; height: 200px"><?php echo $arr[$i]['created_at']; ?></div>
                                        </td>
                                        <td class="border p-2">
                                            <div class="d-flex align-items-center" style="width:100px;height: 200px"><?php echo $arr[$i]['updated_at']; ?></div>
                                        </td>

                                        <td class="border p-2">
                                            <div class="d-flex align-items-center td-div justify-content-center" style="width:100px">
                                                <button class="smbtn btn btn-outline-light m-2" type="button" onclick="location.href=('./articleEdit.php?articleId=<?php echo $arr[$i]['articleId'] ?>')"><span class="update">修改</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="border" colspan="8">沒有資料</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td class="border" colspan="8">
                                    <div class="float-left p-2">
                                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                            <a class="px-2" href="?page=<?= $i ?>"><?= $i ?></a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($total > 0) { ?>
                                <tr>
                                    <td class="border " colspan="8"><button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb" value="">刪除</button></td>
                                </tr>
                            <?php } ?>

                        </tfoot>
                    </table>
                </form>


            </div>
            <script>
                //抓第一個框框
                document.getElementById("chk1").onclick = function() {
                    //抓所有框框(陣列)
                    let chk = document.getElementsByName('chk[]');
                    //this=第一個框框有勾選的話
                    if (this.checked) {
                        console.log(this);
                        //陣列一個一個打勾
                        for (let i = 0; i < chk.length; i++) {
                            //checked特性：只要有值就會勾選
                            //就算給他123、456，任何一個值都可行
                            chk[i].checked = true;
                            console.log(chk[i].checked);
                        }
                    } else {
                        for (let i = 0; i < chk.length; i++) {
                            //checked不勾選：只能是null、""、false
                            //如果是"false"：因為會判定為字串，認為是一個值故也會當作要勾選
                            chk[i].checked = false;
                            console.log(chk[i].checked);
                        }
                    }

                }
            </script>
    </body>

    </html>
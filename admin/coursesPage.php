<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once("./coursesTpl/funcBuildTree.php");
require_once("./coursesTpl/func-getRecursiveCategoryIds.php");


$sqlTotal = "SELECT count(1) FROM `courses`"; //SQL 敘述
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0]; //取得總筆數
$numPerPage = 5; //每頁幾筆
$totalPages = ceil($total / $numPerPage); // 總頁數
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; //目前第幾頁
$page = $page < 1 ? 1 : $page; //若 page 小於 1，則回傳 1


//商品種類 SQL 敘述
$sqlTotalCategories = "SELECT count(1) FROM `coursescategory`";

//取得商品種類總筆數
$totalCategories = $pdo->query($sqlTotalCategories)->fetch(PDO::FETCH_NUM)[0];
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>課程列表</title>
        <style>
            .wrapper {
                max-width: 100vw;
            }

       
            .form-group {
                max-width: 90vw;
            }

            img.coursesImg {
                width: 250px;
                height: 200px;
            }

            .border {
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .listA {
                color: wheat !important;
                transition: .3s;
                font-size: 20px;
            }

            .listA:hover {
                background: white;
                color: black !important;
                text-decoration: none;
                padding: 10px;
            }

            .head div {
                font-size: 20px;
            }

            .btn-search {
                width: 100px;
                height: 50px;
                font-size: 18px !important;
                padding: 0 !important;
            }
            .cN{
                font-size:1rem !important;
            }
            .input-box {
                width: 35px;
                height: 35px;
            }

            .searchbtn {
                width: 400px;
            }

            .card-body {
                background: #454747 !important;
                padding: 40px !important;
            }

            form {
                margin: 0 !important;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="wrapper mt-3">
            <div class="mt-3">
                <div class="row mx-0">
                    <div class="col-md-10 col-sm-6 mx-auto px-0">
                        <div class="form-group">
                            <h3>課程列表</h3>
                            <div class="d-flex align-items-center">
                                <div class="dropdown show">
                                    <a class="btn dropdown-toggle ml-0 my-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        課程類別選擇
                                    </a>
                                    <div class="dropdown-menu" style="color:wheat" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-item" style="background:var(--title-color);"> <?php buildTree($pdo, 0); ?> </div>
                                    </div>
                                </div>
                                <div class="title mx-3">
                                    <button class="btn btn-primary btn-search" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">課程搜尋</button>
                                </div>
                            </div>
                            <div class="back">
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <form name="myForm top-form" method="POST" action="./coursesSearchAfter.php">
                                            <tr>
                                                <td class="border" colspan="2">
                                                    <div class="searchbtn">
                                                        <div class="input-group d-flex align-items-center">
                                                            <input type="text" class="form-control" placeholder="請輸入課程名稱" name="search" required>
                                                            <div class="input-group-append mx-2">
                                                                <button class="smbtn btn btn-outline-light update" type="submit">搜尋</button>
                                                                <button class="smbtn btn btn-outline-light update mx-2" type="reset">重設</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </tr>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row mx-0 ">
                    <!-- 商品項目清單 -->
                    <div class="col-md-10 col-sm-6 mx-auto">
                        <?php
                        if ($totalCategories > 0) {
                        ?>
                            <form name="myForm" type="multipart/form-data" method="POST" action="coursesDelete.php">
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
                            ON `courses`.`coursesCategoryId` = `coursescategory`.`coursesCategoryId` ";
                                //若網址有商品種類編號，則整合字串來操作 SQL 語法
                                if (isset($_GET['coursesCategoryId'])) {
                                    $sql .= "WHERE `courses`.`coursesCategoryId` in ({$strCategoryIds})";
                                }
                                $sql .= "ORDER BY `courses`.`coursesId` ASC LIMIT ?,?";
                                //設定繫結值
                                $arrParam = [($page - 1) * $numPerPage, $numPerPage];

                                //查詢分頁後的商品資料
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute($arrParam);
                                ?>
                                <?php
                                //若商品項目個數大於 0，則列出商品
                                if ($stmt->rowCount() > 0) {
                                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>
                                    <div class="row head">
                                        <div class="border col p-3 m-0 checkbox">
                                            <input type="checkbox" id="chk1" form-control name="chk[]" value="" class="input-box" />
                                        </div>
                                        <div class="border col-1 ">課程類別</div>
                                        <div class="border col-1 ">課程名稱</div>
                                        <div class="border col-3 ">課程照片</div>
                                        <div class="border col-3 ">課程內容</div>
                                        <div class="border col-1 ">時數</div>
                                        <div class="border col-1 ">更新時間</div>
                                        <div class="border col-1 ">功能</div>
                                    </div>
                                    <?php
                                    for ($i = 0; $i < count($arr); $i++) {
                                    ?>
                                        <div class="row">
                                            <div class="border col checkBox">
                                                <input class="input-box" type="checkbox" name="chk[]" value="<?php echo $arr[$i]['coursesId']; ?>" />
                                            </div>
                                            <div class="border col-1"><?php echo $arr[$i]['coursesCategoryName']; ?></div>
                                            <div class="border col-1 "><?php echo $arr[$i]['coursesName']; ?></div>
                                            <div class="border col-3 p-3"><img class="coursesImg" src="../images/courses/<?php echo $arr[$i]['coursesImg']; ?>" /></div>
                                            <div class="border col-3 p-2"><?php echo nl2br($arr[$i]['coursesContent']); ?></div>
                                            <div class="border col-1 "><?php echo $arr[$i]['coursesHours']; ?></div>
                                            <div class="border col-1 "><?php echo $arr[$i]['updated_at']; ?></div>

                                            <div class="border col-1 flex-column d-flex justify-content-around">
                                                <button class="smbtn btn btn-outline-light m-2" type="button" onclick="location.href=('./coursesEdit.php?coursesId=<?php echo $arr[$i]['coursesId'] ?>')"><span class="update">修改</span></button>
                                            </div>

                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="row head">
                                        <div class="border col p-3 m-0 checkbox">
                                            <input type="checkbox" id="chk1" form-control name="chk[]" value="" class="input-box" />
                                        </div>
                                        <div class="border col-1 ">課程類別</div>
                                        <div class="border col-2 ">課程名稱</div>
                                        <div class="border col-2 ">課程照片</div>
                                        <div class="border col-2 ">課程內容</div>
                                        <div class="border col-1 ">時數</div>
                                        <div class="border col-1 ">新增時間</div>
                                        <div class="border col-1 ">更新時間</div>
                                        <div class="border col-1 ">功能</div>
                                    </div>
                                    <div class="row border" style="height:150px;font-size:30px;" colspan="9">沒有資料</div>
                                <?php
                                }
                                ?>
                                <div class="border row justify-content-start">
                                    <div class="p-2">
                                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                            <a class="px-2" href="?page=<?= $i ?>"><?= $i ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if ($total > 0) { ?>
                                    <div class="row border border-top-0 justify-content-start">
                                        <button class="smbtn btn btn-outline-light m-2" type="submit" name="smb" value="">刪除</button>
                                    </div>
                                <?php } ?>
                            </form>
                        <?php
                        } else {
                            //引入尚未建立商品種類的文字描述
                            require_once('./templates/noCategory.php');
                        } ?>


                    </div>
                </div>
            </div>
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
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
    </body>

    </html>
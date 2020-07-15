<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once('../tpl/tpl-html-head.php');
require_once("./coursesTpl/funcBuildTree.php");
require_once("./coursesTpl/func-getRecursiveCategoryIds.php");

$str = $_POST['search'];

$sql = "SELECT `courses`.`coursesId`, `courses`.`coursesName`, `courses`.`coursesImg`, `courses`.`coursesContent`, 
`courses`.`coursesHours`, `courses`.`coursesCategoryId`, `courses`.`created_at`, `courses`.`updated_at`,`coursescategory`.`coursesCategoryName`
FROM `courses` INNER JOIN `coursescategory`
ON `courses`.`coursesCategoryId` = `coursescategory`.`coursesCategoryId`
WHERE `coursesName` LIKE '%{$str}%'
ORDER BY `coursesId`";

$stml = $pdo->prepare($sql);
$stml->execute();

// echo"<pre>";
// print_r($arr);
// echo"</pre>";
// exit();

//頁數
$sqlTotal = "SELECT count(1) FROM `courses`"; //SQL 敘述
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0]; //取得總筆數
$numPerPage = 5; //每頁幾筆
$totalPages = ceil($total / $numPerPage); // 總頁數
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; //目前第幾頁
$page = $page < 1 ? 1 : $page; //若 page 小於 1，則回傳 1
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>課程列表</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .wrapper {
            width: 90vw;
            margin: 20px auto;
        }

        img {
            width: 250px;

        }

        .input-box {
            width: 40px;
            height: 40px;
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

        .dropdown-item:hover {
            background: black;
        }

        .btn-search {
            width: 100px;
            height: 50px;
            font-size: 18px !important;
            padding: 0 !important;
        }

        .searchbtn {
            width: 400px;
        }

        .card-body {
            background: #454747 !important;
            padding: 40px !important;
            margin-bottom: 20px;
        }

        form {
            margin: 0 !important;
        }

        .border {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .head div {
            font-size: 20px;
        }

        .dropdown-toggle {
            transform: none !important;
        }

        form {
            margin: 0 !important;

        }
    </style>
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
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-item"> <?php buildTree($pdo, 0); ?> </div>
                                </div>
                            </div>
                            <div class="title mx-3">
                                <button class="btn btn-primary btn-search" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">課程搜尋</button>
                            </div>
                        </div>
                        <div class="back">
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <form name="myForm" method="POST" action="./coursesSearchAfter.php">
                                        <tr>
                                            <td class="border" colspan="2">
                                                <div class="searchbtn">
                                                    <div class="input-group">
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


                        <form name="myForm" entype="multipart/form-data" method="POST" action="coursesDelete.php">
                            <div class="row head">
                                <div class="border col p-3">
                                    <input type="checkbox" id="chk1" class="form-control" name="chk[]" value="" />
                                </div>
                                <div class="border col-1">課程類別</div>
                                <div class="border col-1">課程名稱</div>
                                <div class="border col-3">課程照片</div>
                                <div class="border col-3">課程內容</div>
                                <div class="border col-1">課程時數</div>
                                <!-- <div class="border col-1">新增時間</div> -->
                                <div class="border col-1">更新時間</div>
                                <div class="border col-1">功能</div>
                            </div>
                            <?php

                            if ($stml->rowCount() > 0) {
                                $arr = $stml->fetchAll(PDO::FETCH_ASSOC);

                                for ($i = 0; $i < count($arr); $i++) {
                            ?>
                                    <div class="row">
                                        <div class="border col">
                                            <input type="checkbox" class="form-control" name="chk[]" value="<?php echo $arr[$i]['coursesId']; ?>" />
                                        </div>
                                        <div class="border col-1"><?php echo $arr[$i]['coursesCategoryName']; ?></div>
                                        <div class="border col-1"><?php echo $arr[$i]['coursesName']; ?></div>
                                        <div class="border col-3 p-1"><img class="coursesImg" src="../images/courses/<?php echo $arr[$i]['coursesImg']; ?>" /></div>
                                        <div class="border col-3 p-2"><?php echo $arr[$i]['coursesContent']; ?></div>
                                        <div class="border col-1"><?php echo $arr[$i]['coursesHours']; ?></div>
                                        <div class="border col-1"><?php echo $arr[$i]['updated_at']; ?></div>
                                        <div class="border col-1 flex-column d-flex justify-content-around">
                                            <button class="smbtn btn btn-outline-light m-2" type="button" id="button-addon2" onclick="location.href=('./coursesEdit.php?coursesId=<?php echo $arr[$i]['coursesId'] ?>')"><span class="update">修改</span></button>
                                        </div>
                                    </div>

                            <?php
                                }
                            } else {?>
                               <div class="row border" style="height:150px;font-size:30px;" colspan="9">沒有資料</div>
                            <?php } ?>

                           
                            <div class="row border border-top-0 justify-content-start" colspan="9"><button class="smbtn btn btn-outline-light m-2 float-left" type="submit" name="smb">刪除</button></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script>
        document.getElementById("chk1").onclick = function() {
            let chk = document.getElementsByName('chk[]');
            if (this.checked) {
                for (let i = 0; i < chk.length; i++) {
                    chk[i].checked = "true";
                }
            } else {
                for (let i = 0; i < chk.length; i++) {
                    chk[i].checked = "";
                }
            }

        }
    </script>
    </div>
</body>

</html>
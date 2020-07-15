<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
require_once("./coursesTpl/funcBuildTree.php");
require_once("./coursesTpl/func-getRecursiveCategoryIds.php");


// //建立種類列表
// function buildTree($pdo, $parentId = 0)
// {
//     $sql = "SELECT `coursesCategoryId`, `coursesCategoryName`, `coursesCategoryParentId`
//             FROM `coursescategory` 
//             WHERE `coursesCategoryParentId` = ?";
//     $stmt = $pdo->prepare($sql);
//     $arrParam = [$parentId];
//     $stmt->execute($arrParam);
//     if ($stmt->rowCount() > 0) {
//         $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         for ($i = 0; $i < count($arr); $i++) {
//             echo "<option value='" . $arr[$i]['coursesCategoryId'] . "'>";
//             echo $arr[$i]['coursesCategoryName'];
//             echo "</option>";
//             buildTree($pdo, $arr[$i]['coursesCategoryId']);
//         }
//     }
// }
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>修改課程</title>
        <style>
            .wrapper {
                max-width: 100vw;
            }

            img.coursesImg {
                width: 250px;
                height: 200px;
            }

            .head .border {
                /* background: #EB9F24; */
                background: var(--title-bgColor);
                color: var(--title-textColor);
                font-size: 20px;
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
            }

        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="wrapper mt-5">
            <div class="mt-3">
                <div class="row mx-auto">
                    <div class="col-md-10 col-sm-6 mx-auto px-0">
                        <div class="form-group">
                            <h3>修改課程</h3>
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

                <div class="row mx-0">
                    <div class="col-md-10 col-sm-6 mx-auto">
                        <form class="mt-3" name="myForm" enctype="multipart/form-data" method="POST" action="coursesUpdate.php">
                            <div class="row head">
                                <div class="border col-2 p-3 d-flex justify-content-center">課程種類</div>
                                <div class="border col-2 p-3 d-flex justify-content-center">課程名稱</div>
                                <div class="border col-3 p-3 d-flex justify-content-center">課程照片</div>
                                <div class="border col-3 p-3 d-flex justify-content-center">課程內容</div>
                                <div class="border col-1 p-3 d-flex justify-content-center">時數</div>
                                <!-- <div class="border col-1 p-3 d-flex justify-content-center" style="width:100px">新增時間</div> -->
                                <div class="border col-1 p-3 d-flex justify-content-center">更新時間</div>
                            </div>
                            <?php
                            //SQL 敘述
                            $sql = "SELECT `courses`.`coursesId`, `coursescategory`.`coursesCategoryName`, `courses`.`coursesName`, `courses`.`coursesImg`, `courses`.`coursesContent`, 
        `courses`.`coursesHours`, `courses`.`coursesCategoryId`, `courses`.`created_at`, `courses`.`updated_at`,
        `coursescategory`.`coursesCategoryId`
FROM `courses` INNER JOIN `coursescategory`
ON `courses`.`coursesCategoryId` = `coursescategory`.`coursesCategoryId`
                WHERE `coursesId` = ? ";

                            $arrParam = [
                                (int) $_GET['coursesId']
                            ];

                            //查詢
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($arrParam);

                            //資料數量大於 0，則列出相關資料
                            if ($stmt->rowCount() > 0) {
                                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                                <div class="row d-flex">
                                    <div class="border col-2 d-flex align-items-center justify-content-center">
                                        <select class="form-control" name="coursesCategoryId">
                                            <option value="<?php echo $arr[0]['coursesCategoryId']; ?>"><?php echo $arr[0]['coursesCategoryName']; ?></option>
                                            <?php buildTree($pdo, 0); ?>
                                        </select>
                                    </div>
                                    <div class="border col-2 d-flex align-items-center justify-content-center">
                                        <input class="form-control" type="text" name="coursesName" value="<?php echo $arr[0]['coursesName']; ?>" maxlength="100" />
                                    </div>
                                    <div class="border col-3">
                                        <img class="coursesImg" src="../images/courses/<?php echo $arr[0]['coursesImg']; ?>" />
                                        <input type="file" name="coursesImg" value="" />
                                    </div>
                                    <div class="border p-2 col-3 d-flex align-items-center justify-content-center">
                                        <textarea class="form-control" type="text" name="coursesContent" rows=10 cols=45 maxlength="500"><?php echo $arr[0]['coursesContent']; ?></textarea>
                                    </div>
                                    <div class="border col-1 d-flex align-items-center justify-content-center">
                                        <textarea class="form-control" type="text" name="coursesHours" cols=3 rows=1 maxlength="3" style="resize:none;"><?php echo $arr[0]['coursesHours']; ?></textarea>
                                    </div>
                                    <div class="border col-1 d-flex align-items-center"><?php echo $arr[0]['updated_at']; ?></div>

                                </div>
                                <div class="mt-0">
                                    <input class="smbtn btn btn-outline-light my-2" type="submit" name="smb" value="更新">
                                </div>
                                <input type="hidden" name="coursesId" value="<?php echo (int) $_GET['coursesId']; ?>">
                            <?php
                            } else {
                            ?>
                                <div>
                                    <div colspan="7">沒有資料</td>
                                    </div>
                                <?php
                            }
                                ?>
                                </div>

                               
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="dd" style="display:none" class="loader3"><img src="./css/831.gif">loading..</div> -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
        <!-- <script>
            $('form').on('submit', function() {

                $.ajax({
                    url: 'coursesUpdate.php', // 要傳送的頁面
                    method: 'POST', // 使用 POST 方法傳送請求
                    dataType: 'json', // 回傳資料會是 json 格式
                    data: $('form').serialize(), // 將表單資料用打包起來送出去
                    success: function(res) {
                        if (res.success === true) {
                            alert('更新成功');
                        } else {
                            alert('請先修改資料');
                        }
                    },
                    beforeSend: function() {
                        $('#dd').show()
                    },
                    complete: function() {

                        $('#dd').hide()

                    }

                });
                return false;
            });
        </script> -->
    </body>

    </html>
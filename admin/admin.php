<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


$sqlTotal = "SELECT count(1) FROM `items`"; //SQL 敘述
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0]; //取得總筆數
$numPerPage = 5; //每頁幾筆
$totalPages = ceil($total / $numPerPage); // 總頁數
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; //目前第幾頁
$page = $page < 1 ? 1 : $page; //若 page 小於 1，則回傳 1



//商品種類 SQL 敘述
$sqlTotalCatogories = "SELECT count(1) FROM `categories`";

//取得商品種類總筆數
$totalCatogories = $pdo->query($sqlTotalCatogories)->fetch(PDO::FETCH_NUM)[0];
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>商品列表</title>
        <style>
            img.itemImg {
                width: 250px;
                height: 200px;
            }

            p {
                width: 100px;
            }

            .border {
                border: 1px solid;
            }

            img.payment_type_icon {
                width: 50px;
            }
            .btn-search{
                width:100px;
                height:47.95px;
                font-size:18px !important;
                padding:0 !important;
            }
            .check {
                width: 30px;
                height: 30px;

            }

            .border {
                text-align: center;
                /* font-size: 18px; */

            }

            .table thead th {
                vertical-align: center;
                font-size: 22px;
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
            <h3>商品列表</h3>
            <div class="title d-flex align-items-center">
                <a href="./admin.php" class="my-3 btn btn-primary btn-lg active" role="button" aria-pressed="true">返回商品列表</a>
                <p>
                    <button class="btn btn-primary mt-3 ml-3 btn-search" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> 商品搜尋 </button>
                </p>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="card card-body mb-4">

                    <form name="myForm" method="POST" action="./ProductSearch.php">

                        <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons" name="titleMethod">
                            <label class="smbtn btn btn-outline-light">
                                <input type="radio" name="option" value="options1" id="option1" checked> 名稱
                            </label>
                            <label class="smbtn btn btn-outline-light">
                                <input type="radio" name="option" value="options2" id="option2"> 價格
                            </label>
                            <label class="smbtn btn btn-outline-light">
                                <input type="radio" name="option" value="options3" id="option3"> 種類
                            </label>
                        </div>
                        <br>
                        <input style="width:300px" class="form-control my-2" type="text" name="ProductSearch" placeholder="請輸入關鍵字" required>
                        <tr>
                            <td class="border" colspan="2"><button class="smbtn btn btn-outline-light mt-4" type="submit" name="smb_add">搜尋</button>
                            </td>
                        </tr>


                    </form>
                </div>
            </div>











            <?php
            //若有建立商品種類，則顯示商品清單
            if ($totalCatogories > 0) {
            ?>
                <form name="myForm" entype="multipart/form-data" method="POST" action="ProductDel.php">
                    <table class="border table table-hover">
                        <thead class="">
                            <tr>
                                <th class="border py-3 box">
                                    <input type="checkbox" id="chk1" class="check" name="chk[]" value="" />
                                </th>
                                <th class="border py-3">名稱</th>
                                <!-- <th class="border py-3">口味</th> -->
                                <th class="border py-3">照片</th>
                                <th class="border py-3" style="width:90px">價格</th>
                                <th class="border py-3" style="width:90px">數量</th>
                                <th class="border py-3">種類</th>
                              
                                <th class="border py-3" style="width:120px">功能</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //SQL 敘述
                            $sql = "SELECT `items`.`itemId`,`items`.`flavor`, `items`.`itemName`, `items`.`imgURL`, `items`.`itemPrice`, 
                        `items`.`itemQty`, `items`.`itemCategoryId`, `items`.`created_at`, `items`.`itemImg`,
                        `categories`.`categoryName`
                FROM `items` INNER JOIN `categories`
                ON `items`.`itemCategoryId` = `categories`.`categoryId`
                ORDER BY `items`.`itemId` ASC 
                LIMIT ?, ? ";

                            //設定繫結值
                            $arrParam = [($page - 1) * $numPerPage, $numPerPage];

                            //查詢分頁後的商品資料
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($arrParam);

                            //若數量大於 0，則列出商品
                            if ($stmt->rowCount() > 0) {
                                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                for ($i = 0; $i < count($arr); $i++) {
                            ?>
                                    <tr>
                                        <td class="border">
                                            <input type="checkbox" class="check" name="chk[]" value="<?php echo $arr[$i]['itemId']; ?>" />
                                        </td>
                                        <td class="border p-3"><?php echo $arr[$i]['itemName'];?><br /><?php echo $arr[$i]['flavor']; ?></td>
                                        

                                        <td class="border p-3"> 
                                        <?php
                                        if ($arr[$i]['imgURL'] == ""){
                                            
                                            ?><img class="itemImg" src="../images/items/<?php echo $arr[$i]['itemImg'];?>" /><?php
                                        }else{
                                            ?>
                                            <img class="itemImg" src="<?php echo $arr[$i]['imgURL']; ?>" />
                                        <?php } ?>
                                    </td>
                                        <td class="border p-3"><?php echo $arr[$i]['itemPrice']; ?></td>
                                        <td class="border p-3"><?php echo $arr[$i]['itemQty']; ?></td>
                                        <td class="border p-3 p-3"><?php echo $arr[$i]['categoryName']; ?></td>
                                      

                                        <td class="border p-3">

                                            <button class="smbtn btn btn-outline-light m-2" type="button" onclick="location.href=('./edit.php?itemId=<?php echo $arr[$i]['itemId'] ?>')"><span class="update">修改</span></button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="border" colspan="9">沒有資料</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="border" colspan="9">
                                    <div class="float-left p-2">
                                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                            <a class=px-2 href="?page=<?= $i ?>"><?= $i ?></a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($total > 0) { ?>
                                <tr>
                                    <td class="border " colspan="9"><button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb" value="">刪除</button></td>
                                </tr>
                            <?php } ?>

                        </tfoot>
                    </table>
                </form>
            <?php
            } else {
                //引入尚未建立商品種類的文字描述
                require_once('./templates/noCategory.php');
            } ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
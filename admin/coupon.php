<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線


$sqlTotal = "SELECT count(1) FROM `coupon`"; //SQL 敘述
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
        <title>優惠列表</title>
        <style>
            .border {
                border: 1px solid;
            }

            img.itemImg {
                width: 250px;
            }

            .card-body {
                background: #454747 !important;
                padding: 0 !important;
            }
            .btn-search{
                width:130px;
                height:50px;
                font-size:18px !important;
                padding:0 0 !important;
            }

            .searhbtn {

                width: 400px;

            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <?php require_once('./templates/title.php'); ?>
        <div class="container mt-3">
            <h3>優惠列表</h3>
            <div class="title mb-3">
                <a href="./coupon.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">優惠一覽</a>
                <button class="btn btn-primary mx-3 btn-search" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">優惠卷搜尋</button>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="card card-body mb-3">
                    <form name="myForm" method="POST" action="./couponsearch.php">
                        <tr>
                            <td class="border" colspan="2">
                                <div class="searhbtn">
                                    <div class="input-group ml-3 ">
                                        <input class="form-control mt-4" type="text" name="search" placeholder="請入優惠券名稱" required>
                                        <div class="mx-2">
                                            <button class="smbtn btn btn-outline-light my-4" type="submit" name="smb_add">搜尋</button>
                                            <button class="smbtn btn btn-outline-light mx-1" type="reset" id=" button-addon2">重設</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </form>
                </div>
            </div>


            <?php
            //若有建立商品種類，則顯示商品清單
            if ($totalCatogories > 0) {
            ?>
                <form name="myForm" entype="multipart/form-data" method="POST" action="coupondelete.php">
                    <table class="border table table-hover">
                        <thead class="">
                            <tr>
                                <th class="border p-3 box">
                                    <input type="checkbox" id="chk1" class="form-control" name="chk[]" value="" />
                                </th>
                                <th class="border p-3">優惠名稱</th>
                                <th class="border p-3">折抵金額</th>
                                <th class="border p-3">備註</th>
                                <th class="border p-3">新增時間</th>
                                <th class="border p-3">更新時間</th>
                                <th class="border p-3">功能</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //SQL 敘述
                            $sql = "SELECT `coupon`.`couponID`, `coupon`.`couponName`, `coupon`.`couponMoney`, `coupon`.`Remarks`, 
                        `coupon`.`created_at`, `coupon`.`updated_at`
                FROM `coupon`
                ORDER BY `coupon`.`couponName` ASC 
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
                                        <td class="border p-3">
                                            <input type="checkbox" class="form-control" name="chk[]" value="<?php echo $arr[$i]['couponID']; ?>" />
                                        </td>
                                        <td class="border p-3"><?php echo $arr[$i]['couponName']; ?></td>
                                        <td class="border p-3"><?php echo $arr[$i]['couponMoney']; ?></td>
                                        <td class="border p-3"><?php echo $arr[$i]['Remarks']; ?></td>
                                        <td class="border p-3"><?php echo $arr[$i]['created_at']; ?></td>
                                        <td class="border p-3"><?php echo $arr[$i]['updated_at']; ?></td>
                                        <td class="border p-3">
                                            <button class="smbtn btn btn-outline-light m-2" type="button" id="button-addon2" onclick="location.href=('./couponedit.php?couponID=<?php echo $arr[$i]['couponID'] ?>')"><span class="update">修改</span></button>
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
                                            <a class="px-2" href="?page=<?= $i ?>"><?= $i ?></a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($total > 0) { ?>
                                <tr>
                                    <td class="border" colspan="9"><button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb">刪除</button></td>
                                </tr>
                            <?php } ?>

                            </tfoo>
                    </table>
                </form>
            <?php
            } else {
                //引入尚未建立商品種類的文字描述
                require_once('./templates/noCategory.php');
            } ?>
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
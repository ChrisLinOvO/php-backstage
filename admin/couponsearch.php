<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

$str = $_POST['search'];

$sql = "SELECT * FROM `coupon`WHERE `couponName`LIKE '%{$str}%'";

$stml = $pdo->prepare($sql);
$stml->execute();

// echo"<pre>";
// print_r($arr);
// echo"</pre>";
// exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .box {
            width: 100px;
        }

        .border {
            border: 1px solid;
        }

        img.itemImg {
            width: 250px;
        }

        .card-body {
            background: #454747 !important;
        }
        .btn-search{
                width:130px;
                height:50px;
                font-size:18px !important;
                padding:0 10px !important;
            }

        .searhbtn {

            width: 400px;

        }
    </style>
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
                                <div class="input-group mb-3">
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
                <?php

                if ($stml->rowCount() > 0) {
                    $arr = $stml->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($arr); $i++) {
                ?>
                        <tbody>
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
                        </tbody>

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
                <tr>
                    <td class="border" colspan="9"><button class="smbtn btn btn-outline-light float-left m-2" type="submit" name="smb">刪除</button></td>
                </tr>
            </table>
        </form>


        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
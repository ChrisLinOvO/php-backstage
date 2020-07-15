<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>修改教練資料</title>
        <style>
            img.itemImg {
            width: 250px;
            height: 250px;
            object-fit: cover;
            object-position: 30% 0%;
            }

            th {

                width: 100px;
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
        <div class="mt-2">
            <div class=" container title">
                <a href="./couch.php" class="my-3 btn btn-primary btn-lg active" role="button" aria-pressed="true">教練列表</a>
            </div>
            <form name="myForm" enctype="multipart/form-data" method="POST" action="couchupdate.php">
                <table class="container-fluid border table table-hover">
                    <thead class="">
                        <tr>
                            <th class="border">帳號</th>
                            <th class="border">密碼</th>
                            <th class="border">姓名</th>
                            <th class="border">照片</th>
                            <th class="border">信箱</th>
                            <th class="border">性別</th>
                            <th class="border">手機號碼</th>
                            <th class="border">生日</th>
                            <th class="border">地址</th>
                            <th class="border">新增時間</th>
                            <th class="border">更新時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //SQL 敘述
                        $sql = "SELECT `couch`.`c_id`, `couch`.`c_username`, `couch`.`c_pwd`, `couch`.`c_name`, `couch`.`c_img`, 
                        `couch`.`c_email`, `couch`.`c_gender`, `couch`.`c_phoneNumber`, `couch`.`c_birthday`, `couch`.`c_address`,`couch`.`created_at`, `couch`.`updated_at`
                FROM `couch`
                WHERE `c_id` = ? ";
                        $arrParam = [
                            (int) $_GET['c_id']
                        ];

                        //查詢
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($arrParam);

                        //資料數量大於 0，則列出相關資料
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                            <tr >
                            <td class="border p-1"><?php echo $arr[0]['c_username']; ?></td>
                                <td class="border p-1">
                                    <input class="form-control" type="password" name="c_pwd" placeholder="請輸入密碼" value="" maxlength="30" required/>
                                </td>
                                <td class="border p-1">
                                    <input class="form-control" type="text" name="c_name" value="<?php echo $arr[0]['c_name']; ?>" maxlength="40" />
                                </td>
                                <td class="border p-1">
                                    <img class="itemImg" src="../images/couch/<?php echo $arr[0]['c_img']; ?>" /><br />
                                    <input class="form-control" type="file" name="c_img" value="" />
                                </td>
                                <td class="border p-1">
                                    <input class="form-control" type="email" name="c_email" value="<?php echo $arr[0]['c_email']; ?>" maxlength="40" />
                                </td>
                                <td class="border p-1">
                                    <select class="form-control" name="c_gender">
                                        <option value="男" selected>男</option>
                                        <option value="女">女</option>
                                    </select>
                                </td>
                                <td class="border p-1">
                                    <input class="form-control" type="text" name="c_phoneNumber" value="<?php echo $arr[0]['c_phoneNumber']; ?>" maxlength="40" />
                                </td>
                                <td class="border p-1">
                                    <input class="form-control" type="date" name="c_birthday" value="<?php echo $arr[0]['c_birthday']; ?>" maxlength="40" />
                                </td>
                                <td class="border p-1">
                                    <textarea class="form-control"  type="text" name="c_address" maxlength="40"  rows="3"><?php echo $arr[0]['c_address']; ?></textarea>
                                </td>
                                <td class="border p-1"><?php echo $arr[0]['created_at']; ?></td>
                                <td class="border p-1"><?php echo $arr[0]['updated_at']; ?></td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td colspan="11">沒有資料</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border p-2" colspan="11"><button class="smbtn btn btn-outline-light m-2" type="submit" name="smb">更新</button></td>
                    </tr>
                    </tfoot>
                </table>
                <input type="hidden" name="c_id" value="<?php echo (int) $_GET['c_id']; ?>">
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>

    </html>
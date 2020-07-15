<?php
require_once('./checkAdmin.php');
require_once('../db.inc.php');
require_once('../tpl/tpl-html-head.php');
require_once('./templates/title.php');
?>
<style>
input.valid{
  border:2px solid green;
}
input.invalid{
  border:2px solid red;
}
</style>
<body>
    <div class="container mt-3">
        <h3 class="my-3">新增</h3>
        <form name="myForm" enctype="multipart/form-data" method="POST" action="./couchadd.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <h5 for="inputc_username">帳號</h5>
                    <input style="width:460px" type="text" class="form-control" id="inputc_username" name="c_username" placeholder="請輸入帳號" value="" required/>
                </div>
                <div class="form-group col-md-6">
                    <h5 for="inputc_pwd">密碼</h5>
                    <input style="width:460px" type="password" class="form-control" id="inputc_pwd" name="c_pwd" placeholder="請輸入密碼" value="" required/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <h5 for="inputc_name">姓名</h5>
                    <input style="width:460px" type="text" class="form-control" id="inputc_name" name="c_name" placeholder="請輸入姓名" value="" required/>
                </div>
                <div class="form-group col-md-6">
                    <h5 for="inputc_email">信箱</h5>
                    <input style="width:460px" type="email" class="form-control" id="inputc_email" name="c_email" placeholder="請輸入信箱" value="" required/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <h5 for="inputc_gender">性別</h5>
                            <select style="width:180px" id="inputc_gender" name="c_gender" class="form-control">
                                <option value="男" selected>男</option>
                                <option value="女">女</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <h5 for="inputc_birthday">生日</h5>
                            <input style="width:180px" type="date" class="form-control" id="inputc_birthday" name="c_birthday" placeholder="請輸入生日" value="" required/>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <h5 for="inputc_phoneNumber">手機號碼</h5>
                    <input style="width:460px" type="text" class="form-control" id="inputc_phoneNumber" name="c_phoneNumber" placeholder="請輸入手機號碼" minlength="10" pattern="[0-9]*" value="" >
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <h5 for="inputc_img">上傳照片</h5>
                    <input style="width:460px" type="file" class="form-control" id="inputc_img" name="c_img" value="">
                </div>
                <div class="form-group col-md-6">
                    <h5 for="inputc_address">住址</h5>
                    <input style="width:460px" type="text" class="form-control" id="inputc_address" name="c_address" placeholder="請輸入住址" value="" required/>
                </div>
            </div>
            <button type="submit" class="smbtn btn btn-outline-light float-left m-2">新增</button>
        </form>
    </div>
    <script>
        var inputs = document.querySelectorAll('input')
        inputs.forEach( input => {
            input.addEventListener('input',function(){
                if(input.checkValidity()){
                    input.classList.add('valid')
                    input.classList.remove('invalid')
                }else{
                    input.classList.remove('valid')
                    input.classList.add('invalid')
               
                    
                }
            })
        })
    </script>
    </body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            :root {
                --header-bgColor: #0e0e0e;
                --title-bgColor: #0e0e0e;
                --title-textColor: white;
                --textColor: white;
                --bodyBgColor: #292B2B;
            }

            body {
                font-family: 微軟正黑體 !important;
                background: var(--bodyBgColor);
                color: #E8EEF2 !important;
                font-style: bolder;
                overflow-y: scroll;
            }

            body::-webkit-scrollbar{
                display: none;
            }

            .border {
                border: 2px solid
            }

            .navbar {
                background: var(--header-bgColor);
            }

            .navbar-brand {
                color: red;
                transition: .5s;
                border-radius: 5%;
                padding: 10px;
            }

            .navbar-brand:hover {
                color: black;
                background: white;
            }

            .dropdown-toggle {
                background: var(--header-bgColor);
                margin: 0 20px;
                padding: 10px;
                color: lightcyan;
                transition: .5s;
                border-radius: 5%;
                padding: 10px;
                font-size: 20px;
            }

            .dropdown-toggle:hover {
                color: black;
                background-color: white;
            }

            .dropdown-item,
            .dropdown-menu {
                background: var(--header-bgColor);
                color: var(--title-textColor);
                transition: .3s;
            }
            .head,
            th,
            thead .border {
                /* background: #EB9F24; */
                background: var(--title-bgColor);
                color: var(--title-textColor);
            }

            thead,
            th {
                font-size: 26px;
                background: var(--title-bgColor);
                color: var(--title-textColor);
            }

            .smbtn {
                background-color: #0e0e0e;
                color: wheat;
                border-radius:5%;
                /* border:0; */
            }

            .smbtn :hover {
                color: black !important;
                /* border:0; */
            }

            td {
                vertical-align: middle !important;
                padding: 0 !important;
                text-align: center;
                color: var(--textColor) !important;
            }

            th {
                text-align: center;
            }

            .box {
                width: 100px;
            }

            .checkBox {
                width: 50px;
            }

            .navbar-nav a {
                /* color: red; */
                transition: .5s;
            }

            .navbar-nav a:hover {
                text-decoration: none;
                color: black;
                transform: translate(5px, -5px)
            }

            li {
                list-style: none;
                font-size:20px;
            }
            a{
                /* background:black; */
                color:wheat;
                /* padding:10px; */
                font-size:20px;
            }
            a:hover{
                color:red;
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="./admin.php">WoW GYM</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto ulList">
                    <li class="nav-item active">
                        <div class="dropdown show">
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                商品管理
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="./category.php">編輯商品類別</a>
                                <a class="dropdown-item" href="./paymentType.php">編輯付款方式</a>
                                <a class="dropdown-item" href="./new.php">新增商品</a>
                                <a class="dropdown-item" href="./admin.php">商品列表</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <div class="dropdown show">
                            <a class="btn dropdown-toggle" href="./orders.php" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                訂單管理
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="./orders.php">訂單列表</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <div class="dropdown show">
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                優惠管理
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="./couponnew.php">新增優惠</a>
                                <a class="dropdown-item" href="./coupon.php">優惠列表</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <div class="dropdown show">
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                教練管理
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="./couchnew.php">新增教練</a>
                                <a class="dropdown-item" href="./couch.php">教練列表</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <div class="dropdown show">
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                課程管理
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="./coursesCategory.php">編輯課程類別</a>
                                <a class="dropdown-item" href="./coursesNew.php">新增課程</a>
                                <a class="dropdown-item" href="./coursesPage.php">課程列表</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <div class="dropdown show">
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                文章管理
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="./articleCategory.php">編輯文章類別</a>
                                <a class="dropdown-item" href="./articleNew.php">新增文章</a>
                                <a class="dropdown-item" href="./article.php">文章列表</a>
                            </div>
                        </div>
                    </li>
                </ul>

                <a class="btn btn-outline-light my-2 my-sm-0" href="../logout.php?logout=1">登出</a>
            </div>
        </nav>

    </html>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
<style>
    body {

        background-image: url(https://cdn.pixabay.com/photo/2013/04/14/22/43/oak-ridge-104060_960_720.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        /* font-weight:bold !important; */
        /* font-size:20px !important; */
        font-family: 'Roboto', sans-serif !important;
    }

    .card {

        text-align: center;
        margin: auto;
        top: 15vh;
        border: none !important;
        background: black !important;
        /* color:white; */
    }

    .list-group-item {
        width: 486px;
    }

    .circle{
        width:20px !important;
    }

    .container {
        filter: blur(0px);
    }
    .list-group li{
        background: black;
        color:white;
        font-size:20px;
    }
    .list-group li a{
        color:white;
        font-size:20px;
    }
    .login:hover{
        background-color:#c71010;
        color:white;
        font-weight: bold;
    }
</style>
<html>

<body>
    <?php if (!isset($_SESSION["username"])) {
    ?>
        <div class="container">
            <div class="card" style="width: 28rem;">
                <img src="https://cdn.pixabay.com/photo/2014/11/17/13/17/crossfit-534615_960_720.jpg" class="card-img-top" alt="...">

                <ul class="list-group list-group-flush">
                    <form class="form-inline my-2 my-md-0" name="myForm" method="post" action="./login.php">
                        <li class="list-group-item">
                            <h5 style="color:red; font-size:30px; font-weight:bold;">WOW GYM</h5>
                        </li>
                        <li class="list-group-item">Account：
                            <input class="ml-3 form-control form-bg" type="text" name="username" value="" maxlength="50" />
                        </li>
                        <li class="list-group-item">Password：
                            <input class="form-control form-bg" type="password" name="pwd" value="" maxlength="50" />
                        </li>
                        <li class="list-group-item d-flex justify-content-around">
                            <label class="" for="buyer">User</label> <input class="form-control circle" id="buyer" type="radio" name="identity" value="users" checked />
                            <label class="" for="seller">Admin</label> <input class="form-control circle" id="seller" type="radio" name="identity" value="admin" />
                        </li>
                </ul>
                <div class="card-body" style="background: black">
                    <a href="#" class="card-link"> <input class="form-control login" type="submit" value="Login" />
                    </a>
                </div>
                </form>
            <?php } else {
            header("refresh:3;url=./loginA");
            ?>
                <a href="../logout.php?logout=1">登出</a>
            <?php } ?>


            </div>
        </div>
</body>

</html>











<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
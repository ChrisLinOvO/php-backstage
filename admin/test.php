<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            font-size:30px !important;
        }
        .card {
            margin: 60px auto;
        }

        .box {
            margin:40px auto;
        }

        .con {
            width: 1000px;
            margin: auto;
            /* margin-top: 60px; */
            text-align: center;

        }

        /* .card{
                width:800px;
            } */

        .card-text {
            margin: 20px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
    <div class="con">
        <div class="card text-white bg-dark mb-3" style="max-width: 50rem;height:30rem;">
            <div class="card-header" style="height:5rem;">文章列表</div>
            <div class="box">
                <div class="card-body">
                    <span class="badge badge-success p-3">Success</span>
                    <p class="card-text p-3">文章刪除成功</p>
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm text-success" role="status" aria-hidden="true"></span>
                        將跳回上一頁
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
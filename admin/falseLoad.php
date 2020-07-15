<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      body{
                background: #292B2B !important;
                color:white !important;
                font-family: 微軟正黑體 !important;
            }
      .lds-dual-ring {
  display: inline-block;
  width: 80px;
  height: 80px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 64px;
  height: 64px;
  margin: 8px;
  border-radius: 50%;
  border: 6px solid #dfc;
  border-color: #dfc transparent #dfc transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
section{
  display: flex;
  align-items: center;
  position: fixed;
  top: 30%;
  left: 45%;
}
span{
  margin-left: 20px;
  font-size: 2rem;
}
    </style>
</head>
<body>
  <section>
    <div class="lds-dual-ring"></div>
    <span>更改失敗</span>
    </section>
</body>
</html>
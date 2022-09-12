<?php
if(!isset($_POST["intid"])){
    echo "Тебе тут нечего делать.";
    header("Location: /lk/index.php");
}else{
    $res=true;
}
/*if (!$_SESSION['admin'])
{
    echo "Нет прав доступа.";
    exit();
}*/?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FunPlay - LK</title>

    <link href="/lk/css/bootstrap.min.css" rel="stylesheet">
    <link href="/lk/css/datepicker3.css" rel="stylesheet">
    <link href="/lk/css/styles.css" rel="stylesheet">
    <link href="/lk/css/Opentip.css" rel="stylesheet"/>

    <script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
</head>

<body>

<?if($res){?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Спасибо за Ваше добровольное пожервование проекту.</div>
                <div class="panel-body">Детали платежа отправлены на указанную Вами почту. Если возникнут проблемы с платежем, напишите администрации проекта.</div>
                <div class="panel-body">В виде благодарности с нашей стороны, начислили вам Coin of Luck личный кабинет, по указанному при платеже адресу электронной почты .
                </div>
                <div class="panel-body"><a href="https://pwfunplay.ru/lk/">В личный кабинет  </a><br><br><a href="https://pwfunplay.ru/forum/">На форум </a></div>
            </div>
        </div>
    </div><!--/.row--><?}  ?>

</body>
</html>

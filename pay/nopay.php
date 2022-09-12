<?php
/*if(!isset($_POST["intid"])){
    echo "Тебе тут нечего делать.";
    header("Location: /lk/index.php");
}else{
    $res=true;
}*/
$page = "roles"; $subpage = "okpay"; include("../header.php");
/*if (!$_SESSION['admin'])
{
    echo "Нет прав доступа.";
    exit();
}*/?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ошибка платежа.</div>
                <div class="panel-body">Ваш платеж не прошел. Если прошло какое либо списание, напишите администрации проекта и в службу поддержки платежного шлюза <a href="https://www.free-kassa.ru">www.free-kassa.ru</a>></div>
                </div>
            </div>
        </div>
    </div><!--/.row-->

<? include("../footer.php"); ?>
?>
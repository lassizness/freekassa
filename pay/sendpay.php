<?
$fk_merchant_id = ''; //merchant_id ID магазина в freekassa.ru https://merchant.freekassa.ru/settings
$fk_merchant_key = ''; //Секретное слово https://merchant.freekassa.ru/settings

if (isset($_GET["currency"])) {
    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);//отделили урл от гет
    $url = $url[1];//взяли гет
    // if(isset($_GET["prepare_once"])){
    $hash = md5($fk_merchant_id . ':' . $_GET['oa'] . ':' . $fk_merchant_key . ':' . $_GET["currency"] . ':' . $_GET["o"]);
    echo '<hash>' . $hash . '</hash>';
    $url = explode("&", $url);//получаем гет пареметры
    $url[2] = "s=" . $hash;//перезапысываем гет с подписью
    foreach ($url as $value) {
        $sendget = $sendget . $value . "&";
    }
    unset($_GET);//чистим гет
    header("Location: https://pay.freekassa.ru?$sendget");//отправляем все на платежный шлюз
}
?>
<script src="http://yandex.st/jquery/1.6.0/jquery.min.js"></script>
<script type="text/javascript">
    var min = 1;

    function calculate() {
        var re = /[^0-9\.]/gi;
        var url = window.location.href;
        var desc = $('#desc').val();
        var sum = $('#sum').val();
        if (re.test(sum)) {
            sum = sum.replace(re, '');
            $('#oa').val(sum);
        }
        if (sum < min) {
            $('#error').html('Сумма должна быть больше ' + min);
            $('#submit').attr("disabled", "disabled");
            return false;
        } else {
            $('#error').html('');
            $('#submit').removeAttr("disabled");
        }
        if (desc.length < 1) {
            $('#error').html('Необходимо ввести номер заявки');
            return false;
        }
    }
</script>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Добровольное пожервование проекту</div>
            <div class="panel-body">
                <? if (!isset($_POST['act'])) { ?>
                    <div class="alert bg-primary" role="alert"><span class="glyphicon glyphicon-info-sign"></span> На
                        этой странице вы можете пожертвовать на существование проекта.
                    </div>
                    <div class="alert bg-primary" role="alert"><span class="glyphicon glyphicon-info-sign"></span> При
                        переходе на страницу оплаты, указывайте свой регистрационный email, без него мы не узнаем, что
                        пожертвовали нам именно Вы! Это обязательно!
                    </div>
                    <div class="alert bg-primary" role="alert"><span class="glyphicon glyphicon-info-sign"></span> К
                        сожалению, платежный шлюз установил минимальную сумму оплаты 10 рублей. Также можно оплатить
                        тенге и гривнами.
                    </div>
                    <div class="alert bg-primary" role="alert"><span class="glyphicon glyphicon-info-sign"></span> При
                        возникновении проблем с начислением вознагрождений за ваши добровольные пожертвования,
                        незамедлительно напишите на форуме лс lazzy или Menikus.
                    </div>

                <? } ?>
                <p>Пожертвовать можно любую сумму. Вам будет выдан бонус в виде Coin of Luck. Конвертирование будет
                    произведено из курса 19р к 1 Coin of Luck.</p>
                <div id="error"></div>
                <div class="sendpayform">
                    <form class="ui-form" method="GET" action="getpay.php">
                        <input type="hidden" name="m" value="<?= $fk_merchant_id ?>">
                        <div class="form-row">
                            <p>Вводите только цыфры.</p>
                            <input type="text" pattern="^[ 0-9]+$" name="oa" id="sum" id="oa" onchange="calculate()"
                                   onkeyup="calculate()" onfocusout="calculate()" onactivate="calculate()"
                                   ondeactivate="calculate()"> Введите сумму для оплаты
                        </div>
                        <input type="hidden" name="s" id="s" value="0">

                        <input type="hidden" name="currency" value="RUB">
                        <!--<div class="select">
                                                <select id="currency" name="currency" onchange="oncklick()">
                                                        <option value="RUB">Рубли</option>
                                                    <option value="UAH">Гривны</option>
                                                    <option value="KZT">Тенге</option>
                                                </select>
                        </div>-->
                        <input type="hidden" name="o" id="desc" value="pozhertvovanie" onchange="calculate()"
                               onkeyup="calculate()" onfocusout="calculate()" onactivate="calculate()"
                               ondeactivate="calculate()">
                        <input type="submit" id="submit" value="Оплатить" disabled>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->

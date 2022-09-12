<?php

$mysqlconf["host"] = "localhost";
$mysqlconf["user"] = "user";
$mysqlconf["password"] = "pass";
$mysqlconf["db"] = "bd";

function getIP()
{
    if (isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
    return $_SERVER['REMOTE_ADDR'];
}

if (!in_array(getIP() , array(
    '168.119.157.136',
    '168.119.60.227',
    '138.201.88.124',
    '178.154.197.79'
))) die("hacking attempt!");

/*$_POST["MERCHANT_ID"];//ID Вашего магазина
$_POST["AMOUNT"];//Сумма заказа
$_POST["intid"];//номер операции
$_POST["MERCHANT_ORDER_ID"];//id заказа
$_POST["P_EMAILD"];//	Email
$_POST["P_PHONE"];//	Телефон плательщика (если указан)
$_POST["CUR_ID"];//	ID электронной валюты, который был оплачен заказ (список валют)
$_POST["SIGN"];//	Подпись (методика формирования подписи в данных оповещения)
$_POST["us_key"];//	Дополнительные параметры с префиксом us_, переданные в форму оплаты*/

$today = date("Y-m-d H:i:s");
$file = "paylog.txt";
if (isset($_POST["MERCHANT_ID"]) && isset($_POST["AMOUNT"]) && isset($_POST["MERCHANT_ORDER_ID"]) && isset($_POST["P_EMAIL"]) && isset($_POST["CUR_ID"]))
{
    if (!empty($_POST["AMOUNT"]) && !empty($_POST["P_EMAIL"]) && !empty($_POST["CUR_ID"]))
    {
        file_put_contents($file, $_POST["P_EMAIL"] . "\t" . $_POST["AMOUNT"] . "\t" . $_POST["CUR_ID"] . "\t" . $today . "\n", FILE_APPEND);
        if ($link = mysqli_connect($mysqlconf["host"], $mysqlconf["user"], $mysqlconf["password"]))
        {
            if (mysqli_select_db($link, $mysqlconf["db"]))
            {
                if ($result = mysqli_query($link, "SELECT `ID` FROM `users` WHERE `email`='" . $_POST["P_EMAIL"] . "'"))
                {
                    if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {
                        $userid = $row["ID"];
                        $result = MySQLi_Query($link, "SELECT DonatPoint FROM `users` WHERE `ID`=$userid");
                        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                        {
                            $DonatPoint = $row['DonatPoint'];
                            if (isset($ratecoin[$_POST["CUR_ID"]]))
                            {
                                $rate = $ratecoin[$_POST["CUR_ID"]];
                            }
                            else
                            {
                                file_put_contents($file, "Payment system ID not found, default rates assigned.\t" . $today . "\n", FILE_APPEND);
                                $rate = $ratecoin["default"];
                            }
                            $CurentPointForPay = ($_POST["AMOUNT"] / $rate);
                            $DonatPoint = $DonatPoint + $CurentPointForPay;
                            mysqli_query($link, "INSERT CoinLog (userid, point, cash,creatime,description) VALUES ($userid, 'Luck', '+" . $CurentPointForPay . "','$today','donat')");
                            mysqli_query($link,"call usecash(".$userid.",1,0,1,0,1000000,1,@error)");
                            if ($row = mysqli_query($link, "select referer from users where ID=".$userid)) {
                                $row = mysqli_fetch_row($row);
                                if($ref = mysqli_query($link, "select ID from users where name='".$row[0]."'")){
                                    $ref_id=mysqli_fetch_row($ref);
                                    $ref_id= $ref_id[0];
                                    $refPointlog=$CurentPointForPay/10;
                                    $refPointlog=round($refPointlog,1);
                                    mysqli_query($link, "INSERT CoinLog (userid, point, cash,creatime,description) VALUES ($ref_id, 'Luck', '+" . $refPointlog . "','$today','referal')");
                                    $RegDonPoint = mysqli_query($link, "SELECT DonatPoint FROM users WHERE ID='".$ref_id."'");
                                    $RegDonPoint=mysqli_fetch_row($RegDonPoint);
                                    $RegDonPoint=$RegDonPoint[0];
                                    $RegDonPoint=$RegDonPoint+$refPointlog;
                                    mysqli_query($link, "UPDATE users SET DonatPoint = " . $RegDonPoint . " where ID=".$ref_id);
                                }
                            }

                            mysqli_query($link, "UPDATE users SET DonatPoint = " . $DonatPoint . " where ID =$userid");
                        }
                    }
                    else
                    {
                        file_put_contents($file, "Error getting query result\t" . $today . "\n", FILE_APPEND);
                    }
                }
                else
                {
                    file_put_contents($file, "Error sending query to database\t" . $today . "\n", FILE_APPEND);
                }
            }
            else
            {
                file_put_contents($file, "Database selection error\t" . $today . "\n", FILE_APPEND);
            }
        }
        else
        {
            file_put_contents($file, "Database connection error\t" . $today . "\n", FILE_APPEND);
        }
    }
    else
    {
        file_put_contents($file, "Error in the second condition.\t" . $today . "\n", FILE_APPEND);
    }
    die('YES');
}
else
{
    file_put_contents($file, "Error in the first condition.\t" . $today . "\n", FILE_APPEND);
}

?>

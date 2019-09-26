<?php
/*require_once 'vendor/autoload.php';
require_once 'func/functions.php';

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);
$sql = 'SELECT user_name, l.id AS lot_win_id, lot_title, winner_id
        FROM lots l JOIN users u ON winner_id = u.id WHERE winner_id IS NOT NULL';

$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result)) {
    $lots_win = mysqli_fetch_all($result, MYSQLI_ASSOC);
}*/

var_dump($lots_win);

//$message = new Swift_Message();
//$message->setSubject("Ваша ставка победила");
//$message->setFrom(['keks@phpdemo.ru' => 'GifTube']);
//$message->setBcc($recipients);

//$msg_content = include_template('_email.php', ['lots_win' => $lots_win]);
//$message->setBody($msg_content, 'text/html');
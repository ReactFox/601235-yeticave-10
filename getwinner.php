<?php
require_once 'vendor/autoload.php';

$sql = 'SELECT * FROM lots l WHERE date_finish < NOW()
AND winner_id IS NULL';
$result = mysqli_query($con, $sql);

if (!empty($result)) {
    $lots_finished = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $winners_id = [];
    foreach ($lots_finished as $lots_finish) {
        $sql = "SELECT * FROM bets WHERE lot_id = {$lots_finish['id']} ORDER BY date_bet DESC LIMIT 1";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $winners_id[] = mysqli_fetch_assoc($result);
        } else {
            $error = mysqli_error($con);
            echo $error;
        }
    }

    $winners_id = array_filter($winners_id);

    foreach ($winners_id as $winner_id) {
        $sql = "UPDATE lots SET winner_id = {$winner_id['user_id']} WHERE id = {$winner_id['lot_id']}";
        $result = mysqli_query($con, $sql);
    }
}


$transport = new Swift_SmtpTransport('mail.reactfox.ru', 25);
$transport->setUsername('info@reactfox.ru');
$transport->setPassword('lXrR40eubG');
$mailer = new Swift_Mailer($transport);

$sql = 'SELECT winner_id, user_name, l.id AS lot_win_id, lot_title, email
        FROM lots l JOIN users u ON winner_id = u.id WHERE winner_id IS NOT NULL';

$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result)) {
    $lots_win = mysqli_fetch_all($result, MYSQLI_ASSOC);
}


foreach ($lots_win as $lot_win) {
    $recipient = [];
    $recipient[$lot_win['email']] = $lot_win['user_name'];

    $message = new Swift_Message();
    $message->setSubject("Ваша ставка победила");
    $message->setFrom(['info@reactfox.ru' => 'Yeticave']);
    $message->setTo($recipient);
    unset($recipient);

    $msg_content = include_template('_email.php', [
        'lot_win' => $lot_win
//        'user_name' => $lot_win['user_name'],
//        'lot_title' => $lot_win['lot_title'],
//        'lot_win_id' => $lot_win['lot_win_id'],
    ]);
    $message->setBody($msg_content, 'text/html');
    $res = $mailer->send($message);

    if ($res) {
        print("Рассылка успешно отправлена");
    } else {
        print("Не удалось отправить рассылку");
    }
}

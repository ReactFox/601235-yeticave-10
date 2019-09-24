<?php

$sql = 'SELECT * FROM lots l WHERE date_finish < NOW()
AND winner_id IS NULL';
$result = mysqli_query($con, $sql);

if (!empty($result)) {
    $lots_finished = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $winners_id = [];
    foreach ($lots_finished as $lots_finish) {
        $sql = "SELECT * FROM bets WHERE lot_id = {$lots_finish['id']} ORDER BY date_bet DESC limit 1";
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

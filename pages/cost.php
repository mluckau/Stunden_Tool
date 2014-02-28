<?php
/**
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 10 is a good baseline, and more is good if your servers
 * are fast enough.
 */
$timeTarget = 0.6; 

$cost = 8;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Appropriate Cost Found: " . $cost . "\n";

//$options = [
//    'cost' => $cost,
//];
//echo password_hash("test", PASSWORD_BCRYPT, $options)."\n";

//$hash = password_hash("test", PASSWORD_BCRYPT, $options);

//if (password_verify('test, $hash)) {
//    echo 'Password is valid!';
//} else {
//    echo 'Invalid password.';
//}

//var_dump(password_get_info($hash));
?>


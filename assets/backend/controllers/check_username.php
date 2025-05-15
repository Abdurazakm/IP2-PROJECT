<?php

require_once '../models/User.php';

if (isset($_GET['username'])){
    $available = User::check_username($_GET['username']);
}
 echo json_encode(['available' => $available]);

?>
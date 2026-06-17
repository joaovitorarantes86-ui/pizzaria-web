<?php
// encerra sessao admin
session_start();
session_destroy();
header('Location: login.php');
exit;
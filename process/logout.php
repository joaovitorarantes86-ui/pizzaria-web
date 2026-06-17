<?php
// encerra sessao e volta pro inicio
session_start();
session_destroy();
header('Location: ../index.php');
exit;

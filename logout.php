<?php
// Stran ki omogoča odjavo: uničimo sejo in preusmerimo na vstopno stran
session_start();
session_unset();
session_destroy();
header("Location: /");
?>
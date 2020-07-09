<?php
    session_start();
    unset($_SESSION["user"]);
    unset($_SESSION["logsession"]);
    header("location:https://mimify.ml/Login");
?>
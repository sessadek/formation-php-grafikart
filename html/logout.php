<?php
session_start();
unset($_SESSION['is_connected']);
header('Location: /');

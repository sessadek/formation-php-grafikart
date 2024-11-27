<?php

use App\App;

require_once '../vendor/autoload.php';

App::getAuth()->requireRole('admin');

?>Réservé à l'admin
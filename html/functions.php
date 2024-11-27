<?php
function dump($variable) {
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
}

function html_creneaux(array $creneaux): string {
    if(empty($creneaux)) {
        return 'Fermé';
    }
    $html_creneaux = [];
    foreach($creneaux as $creneau) {
        $html_creneaux[] = "de $creneau[0]h à $creneau[1]h";
    }
    return 'Ouvert ' . implode(' et ', $html_creneaux);
}


function in_creneau(int $hour, array $creneaux): bool {
    foreach($creneaux as $creneau) {
        if($creneau[0] <= $hour && $hour <= $creneau[1]) {
            return true;
        }
    }
    return false;
}


function add_view(): void {
    $filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur';
    $filename_daily = $filename . '-' . date('Y-m-d');
    create_counter_file($filename);
    create_counter_file($filename_daily);
}

function create_counter_file(string $filename) {
    $counter = 1;
    if(file_exists($filename)) {
        $counter = (int)file_get_contents($filename);
        $counter++;
    }
    file_put_contents($filename, $counter);
}

function show_view(): string {
    $filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur';
    return file_get_contents($filename);
}

function show_view_per_month(int $year, string $month): int {
    $filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur-' . $year . '-' . $month . '-*';
    $files = glob($filename);
    $total = 0;
    foreach($files as $file) {
        $total += (int)file_get_contents($file);
    }
    return $total;
}

function detail_views(int $year, string $month):array {
    $filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur-' . $year . '-' . $month . '-*';
    $files = glob($filename);
    $views = [];
    foreach($files as $file) {

        $parts = explode('-', basename($file));
        $views[] = [
            'year' => $parts[1],
            'month' => $parts[2],
            'day' => $parts[3],
            'views' => (int)file_get_contents($file)
        ];
    }
    return $views;
}

function is_connected():bool {
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['is_connected']);
}

function redirect_to_login() {
    if(!is_connected()) {
        header('Location:login.php');
        exit();
    }
}
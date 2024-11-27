<?php
if(!function_exists('nav_item')) {

    function nav_item(string $link, string $title, string $linkClass = null): void {
        $is_active = ($_SERVER['SCRIPT_NAME'] === $link) ? 'active' : '';
        $classes = $linkClass . ' ' . $is_active;
        echo <<<HTML
        <li class="nav-item">
            <a class="$classes" href="$link">$title</a>
        </li>
HTML;
    }
}


if(!function_exists('nav_menu')) {
    function nav_menu($linkClass = null) {
        return nav_item('/index.php', 'Home', $linkClass) . nav_item('/contact.php', 'Contact', $linkClass);
    }
}
<?php

/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

/**
 * redirect to spesefic page on admin
 * @param string $url
 * @param boolan $front redirect to front page
 */
function redirect($url, $front = FALSE) {
    ($front) ? $path = URLROOT : $path = ADMINURL;
    if (!headers_sent()) {
        header('Location: ' . $path . '/' . $url);
        exit;
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $path . '/' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $path . '/' . $url . '" />';
        echo '</noscript>';
        exit;
    }
}

/**
 * Display pagination
 * @param int $allrecords
 * @param int $current
 * @param int $perpage
 * @param int $displayed_pages
 * @param string $url
 */
function pagination($allrecords, $current = 1, $perpage = 50, $displayed_pages = 4, $url = '', $page = '/index') {
    if ($allrecords > $perpage) {
        $pages = ceil($allrecords / $perpage);
        echo (($current - 1) > $displayed_pages) ? '<li><a href="' . $url . $page . '/1/' . $perpage . '"> الأولي</a></li>' : NULL;
        echo ($current > 1) ? '<li><a href="' . $url . $page . '/' . ($current - 1) . '/' . $perpage . '"> السابق </a></li>' : '<li class="disabled"><a>السابق </a></li>';
        if ($current <= $pages) {
            for ($r = ($current - $displayed_pages); $r <= $current; $r++) {
                if ($r < 1) {
                    continue;
                }
                echo '<li ';
                echo ($current == $r) ? ' class="active" ' : null;
                echo '><a href="' . $url . $page. '/' . $r . '/' . $perpage . '">' . $r . '</a></li>';
            }
            for ($l = ($current + 1); $l <= ($current + $displayed_pages); $l++) {
                if ($l > $pages) {
                    break;
                }
                echo '<li ';
                echo ($current == $l) ? ' class="active" ' : null;
                echo '><a href="' . $url . $page. '/' . $l . '/' . $perpage . '">' . $l . '</a></li>';
            }
        }
        echo ($current < $pages) ? '<li><a href="' . $url . $page. '/' . ($current + 1) . '/' . $perpage . '">التالي</a></li>' : '<li class="disabled"><a>التالي</a></li>';
        echo (($current + $displayed_pages) < $pages) ? '<li><a href="' . $url . $page. '/' . $pages . '/' . $perpage . '">الأخيرة</a></li>' : NULL;
    }
}

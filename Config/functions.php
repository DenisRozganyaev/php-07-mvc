<?php

/**
 * @param string $path - posts/5
 */
function redirect(string $path = '')
{
    header('Location: ' . SITE_URL . '/' . $path);
}

function redirectBack()
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function url(string $link = ''): string
{
    return SITE_URL . '/' . $link;
}

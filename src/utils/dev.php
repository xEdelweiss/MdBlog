<?php

if (!function_exists('dd')) {

    /**
     * Dump & Die
     *
     * @param array ...$data
     */
    function dd(...$data) {
        dump($data);
        die;
    }
}
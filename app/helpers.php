<?php

    function getLengthString($string, $length)
    {
        $string = strip_tags($string);
        $string = mb_substr($string, 0, $length);
        $string = rtrim($string, "!,.-");
        $string = mb_substr($string, 0, strrpos($string, ' '));

        return $string.'...';
    }
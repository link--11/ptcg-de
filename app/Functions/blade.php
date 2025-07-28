<?php

function date_only ($date) {
    $date_format = datefmt_create(
        'de-DE',
        IntlDateFormatter::MEDIUM,
        IntlDateFormatter::NONE,
        'Europe/Berlin',
        IntlDateFormatter::GREGORIAN
    );

    return datefmt_format($date_format, strtotime($date));
}

function short_date($date) {
    $short_date_format = datefmt_create(
        'de-DE',
        IntlDateFormatter::SHORT,
        IntlDateFormatter::SHORT,
        'Europe/Berlin',
        IntlDateFormatter::GREGORIAN
    );

    return datefmt_format($short_date_format, strtotime($date));
}

function full_date($date) {
    $full_date_format = datefmt_create(
        'de-DE',
        IntlDateFormatter::FULL,
        IntlDateFormatter::SHORT,
        'Europe/Berlin',
        IntlDateFormatter::GREGORIAN
    );

    return datefmt_format($full_date_format, strtotime($date));
}

function tournament_name ($tournament) {
    $name = __("pokemon.$tournament->type");

    if ($tournament->type === 'locals' && $tournament->format) {
        $format = $tournament->format === 'glc' ? 'GLC' : __("pokemon.$tournament->format");
        $name = "$format $name";
    }

    return $name;
}

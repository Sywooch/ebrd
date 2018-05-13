<?php

$url = 'https://api-metrika.yandex.ru/stat/v1/data';

$params = [
    'ids'         => '47926829',
    'oauth_token' => 'beb47590fb564c4eb037e4f4309a3853',
    'metrics'     => 'ym:s:visits,ym:s:pageviews,ym:s:users',
    'dimensions'  => 'ym:s:date',
    'date1'       => '7daysAgo',
    'date2'       => 'yesterday',
    'sort'        => 'ym:s:date',
];

echo file_get_contents( $url . '?' . http_build_query($params) );
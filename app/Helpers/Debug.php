<?php

function dbg(...$args)
{
    http_response_code(500);
    call_user_func('dd', $args);
}
<?php

function decodeJsonSafely(string $response): array
{
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'valid' => false,
            'error' => json_last_error_msg(),
            'raw'   => $response
        ];
    }

    return [
        'valid' => true,
        'data'  => $data
    ];
}
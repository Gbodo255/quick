<?php

namespace App\Support;

final class ApiMessage
{
    public static function sanitize(?string $message): string
    {
        if ($message === null || $message === '') {
            return 'Une erreur est survenue.';
        }

        if (mb_check_encoding($message, 'UTF-8')) {
            return $message;
        }

        $converted = @iconv('ISO-8859-1', 'UTF-8//IGNORE', $message);

        return $converted !== false ? $converted : 'Une erreur est survenue.';
    }
}

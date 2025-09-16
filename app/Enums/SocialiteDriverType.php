<?php

namespace App\Enums;

enum SocialiteDriverType: string {
case GOOGLE = 'google';

    public static function getIcons(): array {
        return [
            self::GOOGLE->value => 'backend/img/google_icon.png',
        ];
    }

    public static function getAll(): array {
        return [
            self::GOOGLE->value,
        ];
    }
}

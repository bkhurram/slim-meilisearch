<?php

declare(strict_types=1);

namespace App\Domain;

final class ProductType
{
    public const ELECTRONICS = 'electronics';

    public const ACCESSORY = 'accessory';

    public const APPAREL = 'apparel';

    public const HOME = 'home';

    public const FOOTWEAR = 'footwear';

    public static function normalize(?string $type): ?string
    {
        if ($type === null) {
            return null;
        }

        $normalized = strtolower(trim($type));

        return $normalized === '' ? null : $normalized;
    }
}

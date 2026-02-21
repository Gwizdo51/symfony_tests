<?php declare(strict_types=1);

namespace App\Enum\Badge;

use App\Enum\QueriableEnumTrait;
use App\Service\Badge\SafeDoorsBadgeService;

enum BadgeSystemsEnum: string {
    use QueriableEnumTrait;
    case SAFEDOORS = SafeDoorsBadgeService::class;
}

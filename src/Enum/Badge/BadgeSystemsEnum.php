<?php declare(strict_types=1);

namespace App\Enum\Badge;

use App\Enum\QueriableBackedEnumTrait;
use App\Service\Badge\SafeDoorsBadgeService;

enum BadgeSystemsEnum: string {
    use QueriableBackedEnumTrait;
    case SAFEDOORS = SafeDoorsBadgeService::class;
}

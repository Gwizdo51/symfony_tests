<?php declare(strict_types=1);

namespace App\Service\Badge;

use App\ApiResource\Badge\BadgeCompany;
use App\ApiResource\Badge\BadgeSystem;

final class SafeDoorsBadgeService implements BadgeServiceInterface {
    private readonly array $companies;

    public function __construct() {
        $badgeSystem = new BadgeSystem('safedoors');
        $this->companies = [
            new BadgeCompany(1, 'Reims', $badgeSystem),
            new BadgeCompany(2, 'Paris', $badgeSystem),
            new BadgeCompany(3, 'Bordeaux', $badgeSystem),
        ];
    }

    /**
     * @return BadgeCompany[]
     */
    public function getCompanies(): array {
        return $this->companies;
    }
}

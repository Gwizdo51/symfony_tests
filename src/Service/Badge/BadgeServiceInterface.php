<?php declare(strict_types=1);

namespace App\Service\Badge;

use App\ApiResource\Badge\BadgeCompany;

interface BadgeServiceInterface {
    /**
     * @return BadgeCompany[]
     */
    public function getCompanies(): array;
}

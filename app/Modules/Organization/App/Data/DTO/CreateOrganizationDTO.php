<?php

namespace App\Modules\Organization\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\Organization\App\Data\ValueObject\OrganizationVO;

final class CreateOrganizationDTO extends BaseDTO
{
    public function __construct(
        public User $user,
        public OrganizationVO $organizationVO,
    ) { }

    public static function make(

        User $user,
        organizationVO $organizationVO,

    ) : self {

        return new self(
            user: $user,
            organizationVO: $organizationVO,
        );

    }
}


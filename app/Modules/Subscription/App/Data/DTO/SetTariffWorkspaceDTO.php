<?php

namespace App\Modules\Subscription\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\App\Data\ValueObject\TariffWorkspaceVO;

class SetTariffWorkspaceDTO extends BaseDTO
{
    public function __construct(

        public User $user,
        public TariffWorkspaceVO $tariffWorkspaceVO,
        public PersonalArea $personalArea,

    ){ }

    public static function make(

        User $user,
        TariffWorkspaceVO $tariffWorkspaceVO,
        PersonalArea $personalArea,

    ) : self {


        return new self(
            user: $user,
            tariffWorkspaceVO: $tariffWorkspaceVO,
            personalArea: $personalArea,
        );
    }

}

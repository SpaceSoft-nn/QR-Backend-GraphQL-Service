<?php

namespace App\Modules\Subscription\App\Data\DTO;

use App\Modules\Base\DTO\BaseDTO;


class PriceTariffWorkspaceCalculationDTO extends BaseDTO
{
    public function __construct(

        public int $count_workspace,
        public int $period,

    ){ }

    public static function make(

        int $count_workspace,
        int $period,

    ) : self {


        return new self(
            count_workspace: $count_workspace,
            period: $period,
        );
    }

}

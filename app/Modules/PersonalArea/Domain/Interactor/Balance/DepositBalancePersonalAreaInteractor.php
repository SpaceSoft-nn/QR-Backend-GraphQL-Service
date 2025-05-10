<?php

namespace App\Modules\PersonalArea\Domain\Interactor\Balance;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\PersonalArea\App\Data\DTO\DepositBalanceDTO;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;

class DepositBalancePersonalAreaInteractor extends BaseInteractor
{


    /**
     * @param DepositBalanceDTO $dto
     *
     * @return bool
     */
    public function execute(BaseDTO $dto) : bool
    {
        return $this->run($dto);
    }


    /**
     * @param DepositBalanceDTO $dto
     *
     * @return bool
     */
    protected function run(BaseDTO $dto) : bool
    {

        /** @var bool */
        $status = DB::transaction(function ($pdo) use($dto) {



            return true;
        });

        return $status;
    }


}

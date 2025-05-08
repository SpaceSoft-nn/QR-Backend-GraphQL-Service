<?php

namespace App\Modules\PersonalArea\Domain\Interface\Service;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Interface\Service\IService;

interface IBalanceService extends IService
{
    /**
     * пополнение Баланса
     * @param BaseDTO $dto
     *
     * @return bool
    */
    public function deposit(BaseDTO $dto) : bool;


    /**
     * списание
     * @param BaseDTO $dto
     *
     * @return bool
    */
    public function withdrawal(BaseDTO $dto) : bool;


    /**
     * корректировка
     * @param BaseDTO $dto
     *
     * @return bool
    */
    public function adjustment(BaseDTO $dto) : bool;
}


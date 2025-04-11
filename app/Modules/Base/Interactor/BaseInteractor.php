<?php

namespace App\Modules\Base\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use App\Modules\Base\Interface\Interactor\IInteractor;


abstract class BaseInteractor implements IInteractor
{
    abstract public function make(BaseDTO $dto);
    abstract protected function run(BaseDTO $dto);
}

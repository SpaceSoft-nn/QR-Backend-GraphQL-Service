<?php

namespace App\Modules\Transaction\App\Repositories;

use App\Modules\User\Domain\Models\User;
use App\Modules\Transaction\Domain\Models\QrCode;
use App\Modules\Base\Interface\Repositories\CoreRepository;
use App\Modules\Transaction\Domain\Interface\Repository\IQrCodeRepository;

final class QrCodeRepository extends CoreRepository implements IQrCodeRepository
{
    protected function getModelClass()
    {
        return QrCode::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

}

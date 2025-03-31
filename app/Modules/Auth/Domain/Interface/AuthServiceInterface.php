<?php

namespace App\Modules\Auth\Domain\Interface;

use App\Modules\Auth\App\Data\DTO\Base\BaseDTO;

interface AuthServiceInterface
{
    public function getUserAuth();
    public function attemptUserAuth(BaseDTO $data);
    public function logout();
    public function refresh();

}

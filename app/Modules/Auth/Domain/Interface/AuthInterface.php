<?php
namespace App\Modules\Auth\Domain\Interface;

use App\Modules\Auth\App\Data\DTO\Base\BaseDTO;

interface AuthInterface
{
    public function attemptUser(BaseDTO $data);
    public function user();
    public function logout();
    public function refresh();

}

<?php
namespace App\Modules\Auth\Domain\Interface;

use App\Modules\Auth\App\Data\DTO\Base\BaseDTO;
use Illuminate\Database\Eloquent\Model;

interface AuthInterface
{
    public function attemptUser(BaseDTO $data);
    public function user();
    public function logout();
    public function refresh();
    public function login(Model $model);

}

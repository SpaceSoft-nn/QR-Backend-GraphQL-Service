<?php

namespace App\Modules\User\Domain\Interactor\User;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\User\App\Data\DTO\User\ResetPasswordDTO;
use App\Modules\User\Domain\Actions\User\UpdateUserAction;


class ResetPasswordInteractor extends BaseInteractor
{

    public function __construct(

    ) { }


    /**
     * @param ResetPasswordDTO $dto
     *
     * @return User
     */
    public function execute(BaseDTO $dto) : User
    {
        return $this->run($dto);
    }


    /**
     * @param ResetPasswordDTO $dto
     *
     * @return User
     */
    protected function run(BaseDTO $dto) : User
    {
        /** @var User */
        $user = $dto->sendEmail->user;

        /** @var UserVO */
        $vo = UserVO::toValueObject($user)->setPassword($dto->password);

        $user = $this->updateUserAction($user, $vo);

        return $user;
    }

    private function updateUserAction(User $model, UserVO $vo) : User
    {
        return UpdateUserAction::make($model, $vo);
    }



}

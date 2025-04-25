<?php

namespace App\Modules\User\Domain\Interactor\User;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\User\App\Data\DTO\User\UpdateUserDTO;
use App\Modules\User\Domain\Actions\User\UpdateUserAction;
use App\Modules\User\Domain\Interactor\NotificationInteractor;

class UpdateUserInteractor extends BaseInteractor
{

    public function __construct(
        private NotificationInteractor $notificationInteractor,
    ) { }


    /**
     *
     * @param UpdateUserDTO $dto
     *
     * @return User
     */
    public function execute(BaseDTO $dto) : User
    {
        //проверки
        $this->checkPermission($dto);

        return $this->run($dto);
    }

    /**
     * @param UpdateUserDTO $dto
     *
     * @return User
     */
    protected function run(BaseDTO $dto) : User
    {
        /** @var User */
        $user = DB::transaction(function ($pdo) use ($dto) {

            /**
             * User - над которым будем совершаться действие
             * @var User
             */
            $user = $dto->user;

            $userVO = UserVO::toValueObject($user)->setRole($dto->role);

            //Обновляем User
            /** @var User */
            $userBeforeUpdate = $this->updateUser($user, $userVO);

            return $userBeforeUpdate;
        });

        return $user;
    }

    // private function findUser(string $user_id) : User
    // {

    //     $model = User::find($user_id);

    //     if(!$model) {
    //         throw new GraphQLBusinessException("Данного user {$user_id} не существует.", 404);
    //     }

    //     return $model;
    // }

    private function updateUser(User $user, UserVO $userVO) : User
    {
        return UpdateUserAction::make($user, $userVO);
    }

    private function checkPermission(UpdateUserDTO $dto)
    {
        $this->hasUserByUserOwner($dto->userOwner, $dto->user);
        $this->userAdminOrManager($dto->userOwner);
    }

    /**
     * Проверяем относится ли передаваемый user, к авторизированному user
    */
    private function hasUserByUserOwner(User $userOwner, User $user)
    {

       Gate::forUser($userOwner)->authorize('hasUserByUserOwner', $user);

    }

     /**
     * Проверяем относится ли передаваемый user, к авторизированному user
    */
    private function userAdminOrManager(User $userOwner)
    {
        Gate::authorize('UserAdminOrManager', $userOwner);
    }

}

<?php

namespace App\Modules\Workspace\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\Workspace\Domain\Models\Workspace;
use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Workspace\App\Data\DTO\CreateWorkspaceDTO;
use App\Modules\Workspace\App\Data\ValueObject\WorkspaceVO;
use App\Modules\Subscription\Domain\Models\SubscriptionPlan;
use App\Modules\Pivot\Domain\Actions\UserWorkspace\LinkUserToWorkspace;
use App\Modules\Subscription\Domain\Services\SubscriptionService;
use App\Modules\Workspace\Domain\Actions\Workspace\CreateWorkspaceAction;

class CreateWorkspaceInteractor extends BaseInteractor
{

    public function __construct(
        private SubscriptionService $subscriptionService,
        private PersonalArea $personalArea,
        private ?SubscriptionPlan $sub = null,
    ) { }


    /**
     * @param CreateWorkspaceDTO $dto
     *
     * @return Workspace
     */
    public function execute(BaseDTO $dto) : Workspace
    {
        $this->personalArea = PersonalArea::find($dto->workspaceVO->personal_area_id);

        $this->subscriptionCheck($dto->user);
        $this->filterCheck($dto->user);

        return $this->run($dto);
    }

    /**
     * @param CreateWorkspaceDTO $dto
     *
     * @return Workspace
     */
    protected function run(BaseDTO $dto) : Workspace
    {

        /** @var Workspace */
        $workspace = DB::transaction(function ($pdo) use ($dto) {

            /** @var User */
            $user = $dto->user;

            /** @var Workspace */
            $workspace = $this->createWorkspace($dto->workspaceVO);

            //привязываем user к workspace через промежуточную таблицу
            $status = LinkUserToWorkspace::run($user, $workspace, true);

            DB::afterCommit(function () use ($workspace) {

                #TODO Выносить в очереди
                //декрементируем максимальное количество созданных АРМ у subscription
                $status = $this->subscriptionService->decrementWorkspaceCount($this->sub);

            });

            // return $workspace;
            return $workspace;

        });

        return $workspace;
    }

    private function createWorkspace(WorkspaceVO $vo) : Workspace
    {
        return CreateWorkspaceAction::make($vo);
    }

    private function filterCheck(User $user) : bool
    {
        if(UserRoleEnum::isManager($user->role) || UserRoleEnum::isAdmin($user->role)) {
            return true;
        }

        throw new GraphQLBusinessException('У вас недостаточно прав, для выполнения этого действия' , 403);
    }

    /**
     * Проверяем можно ли ещё создавать workspace в зависимости от подписки
     * @param User $user
     *
     * @return bool
     */
    private function subscriptionCheck(User $user)
    {
        /** @var SubscriptionPlan */
        $this->sub = $this->personalArea->subscription;

        if($this->sub->count_workspace <= 0) {
            throw new GraphQLBusinessException("У вашего аккаунта при подписке: {$this->sub->plan_name} - закончились лимиты на создание АРМ");
        }

    }

}

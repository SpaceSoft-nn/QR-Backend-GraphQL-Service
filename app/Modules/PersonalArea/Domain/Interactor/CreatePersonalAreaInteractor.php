<?php

namespace App\Modules\PersonalArea\Domain\Interactor;

use App\Modules\Base\DTO\BaseDTO;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Interactor\BaseInteractor;
use App\Modules\PersonalArea\App\Data\DTO\CreatePersonalAreaDTO;
use App\Modules\User\App\Data\DTO\User\CreateUserDTO;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\PersonalArea\App\Data\ValueObject\PersonalAreaVO;
use App\Modules\PersonalArea\Domain\Actions\PersonalArea\CreatePersonalAreaAction;



class CreatePersonalAreaInteractor extends BaseInteractor
{

    public function __construct(

    ) { }


    /**
     * @param CreatePersonalAreaDTO $dto
     *
     * @return PersonalArea
     */
    public function make(BaseDTO $dto) : PersonalArea
    {
        return $this->run($dto);
    }


    /**
     * @param CreatePersonalAreaDTO $dto
     *
     * @return PersonalArea
     */
    protected function run(BaseDTO $dto) : PersonalArea
    {
        /** @var PersonalArea */
        $model = DB::transaction(function (CreatePersonalAreaDTO $dto) {




        });

        return $model;
    }

    private function createPersonalArea(PersonalAreaVO $personalAreaVO) : PersonalArea
    {
        return CreatePersonalAreaAction::make($personalAreaVO);
    }

    private function createBalance(PersonalAreaVO $personalAreaVO) : PersonalArea
    {
        return CreatePersonalAreaAction::make($personalAreaVO);
    }

    private function createSubscription(PersonalAreaVO $personalAreaVO) : PersonalArea
    {
        return CreatePersonalAreaAction::make($personalAreaVO);
    }
}

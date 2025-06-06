<?php

namespace App\Modules\PersonalArea\Domain\Services;

use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\PersonalArea\App\Data\DTO\CreatePersonalAreaDTO;
use App\Modules\PersonalArea\Domain\Interface\Service\IPersonalAreaService;
use App\Modules\PersonalArea\Domain\Interactor\CreatePersonalAreaInteractor;

final class PersonalAreaService implements IPersonalAreaService
{
    public function __construct(
        private CreatePersonalAreaInteractor $createPersonalAreaInteractor
    ) { }


    public function createPersonalArea(CreatePersonalAreaDTO $dto) : PersonalArea
    {
        return $this->createPersonalAreaInteractor->execute($dto);
    }

}

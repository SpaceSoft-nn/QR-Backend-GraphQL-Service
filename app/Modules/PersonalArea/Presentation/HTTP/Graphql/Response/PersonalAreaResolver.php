<?php

namespace App\Modules\PersonalArea\Presentation\HTTP\Graphql\Response;

use App\Modules\Base\Money\Money;
use App\Modules\PersonalArea\App\Data\DTO\SetBalanceDTO;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\PersonalArea\Domain\Services\BalanceService;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class PersonalAreaResolver
{

    public function __construct(
        private BalanceService $balanceService,
    ) { }


    public function setBalance(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : bool
    {

        $status = $this->balanceService->setBalance(SetBalanceDTO::make(
            money: new Money($args['amount']),
            personalArea: PersonalArea::find($args['personal_area_id']),
        ));

        return $status;
    }

}


<?php

namespace App\Modules\Organization\Presentation\HTTP\Graphql\Response;

use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\Organization\Domain\Validators\OrganizationValidator;


class OrganizationResolver
{

    public function __construct(
        private OrganizationValidator $organizationValidator,
    ) {}

    public function store(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : array
    {
        //Валидируем
        $date = $this->organizationValidator->validate($args);

        dd($date);

        return [];
    }

}


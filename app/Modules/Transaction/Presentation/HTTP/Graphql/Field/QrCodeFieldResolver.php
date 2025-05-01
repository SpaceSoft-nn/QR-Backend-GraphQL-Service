<?php

namespace App\Modules\Transaction\Presentation\HTTP\Graphql\Field;

use Nuwave\Lighthouse\Execution\ResolveInfo;
use App\Modules\Transaction\Domain\Models\QrCode;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class QrCodeFieldResolver
{

    public function content_image_base64(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) : string
    {
        /** @var QrCode */
        $qrCode = $root;

        /** @var string */
        $content_image_base64 = $qrCode->content_image_base64;

        return $content_image_base64;
    }

}

<?php declare(strict_types=1);

namespace App\GraphQL\Scalars;

use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType;
use Illuminate\Support\Carbon;

final class CustomRuDateTimeScalarType extends ScalarType
{


    public function serialize(mixed $value): mixed
    {
        return $value;
    }

    /** Parses an externally provided value (query variable) to use as an input. */
    public function parseValue(mixed $value): mixed
    {
        return Carbon::createFromFormat('d-m-Y H:i:s', $value);
    }


    public function parseLiteral(Node $valueNode, ?array $variables = null): mixed
    {
        return $this->parseValue($valueNode->value);
    }
}

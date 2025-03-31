<?php

namespace App\Modules\Auth\Domain\Exceptions\Error;

use GraphQL\Error\ClientAware;
use GraphQL\Error\ProvidesExtensions;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

final class LighthouseTokenExpiredException extends TokenExpiredException implements ClientAware, ProvidesExtensions
{

    protected $reason;

    public function __construct(string $message, string $reason)
    {
        parent::__construct($message);

        $this->reason = $reason;
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     */
    public function isClientSafe(): bool
    {
        return true;
    }


    public function getExtensions(): array
    {
        return [
            'some' => 'Требуется повторный вход в систему.',
            'error_code' => $this->reason,
        ];
    }
}

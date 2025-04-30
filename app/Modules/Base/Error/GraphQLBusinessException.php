<?php

namespace App\Modules\Base\Error;

use Exception;
use GraphQL\Error\ClientAware;
use GraphQL\Error\ProvidesExtensions;

class GraphQLBusinessException extends Exception implements ClientAware, ProvidesExtensions
{
    /**
     * @var string[]|string
     */
    protected $messageCustom;

    /**
     * @var int
     */
    protected ?int $codeCustom;

    /**
     * @var array
     */
    protected array $extensions = [];

    public function __construct(string|array $messageCustom, $codeCustom = 400, array $extensions = [])
    {
        $this->messageCustom = $messageCustom;
        $this->codeCustom = $codeCustom;
        $this->extensions = $extensions;

        parent::__construct(
            is_array($messageCustom) ? json_encode($messageCustom) : $messageCustom,
            $codeCustom
        );
    }

    /**
     * @return string|string[]
     */
    public function getCustomMessage(): string|array
    {
        return $this->messageCustom;
    }

    /**
     * @return int
     */
    public function getCustomCode(): int
    {
        return $this->codeCustom;
    }

    /**
     * Returns true when exception message is safe to be displayed to the client.
     *
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * Returns string describing a category of the error.
     *
     * @return string
     */
    public function getCategory(): string
    {
        return 'business logic or manual call';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function getExtensions(): array
    {
        return array_merge([
            'code' => $this->codeCustom,
            'details' => $this->messageCustom,
            'success' => false,
        ], $this->extensions);
    }
}

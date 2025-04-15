<?php

namespace App\Modules\Workspace\App\Data\ValueObject;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;
use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Pivot\Domain\Models\UserOrganization;
use App\Modules\User\Domain\Models\User;

readonly class WorkspaceVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public int $user_organization_id,
        public string $name,
        public ?bool $is_active,
        public ?string $payment_id,
        public ?string $description,


    ) {}

    public static function make(

        int $user_organization_id,
        string $name,
        ?bool $is_active = false,   
        ?string $payment_id = null,
        ?string $description = null,


    ) : self {

        return new self(
            user_organization_id: $user_organization_id,
            name: $name,
            description: $description,
            is_active: $is_active,
            payment_id: $payment_id,
        );

    }

    public function toArray() : array
    {
        return [
            "user_organization_id" => $this->user_organization_id,
            "name"  => $this->name,
            "description"  => $this->description,
            "is_active"  => $this->is_active,
            "payment_id"  => $this->payment_id,
        ];
    }

    public static function fromArrayToObject(array $data, User $user) : self
    {

        $organization_id = Arr::get($data, 'organization_id');

        $user_organization_id = UserOrganization::query()->where('organization_id', $organization_id)->where('user_id', $user->id)->first()->id;

        $name = Arr::get($data, 'name');
        $description = Arr::get($data, 'description', null);
        $is_active = Arr::get($data, 'is_active', false);
        $payment_id = Arr::get($data, 'payment_id', null);


        return new self(
            user_organization_id: $user_organization_id,
            name: $name,
            description: $description,
            is_active: $is_active,
            payment_id: $payment_id,
        );
    }

}

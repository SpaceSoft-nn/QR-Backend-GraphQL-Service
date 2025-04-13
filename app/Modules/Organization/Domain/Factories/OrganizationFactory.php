<?php

namespace App\Modules\Organization\Domain\Factories;

use App\Modules\Organization\App\Data\Enums\OrganizationTypeEnum;
use App\Modules\Organization\App\Data\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {

        /** @var User */
        $user = User::factory()->create();

        $personalAreaVO = OrganizationVO::make(
            owner_id : $user->id,
            name : $this->faker->name(),
            address : $this->faker->address() ,
            website : $this->faker->url() ,
            description : $this->faker->sentence() ,
            okved : $this->faker->word() ,
            founded_date : $this->faker->date() ,
            phone : $this->faker->phoneNumber() ,
            email : $this->faker->safeEmail() ,
            remuved : null ,
            type : OrganizationTypeEnum ::legal,
            inn : $this->faker->unique()->numerify('##########'),
            kpp : $this->faker->unique()->numerify('#########') ,
            registration_number : $this->faker->unique()->numerify('############') ,
        );

        return $personalAreaVO->toArrayNotNull();
        
    }

}




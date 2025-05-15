<?php

namespace App\Modules\Workspace\Domain\Factories;

use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\App\Data\ValueObject\UserVO;
use App\Modules\Workspace\App\Data\ValueObject\WorkspaceVO;
use App\Modules\Workspace\Domain\Models\Workspace;
use Illuminate\Database\Eloquent\Factories\Factory;

    class WorkspaceFactory extends Factory
    {
        protected $model = Workspace::class;

        public function definition(): array
        {
            #для работы со state работать через VO не получится
            // $model = WorkspaceVO::make(
            //     user_organization_id: ,
            //     name:  $this->faker->company,
            //     is_active: $this->faker->boolean,
            //     payment_id: null,
            //     description: $this->faker->text(100),
            // );

            return [
                'user_organization_id' => null,
                'personal_area_id' => null,
                'name'                 => $this->faker->company,
                'is_active'            => $this->faker->boolean,
                'payment_method_id'           => null,
                'description'          => $this->faker->text(100),
            ];
        }

        public function withUserOrganization($user): static
        {
            return $this->state(function (array $attributes) use ($user) {
                return [
                    'user_organization_id' => $user->organizations()->first()->pivot->id,
                ];
            });

        }

         public function withPersonalArea(PersonalArea $personalArea): static
        {
            return $this->state(function (array $attributes) use ($personalArea) {
                return [
                    'personal_area_id' => $personalArea->id,
                ];
            });

        }

    }

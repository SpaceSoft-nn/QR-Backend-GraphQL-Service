<?php

namespace App\Modules\Notification\Domain\Factories;

use App\Modules\Notification\Domain\Models\PhoneList;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneFactory extends Factory
{
    protected $model = PhoneList::class;

    public function definition(): array
    {
        $mobilePhone = '79' . $this->faker->numerify('#########');

        return [
            'value' => $mobilePhone,
            'status' => true,
        ];
    }

}

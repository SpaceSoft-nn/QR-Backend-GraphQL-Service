<?php

namespace App\Modules\Notification\Domain\Factories;

use App\Modules\Notification\Domain\Models\EmailList;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    protected $model = EmailList::class;

    public function definition(): array
    {

        return [
            'value' => $this->faker->email(),
            'status' => true,
        ];
    }

}

<?php

namespace Tests\Unit;

use App\Modules\Base\Money\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{

    public function test_money_kopeck(): void
    {
        for ($i=0; $i < 100; $i++) {
            $randFloat = mt_rand(1000, 1000000);
            $moneyTest = new Money( (string) $randFloat);

            //проверяем что сумма правильно переводится в копейки
            $this->assertEquals($moneyTest->value * 100, floatval($moneyTest->value_kopeck));
        }
    }
}

<?php
namespace App\Modules\Base\Money;

use Stringable;
use InvalidArgumentException;
use App\Modules\Base\Casts\MoneyCast;
use Illuminate\Contracts\Database\Eloquent\Castable;

#TODO написать unit тесты и проверить копейки
class Money implements Stringable, Castable {

    public readonly string $value;

    /**
     * Значение в копейках
     * @var string
     *
    */
    public readonly string $value_kopeck;

    public function __construct(Money|string|int|float $value)
    {

        if($value instanceof self){
            $value = $value->value;
        }

        if(!is_numeric($value)){
            throw new InvalidArgumentException(

                "Значение [{$value}] должно быть числом",

            );
        }

        $this->value = (string) $value;

        //переводим в копейки
        $this->value_kopeck = $this->toKopecks($this->value);
    }

    /**
     * Складывает два числа.
     * @param Money|string|int|float $number
     * @param int|null $scale
     *
     * @return static
     */
    public function add(Money|string|int|float $number = 0, ?int $scale = null): static
    {
        $number = new static($number);

        return new static(bcadd($this->value, $number->value, $scale));
    }

    /**
     * Вычитает одно число из другого.
     * @param Money|string|int|float $number
     * @param int|null $scale
     *
     * @return static
     */
    public function sub(Money|string|int|float $number = 0, ?int $scale = null): static
    {
        $number = new static($number);

        return new static(bcsub($this->value, $number->value, $scale));
    }

    /**
     * Умножает два числа.
     * @param Money|string|int|float $number
     * @param int|null $scale
     *
     * @return static
     */
    public function mul(Money|string|int|float $number = 0, ?int $scale = null): static
    {
        $number = new static($number);

        return new static(bcmul($this->value, $number->value, $scale));
    }

    /**
     * Делит одно число на другое.
     * @param Money|string|int|float $number
     * @param int|null $scale
     *
     * @return static
     */
    public function div(Money|string|int|float $number = 0, ?int $scale = null): static
    {
        $number = new static($number);

        return new static(bcdiv($this->value, $number->value, $scale));
    }

    /**
     * Сравнивает два числа с указанной точностью.
     * @param Money|string|int|float $number
     * @param int|null $scale
     *
     * @return bool
     */
    public function eq(Money|string|int|float $number = 0, ?int $scale = null): bool
    {
        $number = new static($number);

        $result = bccomp($this->value, $number->value, $scale);

        return ($result === 0);
    }


    //больше ли
    public function gt(Money|string|int|float $number = 0, ?int $scale = null): bool
    {
        $number = new static($number);

        $result = bccomp($this->value, $number->value, $scale);

        return ($result === 1);
    }

    //больше или равно
    public function gte(Money|string|int|float $number = 0, ?int $scale = null): bool
    {
        return $this->eq($number, $scale) || $this->gt($number, $scale);
    }

    public function lt(Money|string|int|float $number = 0, ?int $scale = null): bool
    {
        $number = new static($number);

        $result = bccomp($this->value, $number->value, $scale);

        return ($result === -1);
    }

    //больше или равно
    public function lte(Money|string|int|float $number = 0, ?int $scale = null): bool
    {
        return $this->eq($number, $scale) || $this->lt($number, $scale);
    }

    /**
     * Переводим в копейки
     * @param Money|string|int|float $number
     *
     * @return string
     */
    private function toKopecks() : string
    {
        $kopecks = floor(floatval($this->value) * 100);

        return strval($kopecks);
    }


    public function __toString() : string
    {
        return $this->value;
    }

    public static function castUsing(array $arguments): string
    {
        return MoneyCast::class;
    }

}

<?php
namespace App\Modules\Notification\Domain\Actions\List;

use App\Modules\Base\Error\GraphQLBusinessException;
use Exception;
use function App\Helpers\Mylog;

use App\Modules\Notification\Domain\Models\EmailList;

class CreateEmailListAction
{

    public static function make(string $email, ?bool $status = null) : ?EmailList
    {
       return (new self())->run($email, $status);
    }

    public function run(string $email, ?bool $status = null) : ?EmailList
    {

        try {


            // $model = EmailList::query()
            //     ->create([
            //         'value' => $email,
            //         'status' => $status ?? false
            //     ]);

            // $model = EmailList::query()
            //     ->firstOrCreate(
            //         [
            //             'value' => $email,
            //         ],
            //         [$status && 'status' => $status]
            //     );

            //вместо создание мы теперь возвращаем значение
            $model = EmailList::query()->where('value', $email)->first();

            if(is_null($model))
            {
                throw new GraphQLBusinessException("Такого значение email: {$email} не существует в системе.", 404);
            }

        } catch (GraphQLBusinessException $th) {

            throw new GraphQLBusinessException("Такого значение email: {$email} не существует в системе.", 404);

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        // catch (UniqueConstraintViolationException $exc) {

        //     // throw new GraphQLBusinessException('Такой email уже зарегистрирован.', 422);

        // }


        #TODO - было firstOrCreate - получалось так, что регистрация или создание user могла проходить даже если уже существует такой email
        // $model = EmailList::query()
        //     ->firstOrCreate(
        //         [
        //             'value' => $email,
        //         ],
        //         [$status && 'status' => $status]
        //     );

        return $model;
    }

}

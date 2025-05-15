<?php
namespace App\Modules\Notification\Domain\Actions\List;

use App\Modules\Base\Error\GraphQLBusinessException;
use App\Modules\Notification\Domain\Models\EmailList;
use Exception;
use Illuminate\Database\UniqueConstraintViolationException;

use function App\Helpers\Mylog;

class CreateEmailListAction
{

    public static function make(string $email, ?bool $status = null) : EmailList
    {
       return (new self())->run($email, $status);
    }

    public function run(string $email, ?bool $status = null) : EmailList
    {

        try {


            // $model = EmailList::query()
            //     ->create([
            //         'value' => $email,
            //         'status' => $status ?? false
            //     ]);

            $model = EmailList::query()
                ->firstOrCreate(
                    [
                        'value' => $email,
                    ],
                    [$status && 'status' => $status]
                );

        } catch (UniqueConstraintViolationException $exc) {

            throw new GraphQLBusinessException('Такой email уже зарегистрирован.', 422);

        } catch (\Throwable $th) {
            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }


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

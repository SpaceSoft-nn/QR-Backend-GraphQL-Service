<?php
namespace App\Modules\Base\Interface\Repositories;



use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepositories
 * Ядро для других репозиториев
 *
 * @package App\Modules\LetterSms\Repositories\Base
 *
 * Репозиторий для работы с сущностью.
 * Может выдавать наборы данных.
 * Не может создавать/изменять сущность -> only выборка данных. (С этим можно попросить в рядах Laravel - это так, но есть смысл добавлять сюда и создание/удаление/обновление сущности (в том случае если мы не будем менять ORM) )
 * P.S Если пересмотреть паттерн репозиторий, то лучше иметь работу с бд ORM/SQL и CRUD операциями тут.
 *
 */
abstract class CoreRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepositories constructor.
     */
    public function __construct()
    {
        $modelClass = $this->getModelClass();
        $this->model = new $modelClass();
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return Model|mixed
     */
    protected function startConditions() : Model
    {
        //репозиторий не должен хранить состояние поэтому clone
        return clone $this->model;
    }

}

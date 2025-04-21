<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GoCommand extends Command
{

    protected $signature = 'go';

    protected $description = 'Тестовый запуск';


    public function handle()
    {

        $arrayS = [
            'a' => 2,
            'b' => 1,
        ];


        $status = false;
        $i = 0;
        $j = 0;

        // while( $i < count($arrayS) - 1 )
        // {

        //     if($arrayS[$i] == $arrayS[$j + 1])
        //     {
        //         $status = true;
        //     } else {
        //         return false;
        //     }

        //     $i++;
        //     $j++;

        // }

        dd($arrayS[1]);
    }

    //функция выборочной сортировки массива
    private function selectionSort(array $array) : array
    {
        $lens = sizeof($array);
        $newArr = [];

        for ($i=0; $i < $lens; $i++) {
            $smallest = $this->serachMinElement($array);

            $removed = array_splice($array, $smallest, 1);

            $newArr = array_merge($newArr, $removed);
        }

        return $newArr;
    }

    //Ищем наименьший - возвращает индекс
    private function serachMinElement(array $arr) : int
    {
        $smallest = $arr[0]; //Для хранения наименьшего значения
        $smallest_index = 0; //Для хранения индекса наименьшего значения

        for ($i = 0; $i < sizeof($arr); $i ++) {

            if ($arr[$i] < $smallest)
            {
                $smallest = $arr[$i];
                $smallest_index = $i;
            }

        }

        return $smallest_index;
    }

    private function search_binar(array $arr, mixed $find)
    {

        $start = 0;
        $end = sizeof($arr);

        while ($start < $end) {

            $middle = (int) abs( ($start + $end) / 2 );

            if($arr[$middle] == $find) {
                return $middle;
            } else if($arr[$middle] > $find) {
                $end = $middle - 1;
            } else {
                $start = $middle + 1;
            }
        }

        return -1;

    }
}

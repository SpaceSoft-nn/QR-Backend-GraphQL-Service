<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GoCommand extends Command
{

    protected $signature = 'go';

    protected $description = 'Тестовый запуск';


    // public function handle()
    // {
    //     $x = [8,5,3,9,4,2];

    //     dd($this->sortSearch($x));
    // }

    // private function findSmall(array $arr) : int
    // {
    //     $arrLen = count($arr) - 1;
    //     $small = $arr[0];
    //     $smallIndex = 0;

    //     for ($i = 0; $i <= $arrLen; $i++) {

    //         if($small > $arr[$i])
    //         {
    //             $small = $arr[$i];
    //             $smallIndex = $i;
    //         }

    //     }

    //     return $smallIndex;
    // }

    // private function sortSearch(array $arr)
    // {

    //     $newArray = [];

    //     $arrLen = count($arr);
    //     $i = 0;

    //     while($i < $arrLen)
    //     {
    //         $index = $this->findSmall($arr);
    //         $arrayDelete = array_splice($arr, $index , 1);
    //         $newArray[] = $arrayDelete;
    //         $arrLen--;
    //     }

    //     return $newArray;
    // }


    // private function binarSearch(int $x)
    // {
    //     $right = $x;
    //     $left = 0;

    //     while ($left <= $right) {

    //         $middle = (int) abs( ($left + $right) / 2 );

    //         $middleSqr = $middle * $middle;

    //         if($middleSqr < $x){

    //             $left = $middle + 1;

    //         } else if($middleSqr > $x) {

    //             $right = $middle - 1;

    //         } else {

    //             return $middle;

    //         }

    //     }

    //     return $right;
    // }

}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\PersonalArea\Domain\Models\PersonalArea;
use App\Modules\Subscription\Domain\Models\TariffPackage;
use App\Modules\Subscription\Domain\Models\TariffWorkspace;

class GoCommand extends Command
{

    protected $signature = 'go';

    protected $description = 'Тестовый запуск';


    public function handle()
    {


    }

    private function missingNumber(array $nums) {

        $missing = count($nums);

        for ($i = 0; $i < count($nums); $i++) {

            $a = $i ^ $nums[$i];
            $missing = $missing ^ $a;
        }
        return $missing;

    }

    private function findMax(array $arr, int $i = 0)
    {
        if(empty($arr)) { return null; }

        if($i === count($arr) - 1) { return $arr[$i]; }

        $nextMax = $this->findMax($arr, $i + 1);

        return ($arr[$i] > $nextMax) ? $arr[$i] : $nextMax;
    }

    private function binarySearch($arr, $target)
    {
        $right = count($arr) - 1;
        $left = 0;
        $arrNew = [];

        while($left <= $right)
        {
            $middle = (int) abs( ($left + $right) / 2 );

            if ($arr[$middle] < $target) {

                $left = $middle + 1;

            } else if($arr[$middle] > $target) {

                $right = $middle - 1;

            } else {

                $arrNew[] = $middle;

                $flag = true;
                $i = 1;

                while($flag)
                {
                    if( $arr[$middle - $i] == $target )
                    {
                        $arrNew[] = $middle - $i;
                    }

                    if($arr[$middle + $i] == $target)
                    {
                        $arrNew[] = $middle + $i;
                    }

                    if( ($arr[$middle + $i] != $target) && ($arr[$middle - $i] != $target) )
                    {
                        $flag = false;
                    }

                    $i++;

                }

                $arrNew = array_reverse($arrNew);

                return $arrNew;
            }
        }

        return $arrNew;
    }

    private function findSmall(array $arr) : int
    {
        $arrLen = count($arr) - 1;
        $small = $arr[0];
        $smallIndex = 0;

        for ($i = 0; $i <= $arrLen; $i++) {

            if($small > $arr[$i])
            {
                $small = $arr[$i];
                $smallIndex = $i;
            }

        }

        return $smallIndex;
    }

    private function sortSearch(array $arr)
    {

        $newArray = [];

        $arrLen = count($arr);
        $i = 0;

        while($i < $arrLen)
        {
            $index = $this->findSmall($arr);
            $arrayDelete = array_splice($arr, $index , 1);
            $newArray[] = $arrayDelete[0];
            $arrLen--;
        }

        return $newArray;
    }

    // private function mergeArray($x)
    // {
    //     $generalLen = count($x);
    //     $arrayNew = [];


    //     for($i = 0; $i < $generalLen; $i++) {

    //         $arrayNew = array_merge($arrayNew, $x[$i]);

    //     }

    //     return $arrayNew;
    // }

    // private function binarySearch(array $arr, int $target)
    // {
    //     $right = count($arr) - 1;
    //     $left = 0;
    //     $ars = [];


    //     while($left <= $right)
    //     {
    //         $middle = (int) abs( ($left + $right) / 2 );

    //         if($arr[$middle] == $target)
    //         {
    //             return true;
    //         } else if ($arr[$middle] > $target) {
    //             $right = $middle - 1;
    //         } else if ($arr[$middle] < $target) {
    //             $left = $left  + 1;
    //         }

    //     }

    //     return false;
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
    //         $newArray[] = $arrayDelete[0];
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

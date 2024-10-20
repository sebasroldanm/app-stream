<?php

namespace App\Traits;

trait OwnerProp
{
    public function iconGender($gender) {
        switch ($gender) {
            case 'female':
                return '<i class="las la-venus"></i>';
                break;
            case 'females':
                return '<i class="las la-venus-double"></i>';
                break;
            case 'femaleTranny':
                return '<i class="las la-mercury"></i>';
                break;
            case 'male':
                return '<i class="las la-mars"></i>';
                break;
            case 'males':
                return '<i class="las la-mars-double"></i>';
                break;
            case 'maleTranny':
                return '<i class="las la-mars-stroke-h"></i>';
                break;
            case 'tranny':
                return '<i class="las la-transgender"></i>';
                break;
            case 'trannies':
                return '<i class="las la-transgender-alt"></i>';
                break;
            default:
                return '<i class="las la-genderless"></i>';
                break;
        }
    }

    public function flagCountry($country) {
        if ($country == '') {
            return false;
        }
        return strtoupper($country);
    }

    public function stringLaguages($languages) {
        if (count($languages) == 0) {
            return false;
        }
        $string = '';
        foreach ($languages as $lang) {
            $string .= $lang . ', ';
        }
        return substr($string, 0, -2) . ".";
    }
}

<?php

namespace App\Traits;

use Carbon\Carbon;

trait OwnerProp
{
    public function iconGender($gender)
    {
        switch ($gender) {
            case 'female':
                return '<i class="las la-venus" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mujer"></i>';
                break;
            case 'females':
                return '<i class="las la-venus-double" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mujeres"></i>';
                break;
            case 'femaleTranny':
                return '<i class="las la-mercury" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mujer Trans"></i>';
                break;
            case 'male':
                return '<i class="las la-mars" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hombre"></i>';
                break;
            case 'males':
                return '<i class="las la-mars-double" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hombres"></i>';
                break;
            case 'maleTranny':
                return '<i class="las la-mars-stroke-h" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hombre Trans"></i>';
                break;
            case 'tranny':
                return '<i class="las la-transgender" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Trans"></i>';
                break;
            case 'trannies':
                return '<i class="las la-transgender-alt" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Trans Bi"></i>';
                break;
            default:
                return '<i class="las la-genderless" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Sin genero"></i>';
                break;
        }
    }

    public function flagCountry($country)
    {
        if ($country == '') {
            return false;
        }
        return strtoupper($country);
    }

    public function stringLaguages($languages)
    {
        if (count($languages) == 0) {
            return false;
        }
        $string = '';
        foreach ($languages as $lang) {
            $string .= $lang . ', ';
        }
        return substr($string, 0, -2) . ".";
    }

    public function stringDurationTime($seconds)
    {
        $time = Carbon::createFromTimestamp(0)->addSeconds($seconds);

        $hours = $time->format('H');
        $minutes = $time->format('i');
        $remainingSeconds = $time->format('s');

        $timeString = '';
        if ($hours > 0) {
            $timeString .= $hours . ' ' . ($hours === 1 ? 'hora' : 'horas') . ', ';
        }
        if ($minutes > 0) {
            $timeString .= $minutes . ' ' . ($minutes === 1 ? 'minuto' : 'minutos') . ', ';
        }
        $timeString .= $remainingSeconds . ' ' . ($remainingSeconds === 1 ? 'segundo' : 'segundos');

        return trim($timeString, ', ');
    }

    public function returnFormatByUrl($url)
    {
        $urlWithoutQuery = strtok($url, '?');
        $extension = pathinfo($urlWithoutQuery, PATHINFO_EXTENSION);
        return $extension ? '.' . $extension : null;
    }
}

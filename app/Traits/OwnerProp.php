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
        if (empty($country)) {
            return false;
        }
        $country = strtolower($country);

        $html = '<span class="fi fi-' . $country . ' ms-1 rounded-1"></span>';

        return $html;
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

    public function flagsLanguages($languages)
    {
        if (count($languages) == 0) {
            return false;
        }
        $html = '';
        foreach ($languages as $lang) {
            switch ($lang) {
                case 'es':
                    $html .= '<span class="fi fi-es fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Español"></span>';
                    break;
                case 'en':
                    $html .= '<span class="fi fi-gb fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Ingles"></span>';
                    break;
                case 'pt':
                    $html .= '<span class="fi fi-pt fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Portugues"></span>';
                    break;
                case 'fr':
                    $html .= '<span class="fi fi-fr fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Frances"></span>';
                    break;
                case 'de':
                    $html .= '<span class="fi fi-de fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Aleman"></span>';
                    break;
                case 'it':
                    $html .= '<span class="fi fi-it fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Italiano"></span>';
                    break;
                case 'nl':
                    $html .= '<span class="fi fi-nl fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Holandes"></span>';
                    break;
                case 'ru':
                    $html .= '<span class="fi fi-ru fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Ruso"></span>';
                    break;
                case 'ja':
                    $html .= '<span class="fi fi-jp fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Japones"></span>';
                    break;
                case 'zh':
                    $html .= '<span class="fi fi-cn fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Chino"></span>';
                    break;
                case 'ko':
                    $html .= '<span class="fi fi-kr fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Coreano"></span>';
                    break;
                case 'ar':
                    $html .= '<span class="fi fi-ar fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Arabe"></span>';
                    break;
                case 'hi':
                    $html .= '<span class="fi fi-in fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hindi"></span>';
                    break;
                case 'vi':
                    $html .= '<span class="fi fi-vn fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Vietnamita"></span>';
                    break;
                case 'tr':
                    $html .= '<span class="fi fi-tr fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Turco"></span>';
                    break;
                default:
                    $html .= '<span class="fi fi-xx fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . $lang . '"></span>';
                    break;
            }
        }
        return $html;
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
        return $extension ? $extension : null;
    }

    public function continent($continent)
    {
        switch ($continent) {
            case 'af':
                return 'Africa';
                break;
            case 'an':
                return 'Antártida';
                break;
            case 'as':
                return 'Asia';
                break;
            case 'eu':
                return 'Europa';
                break;
            case 'na':
                return 'America del Norte';
                break;
            case 'oc':
                return 'Oceanía';
                break;
            case 'sa':
                return 'America del Sur';
                break;
            default:
                return '';
                break;
        }
    }
}

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
                case 'pl':
                    $html .= '<span class="fi fi-pl fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Polaco"></span>';
                    break;
                case 'cs':
                    $html .= '<span class="fi fi-cz fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Checo"></span>';
                    break;
                case 'br':
                    $html .= '<span class="fi fi-br fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Brasil"></span>';
                    break;
                default:
                    $html .= '<span class="fi fi-xx fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . $lang . '"></span>';
                    break;
            }
        }
        return $html;
    }

    public function eyeColor($color)
    {
        switch ($color) {
            case 'eyeColorBrown':
                return 'Café';
                break;
            case 'eyeColorBlue':
                return 'Azul';
                break;
            case 'eyeColorGreen':
                return 'Verde';
                break;
            case 'eyeColorHazel':
                return 'Avellana';
                break;
            case 'eyeColorGray':
                return 'Gris';
                break;
            case 'eyeColorBlack':
                return 'Negro';
                break;
            default:
                return $color;
                break;
        }
    }

    public function hairColor($color)
    {
        switch ($color) {
            case 'hairColorBlonde':
                return 'Amarillo';
                break;
            case 'hairColorBrown':
                return 'Castaño';
                break;
            case 'hairColorBlack':
                return 'Negro';
                break;
            case 'hairColorRed':
                return 'Rojo';
                break;
            case 'hairColorColorful':
                return 'Colorido';
                break;
            default:
                return $color;
                break;
        }
    }

    public function bodyType($type)
    {
        switch ($type) {
            case 'bodyTypePetite':
                return 'Pequeño';
                break;
            case 'bodyTypeAthletic':
                return 'Atlética';
                break;
            case 'bodyTypeMedium':
                return 'Media';
                break;
            case 'bodyTypeCurvy':
                return 'Curva';
                break;
            case 'bodyTypeBBW':
                return 'BBW';
                break;
            case 'bodyTypeBig':
                return 'Grande';
                break;
            default:
                return $type;
                break;
        }
    }

    public function ethnicity($ethnicity)
    {
        switch ($ethnicity) {
            case 'ethnicityMiddleEastern':
                return 'Medio Oriente';
                break;
            case 'ethnicityAsian':
                return ' Asiatico';
                break;
            case 'ethnicityEbony':
                return 'Ebano';
                break;
            case 'ethnicityIndian':
                return 'Indio';
                break;
            case 'ethnicityLatino':
                return 'Latino';
                break;
            case 'ethnicityMultiracial':
                return 'Multiracial';
                break;
            case 'ethnicityWhite':
                return 'Blanco';
                break;
            default:
                return $ethnicity;
                break;
        }
    }

    public function age($age)
    {
        switch ($age) {
            case 'ageTeen':
                return 'Adolescente';
                break;
            case 'ageYoung':
                return 'Joven';
                break;
            case 'ageMilf':
                return 'Milf';
                break;
            case 'ageMature':
                return 'Madrura';
                break;
            case 'ageOld':
                return 'Viejo';
                break;
            default:
                return $age;
                break;
        }
    }

    public function privatePrice($price)
    {
        switch ($price) {
            case 'privatePriceEight':
                return '8';
                break;
            case 'privatePriceSixteenToTwentyFour':
                return '16-24';
                break;
            case 'privatePriceThirtyTwoSixty':
                return '32-60';
                break;
            case 'privatePriceNinetyPlus':
                return '90+';
                break;
            case 'autoTagBestPrivates':
                return 'Mejores privados';
                break;
            case 'autoTagRecordablePrivate':
                return 'Privado grabable';
                break;
            case 'autoTagSpy':
                return 'Espía';
                break;
            case 'autoTagP2P':
                return 'P2P';
                break;
            default:
                return $price;
                break;
        }
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

<?php

namespace App\Traits;

use Carbon\Carbon;

trait OwnerProp
{
    public function ageTooltipBirthdate($age = 0, $birthdate = null)
    {
        if ($age == 0 || $birthdate == null) {
            return false;
        }
        return '<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . $birthdate->format('Y-m-d') . '">' . $age . '</span>';
    }

    // FIXME: Deprecado, se debe restablecer y usar Helper
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

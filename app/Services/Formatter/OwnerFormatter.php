<?php

namespace App\Services\Formatter;

class OwnerFormatter
{
    public function iconGender(?string $gender): string
    {
        switch ($gender) {
            case 'female':
                return '<i class="las la-venus" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mujer"></i>';
            case 'females':
                return '<i class="las la-venus-double" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mujeres"></i>';
            case 'femaleTranny':
                return '<i class="las la-mercury" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mujer Trans"></i>';
            case 'male':
                return '<i class="las la-mars" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hombre"></i>';
            case 'males':
                return '<i class="las la-mars-double" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hombres"></i>';
            case 'maleTranny':
                return '<i class="las la-mars-stroke-h" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hombre Trans"></i>';
            case 'tranny':
                return '<i class="las la-transgender" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Trans"></i>';
            case 'trannies':
                return '<i class="las la-transgender-alt" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Trans Bi"></i>';
            case 'maleFemale':
                return '<i class="las la-venus-mars" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hombre Mujer"></i>';
            default:
                return '<i class="las la-genderless" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Sin genero"></i>';
        }
    }
}

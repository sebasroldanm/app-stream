<?php
if (!function_exists('flag_country')) {
    function flag_country(?string $country): string
    {
        if (empty($country)) {
            return '';
        }

        $country = strtolower($country);
        return '<span class="fi fi-' . $country . ' ms-1 rounded-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . $country . '"></span>';
    }
}

if (!function_exists('flag_languages')) {
    function flag_languages(?array $languages): bool|string
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
                case 'hu':
                    $html .= '<span class="fi fi-hu fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hungaro"></span>';
                    break;
                case 'gu':
                    $html .= '<span class="fi fi-gu fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Gujarati"></span>';
                    break;
                case 'bn':
                    $html .= '<span class="fi fi-bn fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Bengali"></span>';
                    break;
                case 'fi':
                    $html .= '<span class="fi fi-fi fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Finlandes"></span>';
                    break;
                case 'ro':
                    $html .= '<span class="fi fi-ro fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Rumano"></span>';
                    break;
                default:
                    $html .= '<span class="fi fi-xx fis ms-1 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' . $lang . '"></span>';
                    break;
            }
        }
        return $html;
    }
}

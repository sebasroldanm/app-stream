<?php

namespace App\Helpers;

class NumberHelper
{
    /**
     * Formatea un número con separadores de miles y decimales.
     *
     * @param float|int|null $number
     * @param int $decimals
     * @param string $decimalSeparator
     * @param string $thousandsSeparator
     * @return string
     */
    public static function format(
        $number,
        int $decimals = 0,
        string $decimalSeparator = '.',
        string $thousandsSeparator = ','
    ): string {
        if ($number === null || $number === '') {
            return '0';
        }

        return number_format((float) $number, $decimals, $decimalSeparator, $thousandsSeparator);
    }

    /**
     * Formatea un número como moneda (ej. $1,234.56).
     *
     * @param float|int|null $number
     * @param string $currencySymbol
     * @param int $decimals
     * @return string
     */
    public static function currency($number, string $currencySymbol = '$', int $decimals = 2): string
    {
        return $currencySymbol . self::format($number, $decimals);
    }

    /**
     * Formatea un número como porcentaje (ej. 12.34%).
     *
     * @param float|int|null $number
     * @param int $decimals
     * @return string
     */
    public static function percentage($number, int $decimals = 2): string
    {
        return self::format($number, $decimals) . '%';
    }
}

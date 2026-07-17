<?php

namespace App\Presenters\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class DatePresenter
{
    protected ?Carbon $date;

    public function __construct(?Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * Formato por defecto
     */
    public function __toString(): string
    {
        return $this->dateTimeSeconds();
    }

    /**
     * dd/mm/YYYY
     */
    public function date(): string
    {
        return $this->format('d/m/Y');
    }

    /**
     * dd/mm/YYYY HH:mm
     */
    public function dateTime(): string
    {
        return $this->format('d/m/Y H:i');
    }

    /**
     * dd/mm/YYYY HH:mm:ss
     */
    public function dateTimeSeconds(): string
    {
        return $this->format('d/m/Y H:i:s');
    }

    /**
     * Formato personalizado
     */
    public function format(string $format): string
    {
        return $this->date?->format($format) ?? '';
    }

    /**
     * Carbon::calendar()
     */
    public function calendar(): string
    {
        return $this->date?->calendar() ?? '';
    }

    /**
     * Cambia al modo "humano"
     */
    public function human(): HumanDatePresenter
    {
        return new HumanDatePresenter($this->date);
    }
}
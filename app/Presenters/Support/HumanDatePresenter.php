<?php

namespace App\Presenters\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class HumanDatePresenter
{
    protected ?Carbon $date;

    protected int $parts = 1;

    protected bool $join = true;

    protected bool $short = false;

    protected bool $absolute = false;

    public function __construct(?Carbon $date)
    {
        $this->date = $date;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function parts(int $parts = 1): self
    {
        $this->parts = max(1, $parts);

        return $this;
    }

    public function short(): self
    {
        $this->short = true;

        return $this;
    }

    public function join(): self
    {
        $this->join = true;

        return $this;
    }

    public function noJoin(): self
    {
        $this->join = false;

        return $this;
    }

    public function diffAbsolute(): self
    {
        $this->absolute = true;

        return $this;
    }

    /**
     * Carbon::calendar()
     */
    public function calendar(): string
    {
        return $this->date?->calendar() ?? '';
    }

    protected function render(): string
    {
        if (! $this->date) {
            return '';
        }

        return $this->date->diffForHumans([
            'parts' => $this->parts,
            'join' => $this->join,
            'short' => $this->short,
            'syntax' => $this->absolute
                ? CarbonInterface::DIFF_ABSOLUTE
                : CarbonInterface::DIFF_RELATIVE_AUTO,
        ]);
    }
}
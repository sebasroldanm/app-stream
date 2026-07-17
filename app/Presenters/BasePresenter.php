<?php

namespace App\Presenters;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use App\Presenters\Support\DatePresenter;
use Coderflex\LaravelPresenter\Presenter;

abstract class BasePresenter extends Presenter
{
    protected function date(Carbon|CarbonInterface|string|null $date): DatePresenter
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        if ($date instanceof CarbonInterface && ! $date instanceof Carbon) {
            $date = Carbon::instance($date);
        }

        return new DatePresenter($date);
    }
}
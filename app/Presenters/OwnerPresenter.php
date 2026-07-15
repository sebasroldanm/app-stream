<?php

namespace App\Presenters;

use App\Services\Formatter\OwnerFormatter;
use Coderflex\LaravelPresenter\Presenter;
use Illuminate\Database\Eloquent\Model;

class OwnerPresenter extends Presenter
{
    // EXTRACT DATA

    protected function userNode(): ?object
    {
        return $this->model->data?->user?->user;
    }

    protected function camNode(): ?object
    {
        return $this->model->data?->cam;
    }

    protected function goalNode(): ?object
    {
        return $this->camNode()?->goal;
    }

    // EXTRACT RAW

    public function rawGender(): ?string
    {
        return $this->userNode()?->gender;
    }

    // FORMAT DATA

    public function iconGender(): string
    {
        return (new OwnerFormatter())->iconGender($this->rawGender());
    }
}

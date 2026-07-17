<?php

namespace App\Presenters;

use App\Helpers\NumberHelper;
use App\Presenters\Support\DatePresenter;
use App\Services\Formatter\OwnerFormatter;
use Carbon\Carbon;

class OwnerPresenter extends BasePresenter
{
    
    // EXTRACT DATA

    protected function userNode(): ?object
    {
        return $this->model->data?->user;
    }

    protected function userDataNode(): ?object
    {
        return $this->userNode()?->user;
    }

    protected function camNode(): ?object
    {
        return $this->model->data?->cam;
    }

    protected function goalNode(): ?object
    {
        return $this->camNode()?->goal;
    }

    protected function positionNode(): ?object
    {
        return $this->userNode()?->modelTopPosition;
    }

    // LOGIC
    public function hasValidData(): bool
    {
        $data = $this->model->data;
        return !is_null($data) && $data !== 'null' && !empty($data);
    }

    public function isNotFound(): bool
    {
        return $this->model->notFound ?? false;
    }

    public function isOfflinePost(): bool
    {
        return $this->model->offlineStatusUpdatedAt !== '1970-01-01';
    }

    // EXTRACT RAW

    public function rawGender(): ?string
    {
        return $this->userDataNode()?->gender;
    }

    public function rawTopPosition(): ?int
    {
        return $this->positionNode()?->position ?? 0;
    }

    public function rawTopPositionContinent(): ?string
    {
        return $this->positionNode()?->continent ?? null;
    }

    public function rawTopPositionPoints(): ?int
    {
        return $this->positionNode()?->points ?? 0;
    }

    public function rawName(): ?string
    {
        return $this->userDataNode()?->name;
    }

    public function rawCountry(): ?string
    {
        return $this->userDataNode()?->country;
    }

    public function rawLanguages(): ?array
    {
        return $this->userDataNode()?->languages;
    }

    public function rawAge(): ?int
    {
        return $this->userDataNode()?->age;
    }

    public function rawBirthDate(): ?string
    {
        return $this->userDataNode()?->birthDate;
    }

    public function rawBodyType(): ?string
    {
        return $this->userDataNode()?->bodyType;
    }

    public function rawEyeColor(): ?string
    {
        return $this->userDataNode()?->eyeColor;
    }

    public function rawHairColor(): ?string
    {
        return $this->userDataNode()?->hairColor;
    }

    public function rawEthnicity(): ?string
    {
        return $this->userDataNode()?->ethnicity;
    }

    public function rawIdleAt(): ?string
    {
        return Carbon::parse($this->userDataNode()?->wentIdleAt);
    }

    // FORMAT DATA

    public function gender(): ?string
    {
        return __('owner/information/details.genders.' . $this->rawGender());
    }

    public function iconGender(): string
    {
        return (new OwnerFormatter())->iconGender($this->rawGender());
    }

    public function topPosition($decimal = 0): string
    {
        return NumberHelper::format($this->rawTopPosition(), $decimal);
    }

    public function topPositionPoints($decimal = 0): string
    {
        return NumberHelper::format($this->rawTopPositionPoints(), $decimal);
    }

    public function translatedRanking(): string
    {
        if ($this->rawTopPositionContinent() || !empty($this->rawTopPositionContinent())) {
            return __('owner/information/details.ranking_info', [
                'position'  => $this->topPosition(),
                'icon'      => $this->iconGender(),
                'points'    => $this->topPositionPoints(),
                'continent' => __('owner/information/details.regions.' . $this->rawTopPositionContinent()),
            ]);
        } else {
            return __('owner/information/details.ranking_info_no_continent', [
                'position'  => $this->topPosition(),
                'icon'      => $this->iconGender(),
                'points'    => $this->topPositionPoints()
            ]);
        }
    }

    public function flagCountry(): string
    {
        return flag_country($this->rawCountry());
    }

    public function flagLanguages(): string
    {
        return flag_languages($this->rawLanguages());
    }

    public function bodyType(): string
    {
        return __('owner/information/details.body_types.' . $this->rawBodyType());
    }

    public function eyeColor(): string
    {
        return __('owner/information/details.eye_colors.' . $this->rawEyeColor());
    }

    public function hairColor(): string
    {
        return __('owner/information/details.hair_colors.' . $this->rawHairColor());
    }

    public function ethnicity(): string
    {
        return __('owner/information/details.ethnicities.' . $this->rawEthnicity());
    }

     public function offlinePost(): DatePresenter
    {
        return $this->date($this->model->offlineStatusUpdatedAt);
    }

    public function statusChangedDate(): DatePresenter
    {
        return $this->date($this->model->statusChangedAt);
    }

    public function idleDate(): DatePresenter
    {
        return $this->date($this->rawIdleAt());
    }
}

<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Services\Explore\ExploreService;
use App\Traits\OwnerProp;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\Attributes\Url;

class Explore extends Component
{
    use OwnerProp;

    #[Url]
    public string $countries = '';

    #[Url]
    public string $ethnicities = '';

    #[Url]
    public string $others = '';

    public array $tempCountries = [];
    public array $tempEthnicities = [];
    public array $tempOthers = [];

    public $owners = [];
    public $limit = 60;
    public $offset = 0;
    public $endResults = false;

    public function mount()
    {
        $this->tempCountries = array_filter(explode(',', $this->countries));
        $this->tempEthnicities = array_filter(explode(',', $this->ethnicities));
        $this->tempOthers = array_filter(explode(',', $this->others));
        $this->loadData();
    }

    public function applyFilters()
    {
        $this->countries = implode(',', array_filter($this->tempCountries));
        $this->ethnicities = implode(',', array_filter($this->tempEthnicities));
        $this->others = implode(',', array_filter($this->tempOthers));
        $this->offset = 0;
        $this->owners = [];
        $this->endResults = false;
        $this->loadData();
    }

    public function resetFilters()
    {
        $this->tempCountries = [];
        $this->tempEthnicities = [];
        $this->tempOthers = [];
        $this->applyFilters();
    }

    public function nextPage()
    {
        $this->offset += $this->limit;
        $this->loadData();
    }

    public function loadData()
    {
        $filterTags = [];
        if (!empty($this->countries)) {
            $filterTags[] = explode(',', $this->countries);
        }
        if (!empty($this->ethnicities)) {
            $filterTags[] = explode(',', $this->ethnicities);
        }

        foreach (array_filter(explode(',', $this->others)) as $tag) {
            $filterTags[] = [$tag];
        }

        $data = app(ExploreService::class)->filterSearch(
            $this->limit,
            $this->offset,
            $filterTags,
            'girls'
        );

        if ($data && isset($data->models)) {
            array_push($this->owners, ...$data->models);
            if (count($data->models) < $this->limit) {
                $this->endResults = true;
            }
        } else {
            $this->endResults = true;
        }
    }

    public function render()
    {
        $favs = Auth::guard('customer')->check()
            ? Customer::find(Auth::guard('customer')->user()->id)->getOwnerFavoriteIds()->toArray()
            : [];

        $this->dispatch('init-swiper');

        /** @var \Livewire\Features\SupportPageComponents\ContentRenderer $view */
        $view = view('livewire.explore', [
            'countryList' => $this->getCountryList(),
            'ethnicityList' => $this->getEthnicityList(),
            'othersList' => $this->getOthersList(),
            'hasChanges' => $this->checkChanges(),
            'favs' => $favs,
        ]);
        return $view->layoutData(['title' => ' | Explorar']);
    }

    protected function checkChanges()
    {
        $currC = array_filter(explode(',', $this->countries));
        sort($currC);
        $tempC = $this->tempCountries;
        sort($tempC);

        $currE = array_filter(explode(',', $this->ethnicities));
        sort($currE);
        $tempE = $this->tempEthnicities;
        sort($tempE);

        $currO = array_filter(explode(',', $this->others));
        sort($currO);
        $tempO = $this->tempOthers;
        sort($tempO);

        return $tempC !== $currC || $tempE !== $currE || $tempO !== $currO;
    }

    protected function getCountryList()
    {
        return [
            'América del Norte' => [
                'tagLanguageCanadian' => 'Canadienses',
                'tagLanguageUSModels' => 'Estadounidenses',
                'tagLanguageMexican' => 'Mexicanos',
            ],
            'América del Sur' => [
                'tagLanguageArgentinian' => 'Argentinian',
                'tagLanguageBrazilian' => 'Brazilian',
                'tagLanguageChilean' => 'Chilean',
                'tagLanguageColombian' => 'Colombian',
                'tagLanguageEcuadorian' => 'Ecuadorian',
                'tagLanguagePeruvian' => 'Peruvian',
                'tagLanguageUruguayan' => 'Uruguayan',
                'tagLanguageVenezuelan' => 'Venezuelan',
            ],
            'Europa' => [
                'tagLanguageGermanSpeaking' => 'German Speaking',
                'tagLanguageHungarian' => 'Hungarian',
                'tagLanguageAustrian' => 'Austrian',
                'tagLanguageBelgian' => 'Belgian',
                'tagLanguageIrish' => 'Irish',
                'tagLanguageItalian' => 'Italian',
                'tagLanguageLatvian' => 'Latvian',
                'tagLanguageLithuanian' => 'Lithuanian',
                'tagLanguageUKModels' => 'UK Models',
                'tagLanguageNordic' => 'Nordic',
                'tagLanguageNorwegian' => 'Norwegian',
                'tagLanguagePolish' => 'Polish',
                'tagLanguagePortuguese' => 'Portuguese',
                'tagLanguageRomanian' => 'Romanian',
                'tagLanguageSerbian' => 'Serbian',
                'tagLanguageBulgarian' => 'Bulgarian',
                'tagLanguageCzech' => 'Czech',
                'tagLanguageCroatian' => 'Croatian',
                'tagLanguageDanish' => 'Danish',
                'tagLanguageSlovakian' => 'Slovakian',
                'tagLanguageSlovenian' => 'Slovenian',
                'tagLanguageSpanish' => 'Spanish',
                'tagLanguageEstonian' => 'Estonian',
                'tagLanguageFinnish' => 'Finnish',
                'tagLanguageFrench' => 'French',
                'tagLanguageGeorgian' => 'Georgian',
                'tagLanguageGreek' => 'Greek',
                'tagLanguageDutch' => 'Dutch',
                'tagLanguageUkrainian' => 'Ukrainian',
                'tagLanguageSwiss' => 'Swiss',
                'tagLanguageSwedish' => 'Swedish',
            ],
            'Asia y Pacífico' => [
                'tagLanguageAustralian' => 'Australian',
                'tagLanguageChinese' => 'Chinese',
                'tagLanguageKorean' => 'Korean',
                'tagLanguageFilipino' => 'Filipino',
                'tagLanguageJapanese' => 'Japanese',
                'tagLanguageMalaysian' => 'Malaysian',
                'tagLanguageSriLankan' => 'Sri Lankan',
                'tagLanguageThai' => 'Thai',
                'tagLanguageVietnamese' => 'Vietnamese',
            ],
            'África' => [
                'tagLanguageAfrican' => 'African',
                'tagLanguageKenyan' => 'Kenyan',
                'tagLanguageMalagasy' => 'Malagasy',
                'tagLanguageNigerian' => 'Nigerian',
                'tagLanguageSouthAfrican' => 'South African',
                'tagLanguageUgandan' => 'Ugandan',
                'tagLanguageZimbabwean' => 'Zimbabwean',
            ],
            'Oriente Medio' => [
                'tagLanguageIsraeli' => 'Israeli',
                'tagLanguageTurkish' => 'Turkish',
            ],
        ];
    }

    protected function getEthnicityList()
    {
        return __('owner/information/details.ethnicities');
    }
    protected function getOthersList()
    {
        return [
            'autoTagNew' => 'Nuevos',
            'mobile' => 'Celular',
        ];
    }
}

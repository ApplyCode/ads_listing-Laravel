<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Country;
use App\Models\SearchCountry;
use App\Models\State;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Modules\Ad\Entities\Ad;

class NavSearchComponent extends Component
{
    public $location_search_country_input = '';

    public $location_search_state_input = '';

    public $location_search_city_input = '';

    public $location_search_countries = [];

    public $location_search_states = [];

    public $location_search_cities = [];

    public $location_search_active_country = '';

    public $location_search_active_country_id = '';

    public $location_search_active_state = '';

    public $location_search_active_state_id = '';

    public $location_search_active_city = '';

    public $location_search_active_city_id = '';

    public $location_search_modal = false;

    public $see_all_country_btn = true;

    public $search = null;

    public $landing = '';

    public $search_ad_val = '';
    public $lastDispatchedCountry = null;
    public $lastDispatchedState = null;
    public $lastDispatchedCity = null;
    protected $listeners = ['openModal', 'openComponent'];

    public function getStates($id, $name)
    {
        $this->location_search_states = State::where('country_id', $id)->select('id', 'name', 'country_id')->get();
        $this->location_search_active_country = $name;
        $this->location_search_active_country_id = $id;

        $this->updateMobileSearchNav();
        $this->searchInput();

        if ($this->location_search_states->isEmpty()) {
            $this->closeModal();
        }
    }

    public function getCities($id, $name)
    {
        $this->location_search_cities = City::where('state_id', $id)->select('id', 'name', 'state_id')->get();
        $this->location_search_active_state = $name;
        $this->location_search_active_state_id = $id;

        $this->updateMobileSearchNav();
        $this->searchInput();

        if ($this->location_search_cities->isEmpty()) {
            $this->closeModal();
        }
    }

    public function setCity($id, $name)
    {
        $this->location_search_active_city = $name;
        $this->location_search_active_city_id = $id;

        $this->updateMobileSearchNav();
        $this->searchInput();
        $this->closeModal();
    }

    public function search($model)
    {
        switch ($model) {
            case 'Country':
                $this->location_search_countries = SearchCountry::where('name', 'like', '%'.$this->location_search_country_input.'%')
                    ->select('id', 'name', 'slug', 'image', 'icon')
                    ->get();
                $this->see_all_country_btn = false;
                break;
            case 'State':
                $this->location_search_states = State::where('name', 'like', '%'.$this->location_search_state_input.'%')
                    ->where('country_id', $this->location_search_active_country_id)
                    ->select('id', 'name', 'country_id')->get();
                break;
            case 'City':
                $this->location_search_cities = City::where('name', 'like', '%'.$this->location_search_city_input.'%')
                    ->where('state_id', $this->location_search_active_state_id)
                    ->select('id', 'name', 'state_id')->get();
                break;
        }
    }

    public function searchInput()
    {
        if ($this->location_search_active_country) {
            $this->search = $this->location_search_active_country;
            $this->location_search_active_country = $this->location_search_active_country;
        }
        if ($this->location_search_active_state) {
            $this->search = $this->search.', '.$this->location_search_active_state;
            $this->location_search_active_state = $this->location_search_active_state;
        }
        if ($this->location_search_active_city) {
            $this->search = $this->search.', '.$this->location_search_active_city;
            $this->location_search_active_city = $this->location_search_active_city;
        }

        // Send Data to AdList Page and Mobile Search Nav
        $this->emit('adListSearchText', $this->search == 'Search' ? '' : $this->search);
    }

    public function updateMobileSearchNav()
    {
        // Send Data to Mobile Search Nav
        $this->emit('activeLocationFields', [
            'country' => $this->location_search_active_country,
            'state' => $this->location_search_active_state,
            'city' => $this->location_search_active_city,
        ]);
    }

    public function back($to)
    {
        switch ($this->location_search_active_country_id == '' ? 'empty' : $to) {
            case 'country':
                $this->location_search_active_country = '';
                $this->location_search_active_city = '';
                $this->search = 'Search';
                $this->searchInput();
                $this->updateMobileSearchNav();
                $this->seeAllCountry();
                break;
            case 'state':
                $this->location_search_active_state = '';
                $this->location_search_active_city = '';
                $this->search = $this->location_search_active_country;
                $this->searchInput();
                $this->updateMobileSearchNav();
                break;
            default:
                $this->location_search_active_country = '';
                $this->location_search_active_state = '';
                $this->location_search_active_city = '';
        }
    }

    public function seeAllCountry()
    {
        $this->location_search_countries = loadCountries();
        $this->see_all_country_btn = false;
    }

    public function gotoCountries()
    {
        $this->location_search_active_country = '';
        $this->location_search_active_country_id = '';
        $this->location_search_active_state = '';
        $this->location_search_active_state_id = '';
        $this->location_search_active_city = '';
        $this->location_search_active_city_id = '';
        $this->search = 'Search';
        $this->searchInput();
        $this->updateMobileSearchNav();

        $this->seeAllCountry();
    }

    public function openModal()
{
    // Open the location search modal and set up initial values
    $this->location_search_modal = true;
    $this->see_all_country_btn = true;

    // Load the countries and take the first 5
    $countries = loadCountries();
    // \Log::info('Loaded countries:', ['countries' => $countries]);
    $this->location_search_countries = $countries->take(5);

    // Retrieve the selected country
    $selectedCountry = selected_country();

    // Check if the selected country is valid
    if ($selectedCountry && !empty($selectedCountry->name)) {
        // Set the search value to the selected country name
        $this->search = $selectedCountry->name;

        // Find the country in the database
        $country = SearchCountry::where('name', 'like', '%'.$selectedCountry->name.'%')
            ->select('id', 'name', 'slug', 'image', 'icon')
            ->first();

        // Check if the country was found
        if ($country) {
            // Retrieve states for the found country
            $this->getStates($country->id, $country->name);
        } else {
            // Log a warning if the country is not found
            // \Log::warning("Country not found for name: {$selectedCountry->name}");
            // Optionally handle this case (e.g., set a default value or show a message)
            $this->search = '';
        }
    } else {
        // Log a warning if the selected country is null or empty
        // \Log::warning("Selected country is null or empty.");
        // Optionally handle this case (e.g., set a default value or show a message)
        $this->search = '';
    }
}


    public function closeModal()
    {
        $this->location_search_modal = false;
        $this->see_all_country_btn = false;
        $this->location_search_countries = [];
    }

    public function mount()
    {
        $currentPath = request()->path();

        if (str_contains($currentPath, '/ads/')) {
            $explodedPath = explode('/', $currentPath);
            if ($explodedPath[0] !== 'ads' && $explodedPath[1] !== 'ads') {
                $this->location_search_active_state = str_replace('-', ' ', $explodedPath[1]);
                $this->location_search_active_state_id = State::whereName($explodedPath[1])->first()?->value('id');
            } elseif ($explodedPath[0] !== 'ads' && $explodedPath[1] !== 'ads' && $explodedPath[2] !== 'ads') {
                $this->location_search_active_city = str_replace('-', ' ', $explodedPath[2]);
                $this->location_search_active_city_id = City::whereName($explodedPath[2])->first()?->value('id');
            }
        }
    }

    public function render()
    {
        if (! is_null($this->search_ad_val) && (strlen(($this->search_ad_val)) > 1)) {
            $filter_ads = Ad::active()->where('title', 'like', '%'.$this->search_ad_val.'%')
                ->take(5)
                ->get();
        } else {
            $filter_ads = [];
        }

        $currentCountry = strtolower(Country::where('name', 'like', '%' . $this->location_search_active_country . '%')->value('sortname'));
        if ($currentCountry !== $this->lastDispatchedCountry || $this->location_search_active_state !== $this->lastDispatchedState || $this->location_search_active_city !== $this->lastDispatchedCity) {
            $this->dispatchBrowserEvent('update-url', [
                'country' => $currentCountry && $currentCountry == 'um' ? 'us' : $currentCountry,
                'state' => $this->location_search_active_state,
                'city' => $this->location_search_active_city
            ]);

            // Update the last dispatched values
            $this->lastDispatchedCountry = $currentCountry;
            $this->lastDispatchedState = $this->location_search_active_state;
            $this->lastDispatchedCity = $this->location_search_active_city;
        }


        return view('livewire.nav-search-component', [
            'filter_ads' => $filter_ads,
        ]);
    }
}

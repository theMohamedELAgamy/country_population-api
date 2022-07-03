<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class CountryService {


    public function fetchCountriesApi(){
            return Http::get($_ENV['countries_provider'])->json();
    }
}
?>
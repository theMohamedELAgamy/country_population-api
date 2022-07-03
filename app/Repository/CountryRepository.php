<?php
namespace App\Repository;
use  App\Repository\iCountryRepository;
use  App\Services\CountryService;

 class CountryRepository implements iCountryRepository{

    public $countryservice;
    public function __construct(CountryService $countryservice) {
        $this->countryservice = $countryservice;
    }

    public function syncCountries(){
        $countries=$this->countryservice->fetchCountriesApi();
        foreach($countries['data'] as  $country){
            dd($country['populationCounts']);
           Country::updateOrCreate([['code'=>$country['code']],[
            'name'=>$country['country'],
            
           ]
           

        ]);
         };
       
        
    }
}
?>
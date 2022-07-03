<?php
namespace App\Repository;
use  App\Repository\iCountryRepository;
use  App\Services\CountryService;
use  App\Models\Country;
use  App\Models\Year;
use  App\Models\YearCountry;
 class CountryRepository implements iCountryRepository{

    public $countryservice;
    public function __construct(CountryService $countryservice) {
        $this->countryservice = $countryservice;
    }

    public function syncCountries(){
        $countries=$this->countryservice->fetchCountriesApi();
        try{
        foreach($countries['data'] as  $country){
                $c_record=Country::updateOrCreate(['code'=>$country['code']],[
                    'code'=>$country['code'],
                    'name'=>$country['country'],
                ]    
                );
            };
            foreach($countries['data'] as  $country){
                foreach($country['populationCounts'] as $year )
             {   $year_record=Year::updateOrCreate(['year'=>$year['year']],[
                            'year'=>$year['year'],
                            
                        ]    
                        );}
            };
           
            foreach($countries['data'] as  $country){
                $c_record=Country::where('code', $country['code'])->firstOrFail();
                foreach($country['populationCounts'] as $year )
             {   
                $year_record=Year::where('year', $year['year'])->firstOrFail();
                YearCountry::updateOrCreate(['country_id'=>$c_record->id,'year_id'=>$year_record->id],[
                    'country_id'=>$c_record->id,
                    'year_id'=>$year_record->id,
                    'population'=>$year['value']
                    
                ]    
                );
               
            };
        
                
            }
        }catch(exception $e){
            return response(['internal server error'],500);
        }
        return response(['Done'],200);
         
       
        
    }
    public function listCountries(){
        $per_page=50;
        if($request->has('per_page'))  $per_page=$request->per_page;
        $countries = Country::paginate($per_page);
        $data['countries']=$countries;
        return response($data,200);
    }
    public function  getOneCountry($country_id){
        dd($country_id);
        YearCountry::where('country_id',$country);
        
    }
    public function minCouuntry(){
        $yearcountry=YearCountry::where('year',2018)->max('population');
        $country=Country::findOrFail($yearcountry->country_id);
        return response($country,200);

    }
    public function maxCouuntry(){
        $yearcountry=YearCountry::where('year',2018)->min('population');
        $country=Country::findOrFail($yearcountry->country_id);
        return response($country,200);
        
    }

}
?>
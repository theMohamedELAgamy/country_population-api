<?php
namespace App\Repository;
use  App\Repository\iCountryRepository;
use  App\Services\CountryService;
use  App\Models\Country;
use  App\Models\Year;
use Illuminate\Http\Response;

use  App\Models\YearCountry;
use  App\Http\Resources\V1\CountryResource;
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
            ;
                foreach($country['populationCounts'] as $year )
             {   $year_record=Year::updateOrCreate(['year'=>$year['year']],[
                            'year'=>$year['year'],
                            
                        ]    
                        );
           
           
     
                
                YearCountry::updateOrCreate(['country_id'=>$c_record->id,'year_id'=>$year_record->id],[
                    'country_id'=>$c_record->id,
                    'year_id'=>$year_record->id,
                    'population'=>$year['value']
                    
                ]    
                );}}
               
            ;
        
                
            
        }catch(exception $e){
            return response(['internal server error'],500);
        }
        return response(['Done'],200);
         
       
        
    }
    public function listCountries($request){
        $per_page=50;
        if($request->has('per_page'))  $per_page=$request->per_page;
        $countries = Country::paginate($per_page);
        $data['countries']=$countries;
        return response( $data,200);
    }
    public function  getOneCountry($country_id){
        
        $country=Country::findOrFail($country_id);
        return response([$country,$country->yearcountry],200);
        
    }

    public function minCountry(){
        $population=YearCountry::where('year_id',58)->min('population');
        $country=YearCountry::where('population',$population)->first();
         $country=Country::findOrFail($country['country_id']);
         return response([$country,$population],200);

    }

    public function maxCountry(){

        $population=YearCountry::where('year_id',58)->max('population');
       $country=YearCountry::where('population',$population)->first();
        $country=Country::findOrFail($country['country_id']);
        return response([$country,$population],200);
        
    }

}
?>
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
        $countries=$countries['data'];
        $countryArray=[];
        $yearArray=[];
        foreach ($countries as $country) {
            foreach ($country["populationCounts"] as $year) {
                $record=['country'=>$country['code']]
               array_push($yearArray,$year);
            }
            dd($yearArray);
            unset($country["populationCounts"]);
            array_push($countryArray,$country);
        };
        
        Country::upsert($countryArray,['code']);
        Year::upsert($yearArray,['year']);
        dd('here');
        try{
        foreach($countries as  $country){
           
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
        return response([$country->name,$country->yearcountry],200);
        
    }


    public function maxminCountry(){
        $lastyear=Year::max('year');
        $lastyear_id=Year::where('year',$lastyear)->first();
        $minpopulation=YearCountry::where('year_id',$lastyear_id->id)->min('population');
        $mincountry=YearCountry::where('population',$minpopulation)->first();
         $mincountry=Country::findOrFail($mincountry['country_id']);
        $maxpopulation=YearCountry::where('year_id',$lastyear_id->id)->max('population');
       $maxcountry=YearCountry::where('population',$maxpopulation)->first();
        $maxcountry=Country::findOrFail($maxcountry['country_id']);
        return response(['min country'=>['Country'=>$mincountry->name,'min population'=>$minpopulation],'max country'=>['Country'=>$maxcountry->name,'max population'=>$maxpopulation]],200);
        
    }

}
?>
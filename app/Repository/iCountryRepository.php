<?php 
namespace App\Repository;
interface iCountryRepository{
    public function syncCountries();
    public function listCountries($request);
    public function getOneCountry($country_id);
    public function maxminCountry();
}
?>
<?php 
namespace App\Repository;
interface iCountryRepository{
    public function syncCountries();
    public function listCountries();
    public function getOneCountry($country_id);
    public function minCouuntry();
    public function maxCouuntry();
}
?>
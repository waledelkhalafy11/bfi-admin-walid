<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $unitCount = \App\Models\Hero_card::find(1);
        
        if($unitCount){
            $units = \App\Models\Unit::all();
            function getPropsPhotos ($allunits) {
                $unitsData= array();
                foreach ($allunits as $unit){
                    $location = DB::table('districts')
                    ->select( 'districts.city_id', 'regions.region_name', 'cities.city_name', 'cities.region_id')
                    ->join('cities', 'cities.id','=', 'districts.city_id')
                    ->join('regions', 'regions.id','=', 'cities.region_id')
                    ->where('districts.id', $unit->dist_id)->get();
                    array_push($unitsData , array('unit'=>$unit,'location'=>$location));
                };
            return $unitsData;
            }
                $dataresponed = getPropsPhotos($units);
            return view('home' , ['dataresponed'=>$dataresponed]);

        }else{

            \App\Models\Unit_counter::create(array(
                'count' => 0
            ));

            $heroCardsInitialData=array(
                array(
                    'card_title' => 'Fast Preformance',
                    'card_desciption' => 'Optimized for a smaller build size, faster dev compilation and dozens of other improvements',
                    'icon_id' => 1,
                    'element_id_name'=> 'firstCard'
                ),array(
                    'card_title' => 'Fast Preformance',
                    'card_desciption' => 'Optimized for a smaller build size, faster dev compilation and dozens of other improvements',
                    'icon_id' => 2,
                    'element_id_name'=> 'secondCard'
                ),array(
                    'card_title' => 'Fast Preformance',
                    'card_desciption' => 'Optimized for a smaller build size, faster dev compilation and dozens of other improvements',
                    'icon_id' => 3,
                    'element_id_name'=> 'thirdCard'
                ),array(
                    'card_title' => 'Fast Preformance',
                    'card_desciption' => 'Optimized for a smaller build size, faster dev compilation and dozens of other improvements',
                    'icon_id' => 4,
                    'element_id_name'=> 'fourthCard'
                )
           );
           $heroIconsData=array(array(
                'card_icon_url' => '/assets/icons/hero-appartment.svg',
            ),array(
                'card_icon_url' => '/assets/icons/hero-house.svg',
            ),array(
                'card_icon_url' => '/assets/icons/hero-house-things.svg',
            ),array(
                'card_icon_url' => '/assets/icons/hero-office.svg',
            ),array(
                'card_icon_url' => '/assets/icons/hero-real-estate.svg',
            ),array(
                'card_icon_url' => '/assets/icons/hero-real-estate-mansion.svg',
            ),array(
                'card_icon_url' => '/assets/icons/hero-real-estate-rent.svg',
            ));
    
            foreach ($heroIconsData as $x => $icon) {
                \App\Models\Card_icon::create($icon);
            }


            $countersInitialData=array(array(
                'count_name' => 'Property Location',
                'num_count' => 200
            ),array(
                'count_name' => 'Professionals Agents',
                'num_count' => 30
            ),array(
                'count_name' => 'Happy clients',
                'num_count' => 1760
            ),array(
                'count_name' => 'Property For sale',
                'num_count' => 42
            ));
            $exploreCardsInitialData=array(
                'place_name' => 'cairo',
                'card_image_url' => '/assets/images/hhhh.png',
            );
            
            
            foreach ($heroCardsInitialData as $x => $card) {
                \App\Models\Hero_card::create($card);
            }
            for($i = 0 ; $i < 5 ; $i++){
                \App\Models\Explore_card::create($exploreCardsInitialData);
            }
            foreach ($countersInitialData as $x => $counter) {
                \App\Models\Counter::create($counter);
            }

           
            $units = \App\Models\Unit::all();
            function getPropsPhotos ($allunits) {
                $unitsData= array();
                foreach ($allunits as $unit){
                    $location = DB::table('cities')
                    ->select( 'regions.region_name', 'cities.city_name', 'cities.region_id')
                    ->join('regions', 'regions.id','=', 'cities.region_id')
                    ->where('cities.id', $unit->city_id)->get();
                    array_push($unitsData , array('unit'=>$unit,'location'=>$location));
                };
            return $unitsData;
            }
                $dataresponed = getPropsPhotos($units);
            return view('home' , ['dataresponed'=>$dataresponed]);
        }
        
       
    }
}

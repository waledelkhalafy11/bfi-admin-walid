<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function allRegions(){
        $regions = \App\Models\Region::all();
        return view('all_regions' , ['regions' => $regions]);
    }
    public function allCities(){
        $cities = \App\Models\City::all();
        
        return view('all_cities' , ['cities' => $cities]);
    }

    public function allRegionCities($rid){
        $cities = DB::table('cities')
        ->select('cities.id','city_name','city_longitude','city_latitude')
        ->where('cities.region_id', $rid)->get();
        $region = \App\Models\Region::find($rid);

        return view('region_cities' , ['cities' => $cities , 'region'=>$region ]);
    }

    public function addregion_view(){
        return view('addnew_Region');    
    }

    public function addcity_view(Request $request){
        $region = $request->region_id;
        $regionData = \App\Models\Region::find($region);


        return view('addnew_City' , ['region' => $region , 'regionData'=>$regionData]);
    }
    public function addcity_viewBack($rid){
        
        $regionData = \App\Models\Region::find($rid);
        return view('addnew_City' , ['region' => $rid , 'regionData'=>$regionData]);
    }

    public function addregion(Request $request){


        $validator = Validator::make($request->all(), [
            'region_name' => 'required',
            'region_longitude' => 'required',
            'region_latitude' => 'required',
        ]);

        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            $validated = $validator->validated();

        $region = array(
            'region_name' => $validated['region_name'], 
            'region_longitude' => $validated['region_longitude'],
            'region_latitude'=>$validated['region_latitude']
        );

        $success = \App\Models\Region::create($region);
        if($success){

            return redirect('/regions')->with('message', 'Region Added Successfully ');
        }
    }
    public function addcity(Request $request){

        $validator = Validator::make($request->all(), [
            'region_id' => 'required',
            'city_name' => 'required',
            'city_longitude' => 'required',
            'city_latitude' => 'required',

        ]);

        
        if ($validator->fails()) {
            return redirect(route('addcity_viewBack' , ['rid'=> $request->region_id]))->withErrors($validator)->withInput();
        }
            $validated = $validator->validated();
        $city = array(
            'region_id' => $validated['region_id'], 
            'city_name' => $validated['city_name'], 
            'city_longitude' => $validated['city_longitude'],
            'city_latitude'=>$validated['city_latitude']
        );
        $success = \App\Models\City::create($city);
        if($success){

            return redirect('/cities')->with('message', 'City Added Successfully ');
        }
    }



    public function updateCity_view($cid){
        $cityData = \App\Models\City::find($cid);
        return view('update_city' ,['cityData'=>$cityData]);
    }




    public function updateRegion_view($rid){
        $regionData = \App\Models\Region::find($rid);
        return view('update_region' ,['regionData'=>$regionData]);
    }


   


    public function updateregionData(Request $request){

        $validator = Validator::make($request->all(), [
            'region_id' => 'required',
            'region_name' => 'required',
            'region_longitude' => 'required',
            'region_latitude' => 'required',
        ]);

        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            $validated = $validator->validated();

        $newData = array(
            'region_name' => $validated['region_name'], 
            'region_longitude' => $validated['region_longitude'],
            'region_latitude'=>$validated['region_latitude']
        );

        $region = \App\Models\Region::find($validated['region_id']);
       
        $region->update($newData);
        return redirect('/regions')->with('message', 'Region Updated Successfully ');


    }

    public function updatecityData(Request $request){

        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'region_id' => 'required',
            'city_name' => 'required',
            'city_longitude' => 'required',
            'city_latitude' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            $validated = $validator->validated();
        $newData = array(
            'region_id' => $validated['region_id'], 
            'city_name' => $validated['city_name'], 
            'city_longitude' => $validated['city_longitude'],
            'city_latitude'=>$validated['city_latitude']
        );
        $city = \App\Models\City::find($validated['city_id']);
        $city->update($newData);
        return redirect('/cities')->with('message', 'City Updated Successfully ');


    }



    public function allDistricts(){

            $districts = \App\Models\District::all();
            return view('all_districts' , ['districts' => $districts]);
        

    }

    public function allCityDistricts($cid){
        $districts = DB::table('districts')
        ->select('districts.city_id','districts.id','dist_name','dist_longitude','dist_latitude')
        ->where('districts.city_id', $cid)->get();
        $city = \App\Models\City::find($cid);

        return view('city_districts' , ['districts' => $districts , 'city'=>$city]);
    

    }


    public function addDist () {
        $regions = \App\Models\Region::all();
        $cities = \App\Models\City::all();

        return view('add_Dist' , ["regions"=>$regions , "cities"=>$cities ]);
    }






    public function addDist_view(Request $request ){
        $city = $request->city;
        $cityData = \App\Models\City::find($city);


        return view('addnew_District' , ['city' => $city , 'cityData'=>$cityData]);
    }


    public function addDist_viewBack( $cid ){
        
        $cityData = \App\Models\City::find($cid);


        return view('addnew_District' , ['city' => $cid , 'cityData'=>$cityData]);
    }
    

    public function add_dist( Request $request ){

        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'dist_name' => 'required',
            'dist_longitude' => 'required',
            'dist_latitude' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect(route('addDist_viewBack' , [ 'cid' =>$request->city_id ]))->withErrors($validator)->withInput();
        }else{

            $validated = $validator->validated();
            \App\Models\District::create(array(
                'city_id' => $validated['city_id'],
                'dist_name' => $validated['dist_name'],
                'dist_longitude' => $validated['dist_longitude'],
                'dist_latitude' => $validated['dist_latitude'],
            ));
            
            return redirect('/districts')->with('message', 'District Added Successfully ');

        }
        

    }

    
    public function updateDist_view( $did ){
        $dist =  \App\Models\District::find($did);

            return view ('update_district' , ['dist'=>$dist]);        

    }

    
    
    
    public function updatedistData( Request $request ){

        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'dist_name' => 'required',
            'dist_longitude' => 'required',
            'dist_latitude' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

            $validated = $validator->validated();
            $dist = \App\Models\District::find($request->dist_id);
            $dist->update(array(
                'city_id' => $validated['city_id'],
                'dist_name' => $validated['dist_name'],
                'dist_longitude' => $validated['dist_longitude'],
                'dist_latitude' => $validated['dist_latitude'],
            ));
            
            return redirect('/districts')->with('message', 'District Updated Successfully ');

        }
        

    }


}

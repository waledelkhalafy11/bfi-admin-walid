<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


use League\Flysystem\UnixVisibility\PortableVisibilityConverter;


class UnitController extends Controller
{

     /* ===========================
    *    ======================
    *   || Selecting Location ||
    *    ======================
    * =============================
    */
    public function addUnit () {
        $regions = \App\Models\Region::all();
        $cities = \App\Models\City::all();
        $districts = \App\Models\District::all();

        return view('add_Unit' , ["regions"=>$regions , "cities"=>$cities , 'districts'=>$districts  ]);
    }


 /* ==========================================
     *    =================================
     *   || Adding Units & props & Photos ||
     *    =================================
     * =======================================
     */

    public function addnewUnit (Request $request) {
        $distData = \App\Models\District::find($request->district);

        return view('addnew_Unit' , ["district"=>$request->district ,'distData'=>$distData]);
    }
    public function addnewUnitBack ($did) {
        $distData = \App\Models\District::find($did);

        return view('addnew_Unit' , ["district"=>$did ,'distData'=>$distData]);
    }


    
    public function upload_addPhoto (Request $request ){
       

        $unitCount = \App\Models\Unit_counter::find(1);
        $newUnitID = $unitCount->count+1;
        

        $validator = Validator::make($request->all(), [
            'unit_name' => 'required',
            'unit_address' => 'required',
            'unit_description' => 'required',
            'unit_longitude' => 'required',
            'unit_latitude' => 'required',
            'unit_price' => 'required',
            'dist_id' => 'required',
            'main_category' => 'required',
            'images' => 'required',
            'kitchen' =>  'required', 
            'bedroom' =>  'required', 
            'rooms' => 'required', 
            'living_room' => 'required', 
            'bathroom' =>  'required', 
            'garage' =>  'required', 
            'garden' =>  'required',
            'pool' =>  'required',
            'elevator' =>  'required',
            'floor' =>  'required',
            'surface_area' =>  'required'

        ]);

        
        if ($validator->fails()) {
            return redirect(route('addnewUnitBack', ['did'=> $request->dist_id]))->withErrors($validator)->withInput();
        }
        
        $validated = $validator->validated();

        $unitInput = array(
            'unit_name' => $validated['unit_name'], 
            'unit_address' => $validated['unit_address'], 
            'unit_description' =>$validated['unit_description'], 
            'unit_longitude' => $validated['unit_longitude'], 
            'unit_latitude' => $validated['unit_latitude'], 
            'unit_price' => $validated['unit_price'], 
            'dist_id' => $validated['dist_id'], 
            'main_category' => $validated['main_category'],
            'unit_category' => $request->unit_category,
            'res_unit_category' => $request->res_unit_category


        );

        $addNewUnit = \App\Models\Unit::create($unitInput);
        if($addNewUnit){
            $unitCount->update(array(
                'count'=> $unitCount->count+1
            ));
        }

        $propertyInput = array(
            'unit_id' => $newUnitID, 
            'kitchen' => $validated['kitchen'], 
            'bedroom' => $validated['bedroom'], 
            'rooms' => $validated['rooms'], 
            'living_room' => $validated['living_room'], 
            'bathroom' => $validated['bathroom'], 
            'garage' => $validated['garage'], 
            'garden' => $validated['garden'],
            'pool' => $validated['pool'],
            'elevator' => $validated['elevator'],
            'floor' => $validated['floor'],
            'surface_area' => $validated['surface_area']
        );

        \App\Models\Proprty::create($propertyInput);


        $unit = $request->unit ; 
            
        $images=array();
        if($files=$validated['images'] ) {
            foreach($files as $i=>$file){
                global $request ;
                global $newUnitID ;
                $name=$file->getClientOriginalName();
                $imagename = $request->unit_name.rand(1,999999999).'_indexof_'.rand(1,999999999).$i.$name;
                // $file->storeAs('public/images', $imagename);   
                $file->move('/var/www/html/bfi-api/storage/app/public/images' , $imagename);                
                $photoInput = array(
                    'unit_id' => \App\Models\Unit::max('id'), 
                    'unit_image_url' => '/storage/images/'.$imagename, 
                );
                \App\Models\Unit_photo::create($photoInput);
                $images[]=$name;
            }
          
            
           



        
        }    
        
        return redirect('/units')->with('message', 'Unit Added Successfully ');
    }



     /* ========================
     *    ==================
     *   || All Units Data ||
     *    ==================
     * =========================
     */
    public function showAllUnits (){
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
        return view('all_units' , ['dataresponed'=>$dataresponed]);
    
    }
    

    public function showAllDistUnits ($dis){
        $units = \App\Models\Unit::all();
        $district = \App\Models\District::find($dis);
        function getPropsPhotos ($allunits , $dist) {
            $unitsData= array();
            foreach ($allunits as $unit){
                if($unit->dist_id == $dist){
                    $location = DB::table('districts')
                    ->select( 'districts.city_id', 'regions.region_name', 'cities.city_name', 'cities.region_id')
                    ->join('cities', 'cities.id','=', 'districts.city_id')
                    ->join('regions', 'regions.id','=', 'cities.region_id')
                    ->where('districts.id', $unit->dist_id)->get();
                    array_push($unitsData , array('unit'=>$unit,'location'=>$location));
                }
            };
        return $unitsData;
        }
            $dataresponed = getPropsPhotos($units , $dis);
        return view('dist_units' , ['dataresponed'=>$dataresponed , 'district'=>$district]);
    
    }


     

     /* ==========================
     *    ====================
     *   || update Unit Data ||
     *    ====================
     * ===========================
     */
    public function updateUnit_view (Request $request){
        $uid = $request->uid ;
        $unit = \App\Models\Unit::find($uid);
        $proprty = DB::table('proprties')
        ->select('proprties.id','kitchen','bedroom','rooms','living_room','bathroom','garage','garden','elevator','floor' , 'surface_area', 'pool')
        ->join('units', 'units.id','=', 'proprties.unit_id')
        ->where('units.id', $uid)->get();
        $proprties = $proprty[0];
        $mainCat = array(
            'Residential' , 'Commercial', 'Administrative' ,'Medical'
        );
        
        return view('update_unit' , ["unit"=>$unit ,"proprties"=>$proprties , 'mainCat'=>$mainCat]);}

    public function updateUnit (Request $request){


        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'unit_name' => 'required',
            'unit_address' => 'required',
            'unit_description' => 'required',
            'unit_longitude' => 'required',
            'unit_latitude' => 'required',
            'unit_price' => 'required',
            'dist_id' => 'required',
            'main_category' => 'required',
            'kitchen' =>  'required', 
            'bedroom' =>  'required', 
            'rooms' => 'required', 
            'living_room' => 'required', 
            'bathroom' =>  'required', 
            'garage' =>  'required', 
            'garden' =>  'required',
            'elevator' =>  'required',
            'floor' =>  'required',
            'surface_area' =>  'required',
            'pool' =>  'required',

        ]);

        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $validated = $validator->validated();


        $unitInputUpdate = array(
            'unit_name' => $validated['unit_name'], 
            'unit_address' => $validated['unit_address'], 
            'unit_description' =>$validated['unit_description'], 
            'unit_longitude' => $validated['unit_longitude'], 
            'unit_latitude' => $validated['unit_latitude'], 
            'unit_price' => $validated['unit_price'], 
            'dist_id' => $validated['dist_id'], 
            'main_category' => $validated['main_category'],
            'unit_category' => $request->unit_category,
            'res_unit_category' => $request->res_unit_category

            
        );
        
        $unit = \App\Models\Unit::find($request->unit_id);
        $unit->update($unitInputUpdate);
        $propertyInputUpdate = array(
            'unit_id' => $validated['unit_id'], 
            'kitchen' => $validated['kitchen'], 
            'bedroom' => $validated['bedroom'], 
            'rooms' => $validated['rooms'], 
            'living_room' => $validated['living_room'], 
            'bathroom' => $validated['bathroom'], 
            'garage' => $validated['garage'], 
            'garden' => $validated['garden'],
            'elevator' => $validated['elevator'],
            'floor' => $validated['floor'],
            'surface_area' => $validated['surface_area'],
            'pool' => $validated['pool'],
        );
        
        $proprty = \App\Models\Proprty::find($request->property_id);
        $proprty->update($propertyInputUpdate);

        return redirect('/units')->with('message', 'Unit Updated Successfully ');}




     /* =====================
     *    ===============
     *   || Delete Unit ||
     *    ===============
     * ======================
     */
    public function deleteUnit(Request $request ,  $uid) {
        $findid = \App\Models\Unit::find($uid);
        $findid->delete();
        return redirect('/units')->with('message', 'Unit Deleted Successfully ');
    }

    public function updatePhoto_view($uid){
        $photos = DB::table('unit_photos')
        ->select('unit_photos.id','unit_image_url')
        ->join('units', 'units.id','=', 'unit_photos.unit_id')
        ->where('units.id', $uid)->get();
    return view('update_photos' , ['photos' => $photos , 'uid'=>$uid]);}



       /* ==========================
     *    ======================
     *   || update Unit Photos ||
     *    ======================
     * =============================
     */
    public function updateunitPhotoView($uid){
    return view('addnew_Unit_photos' , ['uid'=>$uid ]);}


    public function updateunitPhoto(Request $request){      
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'images' => 'required',
        ]);

        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

            $validated = $validator->validated();
        
        $unit = \App\Models\Unit::find($validated['unit_id']);
        $images=array();
        
        if($files=$validated['images'] ) {
            foreach($files as $i=>$file){
                
                $name=$file->getClientOriginalName();
                $imagename = $unit->unit_name.rand(1,999999999).'_indexof_'.rand(1,999999999).$i.$name;
                // $file->storeAs('public/images', $imagename);   
                $file->move('/var/www/html/bfi-api/storage/app/public/images' , $imagename);
                $photoInput = array(
                    'unit_id' => $validated['unit_id'], 
                    'unit_image_url' => '/storage/images/'.$imagename, 
                );
                \App\Models\Unit_photo::create($photoInput);
                $images[]=$name;
            }
        }        
        return \Redirect::route('updatephotoview', ['uid'=>$request->unit_id])->with('message', 'Photos Added Successfully ');}
    }

        public function changePhoto(Request $request){




        $validator = Validator::make($request->all(), [
            'photo_id' => 'required',
            'image' => 'required',
        ]);

        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

            $validated = $validator->validated();

            $photo =\App\Models\Unit_photo::find($validated['photo_id']);
            $unit = \App\Models\Unit::find($photo->unit_id);
            $splitUrl = str_split($photo->unit_image_url , 9);
            $oldName = '';
            foreach ($splitUrl as $i => $cut) {
                if($i > 0){
                    $oldName = $oldName.$cut;
                }
            }
            if(Storage::exists('app/public/'.$oldName)){
                unlink(storage_path('app/public/'.$oldName));
                $file = $request->file('image');
                $name=$file->getClientOriginalName();
                $imagename = $unit->unit_name.rand(1,999999999).'_indexof_'.rand(1,999999999).$name;
                // $file->storeAs('public/images', $imagename);   
                $file->move('/var/www/html/bfi-api/storage/app/public/images' , $imagename);
                $photoInput = array(
                    'unit_id' => $unit->id, 
                    'unit_image_url' => '/storage/images/'.$imagename, 
                );
                $photo->update($photoInput);
            }else{
                $file = $request->file('image');
                $name=$file->getClientOriginalName();
                $imagename = $unit->unit_name.rand(1,999999999).'_indexof_'.rand(1,999999999).$name;
                // $file->storeAs('public/images', $imagename);   
                $file->move('/var/www/html/bfi-api/storage/app/public/images' , $imagename);
                $photoInput = array(
                    'unit_id' => $unit->id, 
                    'unit_image_url' => '/storage/images/'.$imagename, 
                );
                $photo->update($photoInput);
            }
           
            return \Redirect::route('updatephotoview', ['uid'=>$photo->unit_id])->with('message', 'Photo Changed Successfully ');}
    }
        
       


     /* ===========================    =====================
     *   || delete Unit photo ||
     *    =====================
     * ============================
     */
    public function deletePhoto(Request $request){
        $unitphoto =\App\Models\Unit_photo::find($request->photo_id); 
        $splitUrl = str_split($unitphoto->unit_image_url , 9);
        $name = '';
        foreach ($splitUrl as $i => $cut) {
            if($i > 0){
                $name = $name.$cut;
            }
        }
        if(Storage::exists('app/public/'.$name)){
            unlink(storage_path('app/public/'.$name));
        }
        $unitphoto->delete();
        return \Redirect::route('updatephotoview', ['uid'=>$unitphoto->unit_id])->with('message', 'Photo Deleted Successfully ');}



    
}


    
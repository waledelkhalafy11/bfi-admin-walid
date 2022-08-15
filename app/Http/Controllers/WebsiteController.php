<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class WebsiteController extends Controller
{


     /* =========================================
     *    ====================================
     *   || All Website Customizations Views ||
     *    ====================================
     * ==========================================
     */
    public function allCounters(){
        $counters = \App\Models\Counter::all();
        return view('all_counters' , ['counters'=>$counters]);
    }
    public function allCards(){
        $heroCards = \App\Models\Hero_card::all();
        $heroIcon = \App\Models\Card_icon::all();
        return view('all_hero_cards' , ['heroCards'=>$heroCards , 'icons'=>$heroIcon]);
    }
    public function allExploreCards(){
        $exploreCards = \App\Models\Explore_card::all();
        return view('all_explore_cards' , ['exploreCards'=>$exploreCards]);
    }
    public function allClients(){
        $clientsData = \App\Models\Client_item::all();
        if ($clientsData) {
            return view('all_clients' , ['clientsData'=>$clientsData]);
        }else {
            return view('all_clients');}
    }




     /* ==============================
     *    ========================
     *   || Update Sections Data ||
     *    ========================
     * ===============================
     */
    public function updateCountersView($countid){
        $counter = \App\Models\Counter::find($countid);
        return view('update_counters' , ['counter'=>$counter]);
    }
    public function updateHeroCardsView($cardid){
        $heroCard = \App\Models\Hero_card::find($cardid);
        $icons = \App\Models\Card_icon::all();
        return view('update_hero' , ['heroCard'=>$heroCard , 'icons'=>$icons]);
    }
    public function updateExploreView($cardid){
        $exploreCard = \App\Models\Explore_card::find($cardid);
        return view('update_explore' , ['exploreCard'=>$exploreCard]);
    }
    public function updateClientsView($clientid){
        $clientData = \App\Models\Client_item::find($clientid);
        return view('update_clients' , ['clientData'=>$clientData]);
    }

    public function updateCounters(Request $request){

        $validator = Validator::make($request->all(), [
            'counter_id' => 'required',
            'count_name' => 'required',
            'num_count' => 'required',
            
          

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            $validated = $validator->validated();
        $counter = \App\Models\Counter::find($validated['counter_id']);
        $counter->update(array(
            'count_name'=> $validated['count_name'],
            'num_count'=> $validated['num_count']
        ));
        return redirect('/web/counters')->with('message', 'Counter Updated Successfully ');

    }
    public function updateHeroCards(Request $request){
        $validator = Validator::make($request->all(), [
            'card_id' => 'required',
            'card_title' => 'required',
            'card_desciption' => 'required',
            'icon_id' => 'required',
          

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            $validated = $validator->validated();



        $heroCard = \App\Models\Hero_card::find($validated['card_id']);
        $heroCard->update(array(
            'card_title'=>$validated['card_title'],
            'card_desciption'=>$validated['card_desciption'],
            'icon_id'=>$validated['icon_id']
        ));
        return redirect('/web/hero-cards')->with('message', 'Card Updated Successfully ');

    }
    public function updateExplore(Request $request){
        $exploreCard = \App\Models\Explore_card::find($request->card_id);


        if($exploreCard->card_image_url == '/assets/images/hhhh.png'){
           
            if($request->file('image') == null){

                $validator = Validator::make($request->all(), [
                    'place_name' => 'required',
                ]); 
        
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $validated = $validator->validated(); 

                $photoInput = array(
                    'place_name' => $validated['place_name'], 
                    'card_image_url' => $exploreCard->card_image_url, 
                );
                $exploreCard->update($photoInput);}
            }else{ 

                $validator = Validator::make($request->all(), [
                    'place_name' => 'required',
                ]); 
        
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $validated = $validator->validated(); 
                $file = $request->file('image');
                $name=$file->getClientOriginalName();
                $imagename = $exploreCard->place_name.'_indexof_'.rand(1,999999999).$name;
                $file->move('/var/www/html/bfi-api/storage/app/public/images' , $imagename);
                

                $photoInput = array(
                    'place_name' => $validated['place_name'], 
                    'card_image_url' => '/storage/explore/'.$imagename, 
                );
                $exploreCard->update($photoInput);
            }}

        }else{

            if($request->file('image') == null){
                $validator = Validator::make($request->all(), [
                    'place_name' => 'required',
                ]); 
        
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $validated = $validator->validated(); 
                
                    $photoInput = array(
                    
                        'place_name' => $validated['place_name'], 
                        'card_image_url' => $exploreCard->card_image_url, 
                    );
                    $exploreCard->update($photoInput);
                }

               
            }
            
            else{
                $validator = Validator::make($request->all(), [
                    'place_name' => 'required',
                    'image' => 'required'
                ]); 
        
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $validated = $validator->validated();
                $splitUrl = str_split($exploreCard->card_image_url , 9);
                $oldName = '';
                    foreach ($splitUrl as $i => $cut) {
                        if($i > 0){
                            $oldName = $oldName.$cut;
                        }
                    }

                    if(Storage::exists('app/public/'.$oldName)){
                        unlink(storage_path('app/public/'.$oldName));
                        $file = $validated['image'] ;
                        $name=$file->getClientOriginalName();
                        $imagename = $exploreCard->place_name.'_indexof_'.rand(1,999999999).$name;
                        $file->move('/var/www/html/bfi-api/storage/app/public/explore' , $imagename);

                            $photoInput = array(
                                'place_name' => $validated['place_name'], 
                                'card_image_url' => '/storage/explore/'.$imagename, 
                            );
                            $exploreCard->update($photoInput);
                    }else{
                        $file = $validated['image'] ;
                        $name=$file->getClientOriginalName();
                        $imagename = $exploreCard->place_name.'_indexof_'.rand(1,999999999).$name;
                        $file->move('/var/www/html/bfi-api/storage/app/public/explore' , $imagename);
                        
                            $photoInput = array(
                                'place_name' => $validated['place_name'], 
                                'card_image_url' => '/storage/explore/'.$imagename, 
                            );
                            $exploreCard->update($photoInput);
                    }
                    
                    }
                }
        }

        return redirect('/web/explore')->with('message', 'Card Updated Successfully ');

    }

    public function updateClients(Request $request){
        $clientCard = \App\Models\Client_item::find($request->client_id);

            if($request->file('image') == null){

                $validator = Validator::make($request->all(), [
                    'client_name' => 'required',
                ]);
         
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
        
                    
                }
                
                $validated = $validator->validated();

                $photoInput = array(
                    'client_name' => $validated['client_name'], 
                    'icon_image_url' => $clientCard->icon_image_url, 
                );
                $clientCard->update($photoInput);
            }
            
          else{
            $validator = Validator::make($request->all(), [
                'client_name' => 'required',
                'image' => 'required'
            ]); 
     
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $splitUrl = str_split($clientCard->icon_image_url , 9);
                $oldName = '';
                foreach ($splitUrl as $i => $cut) {
                    if($i > 0){
                        $oldName = $oldName.$cut;
                    }
                }

               
                if(Storage::exists('app/public/'.$oldName)){
                    $unlink = unlink(storage_path('app/public/'.$oldName));
                    $validated = $validator->validated();
                    $file = $validated['image'];
                    $name=$file->getClientOriginalName();
                    $imagename = $clientCard->client_name.'_indexof_'.rand(1,999999999).$name;
                    $file->move('/var/www/html/bfi-api/storage/app/public/clients' , $imagename);
                    
                        $photoInput = array(
                            'client_name' => $validated['client_name'], 
                            'icon_image_url' => '/storage/clients/'.$imagename, 
                        );
                        $clientCard->update($photoInput);
                }else{
                    $validated = $validator->validated();
                    $file = $validated['image'];
                    $name=$file->getClientOriginalName();
                    $imagename = $clientCard->client_name.'_indexof_'.rand(1,999999999).$name;
                    $file->move('/var/www/html/bfi-api/storage/app/public/clients' , $imagename);
                    
                        $photoInput = array(
                            'client_name' => $validated['client_name'], 
                            'icon_image_url' => '/storage/clients/'.$imagename, 
                        );
                        $clientCard->update($photoInput);

                };
               
                
            }
            
           
            }
        

        

        return redirect('/web/clients')->with('message', 'client Updated Successfully ');
    }
        
    
    public function addClientView(){
        return view('addnew_Client');
    }

    public function addClient(Request $request){


        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'client_name' => 'required',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

            
        }
        
        $validated = $validator->validated();
        $file = $validated['image'];
        $name=$file->getClientOriginalName();
        $imagename = $validated['client_name'].'_indexof_'.rand(1,999999999).$name;
        $file->move('/var/www/html/bfi-api/storage/app/public/clients' , $imagename);

        $clientData = array(
            'client_name'=>$validated['client_name'],
            'icon_image_url'=> '/storage/clients/'.$imagename
        );
        \App\Models\Client_item::create($clientData);

        return redirect('/web/clients')->with('message', 'Client Added Successfully');

    }

   

}
 
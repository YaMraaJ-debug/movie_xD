<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\ActorDirector;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Str;

class ActorController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct(); 	
        check_verify_purchase();
		  
    }
    public function list()    { 
        
        if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
        {

            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('dashboard');
            
        }

        $page_title=trans('words.actors');
         
        if(isset($_GET['s']))
        {
            $keyword = $_GET['s'];  
            $list = ActorDirector::where("ad_type", "=","actor")->where("ad_name", "LIKE","%$keyword%")->orderBy('id','DESC')->paginate(18);

            $list->appends(\Request::only('s'))->links();
        }
        else
        {
            $list = ActorDirector::where('ad_type','actor')->orderBy('id','DESC')->paginate(18);
        }
 
         
        return view('admin.pages.actors.list',compact('page_title','list'));
    }
    
    public function add()    { 
        
        if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
        {

            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('dashboard');
            
        }

        $page_title=trans('words.add_actor');

        return view('admin.pages.actors.addedit',compact('page_title'));
    }
    
    public function addnew(Request $request)
    { 
        
        $data =  \Request::except(array('_token')) ;
        
        $rule=array(
                'actor_name' => 'required'                
                 );
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
        $inputs = $request->all();
        
        if(!empty($inputs['id'])){
           
            $ad_obj = ActorDirector::findOrFail($inputs['id']);

        }else{

            $ad_obj = new ActorDirector;

        }

         $ad_slug = Str::slug($inputs['actor_name'], '-',null);

         $ad_obj->ad_type = 'actor'; 
         $ad_obj->ad_name = addslashes($inputs['actor_name']); 
         $ad_obj->ad_slug = $ad_slug; 
         
         $ad_obj->ad_bio = addslashes($inputs['ad_bio']); 
         $ad_obj->ad_birthdate = strtotime($inputs['ad_birthdate']); 
         $ad_obj->ad_place_of_birth = addslashes($inputs['ad_place_of_birth']); 

         $ad_obj->ad_image = $inputs['actor_image'];
         
         $ad_obj->save();
         
        
        if(!empty($inputs['id'])){

            \Session::flash('flash_message', trans('words.successfully_updated'));

            return \Redirect::back();
        }else{

            \Session::flash('flash_message', trans('words.added'));

            return \Redirect::back();

        }            
        
         
    }     
   
    
    public function edit($post_id)    
    {     
            if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
            {

                \Session::flash('flash_message', trans('words.access_denied'));

                return redirect('dashboard');
                
            }  

          $page_title=trans('words.edit_actor');

          $post_info = ActorDirector::findOrFail($post_id);   

          return view('admin.pages.actors.addedit',compact('page_title','post_info'));
        
    }	 
    
    public function delete($post_id)
    {
        if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
        {

            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('dashboard');
            
        }

    	if(Auth::User()->usertype=="Admin" OR Auth::User()->usertype=="Sub_Admin")
        {
        	
            $ad_obj = ActorDirector::findOrFail($post_id);
            $ad_obj->delete();

            \Session::flash('flash_message', trans('words.deleted'));

            return redirect()->back();
        }
        else
        {
            \Session::flash('flash_message', trans('words.access_denied'));

            return redirect('admin/dashboard');
            
        
        }
    }
     
     
    	
}

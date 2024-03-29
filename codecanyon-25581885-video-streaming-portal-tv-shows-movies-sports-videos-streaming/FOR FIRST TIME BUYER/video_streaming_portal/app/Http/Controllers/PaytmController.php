<?php

namespace App\Http\Controllers;

use Auth;
use App\User; 
use App\Transactions;
use App\SubscriptionPlan;
use App\Coupons;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image; 

use Session;

require(base_path() . '/public/paytm/PaytmChecksum.php');
 
   
class PaytmController extends Controller
{
	 
    public function paytm_pay()
    {    
        if(!Auth::check() && Session::get('plan_id')=='')
        {

            \Session::flash('error_flash_message', trans('words.access_denied'));

            return redirect()->back();
            
        }   

         $plan_id = Session::get('plan_id');
         $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();

        if(Session::get('coupon_percentage'))
        {   
            //If coupon used
            $discount_price_less =  $plan_info->plan_price * Session::get('coupon_percentage') / 100;

        }
        else
        {
            //If no coupon used
            $discount_price_less = 0;
        }

         return view('pages.payment.paytm_pay',compact('plan_info','discount_price_less'));
  
    }

    public function paytm_success()
    {    
         
        /*echo "ORDERID:".$_POST['ORDERID'];
        echo "<br/>";
        echo "TXNID:".$_POST['TXNID'];
        echo "<br/>";
        echo "TXNAMOUNT:".$_POST['TXNAMOUNT'];
        echo "<br/>";
        echo "BANKTXNID:".$_POST['BANKTXNID'];
        echo "<br/>";
        echo "STATUS:".$_POST['STATUS'];
        echo "<br/>";
        echo "RESPMSG:".$_POST['RESPMSG'];*/

         //print_r($_POST);


        if($_POST['STATUS']=="TXN_SUCCESS")
        {

                $payment_id= $_POST['TXNID'];
                $res_msg= $_POST['RESPMSG'];                            

                $user_id=Auth::user()->id;
                $user_email=Auth::user()->email;           
                $user = User::findOrFail($user_id);

                 $plan_id = Session::get('plan_id');
                 $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();                 
                 $plan_name=$plan_info->plan_name;
                 $plan_days=$plan_info->plan_days;
                 $amount=$plan_info->plan_price;   
                 
                if(Session::get('coupon_percentage'))
                {   
                    //If coupon used
                    $discount_price_less =  $amount * Session::get('coupon_percentage') / 100;

                    $plan_amount=number_format($amount - $discount_price_less,2);

                    $coupon_code= Session::get('coupon_code');
                    $coupon_percentage= Session::get('coupon_percentage');

                    //Update Counpon Used
                    Coupons::where('coupon_code', $coupon_code)->update([
                        'coupon_used'=> DB::raw('coupon_used+1') 
                    ]);

                }
                else
                {
                    //If no coupon used
                    $plan_amount=number_format($amount,2);
                    $coupon_code= NULL;
                    $coupon_percentage= NULL;
                }

                $user->plan_id = $plan_id;                    
                $user->start_date = strtotime(date('m/d/Y'));             
                $user->exp_date = strtotime(date('m/d/Y', strtotime("+$plan_days days")));
                 
                $user->plan_amount = $plan_amount;
                //$user->subscription_status = 0;
                $user->save();

                //Check duplicate
                $trans_info = Transactions::where('user_id',$user_id)->where('payment_id',$payment_id)->first();

                if($trans_info=="")
                {
                    $payment_trans = new Transactions;

                    $payment_trans->user_id = $user_id;
                    $payment_trans->email = $user_email;
                    $payment_trans->plan_id = $plan_id;
                    $payment_trans->gateway = 'Paytm';
                    $payment_trans->payment_amount = $plan_amount;
                    $payment_trans->payment_id = $payment_id;

                    $payment_trans->coupon_code = $coupon_code;
                    $payment_trans->coupon_percentage = $coupon_percentage;

                    $payment_trans->date = strtotime(date('m/d/Y H:i:s'));    
                    $payment_trans->save();

                }

                Session::flash('plan_id',Session::get('plan_id'));
                 
                
                 //Subscription Create Email
                $user_full_name=$user->name;

                $data_email = array(
                    'name' => $user_full_name
                     );    

                 
                try{

                    \Mail::send('emails.subscription_created', $data_email, function($message) use ($user,$user_full_name){
                        $message->to($user->email, $user_full_name)
                            ->from(getcong('site_email'), getcong('site_name')) 
                            ->subject('Subscription Created');
                    });
            
                }catch (\Throwable $e) {
                 
                    \Log::info($e->getMessage());                                 
                }

                Session::flash('coupon_code',Session::get('coupon_code'));
                Session::flash('coupon_percentage',Session::get('coupon_percentage'));

                Session::flash('plan_id',Session::get('plan_id'));

                \Session::flash('success',trans('words.payment_success'));
                return redirect('dashboard'); 

        }
        else
        {   
            Session::flash('coupon_code',Session::get('coupon_code'));
            Session::flash('coupon_percentage',Session::get('coupon_percentage'));

            Session::flash('plan_id',Session::get('plan_id'));

            \Session::flash('error_flash_message',$_POST['RESPMSG']);
            return redirect('dashboard'); 
        }


    }

    
}

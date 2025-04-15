<?php

namespace App\Http\Middleware;
use App\Helpers\CustomHelpers;
use Closure;
use Illuminate\Http\Request;
use Sentinel;
use Session;
use URL;
use DB;
class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise') || Sentinel::getUser()->inRole('waiter') || Sentinel::getUser()->inRole('kitchen')):

             $user=Sentinel::getUser();
         Sentinel::logout($user,true);
         return redirect("/");
        
        else:
           $user_id=Sentinel::getUser()->id;
            $url=\Request::segment(1);
            $role=DB::table('role_users')->where('user_id','=',$user_id)->first();
            $role_id=$role->role_id;
            if($role_id!=1 && $role_id!=2 && $role_id!=12 && $role_id!=17 && $role_id!=18 && $role_id!=19 && $role_id!=20 && $role_id!=21 && $role_id!=27)
            {

              if($url=='foodMenuSales' || $url=='ConsumptionReport' || $url=='POS-Reports' || $url=='DSR-RSC-MTD' || $url=='Food-Menu-Category' || $url=='Food-Menu' || $url=='Outlet-Menu-Price')
              {
               if(CustomHelpers::get_page_access_data($user_id,'billing')==1)
               {
                return $next($request);   
               }
               else
               {
                 $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
               }
              }
              elseif($url=='All-Products-List' || $url=='Firsttime-Stock-List' || $url=='Supply-Item-List')
              {
               if(CustomHelpers::get_page_access_data($user_id,'master_product')==1)
               {
                return $next($request);   
               }
               else
               {
                 $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
               }
              }
              elseif($url=='Brand-List' || $url=='GST-List' || $url=='Unit-List' || $url=='TransportCharge-List' || $url=='Manage-City' || $url=='Warehouse-Setting')
              {
               if(CustomHelpers::get_page_access_data($user_id,'master_product')==1)
               {
                return $next($request);   
               }
               else
               {
                 $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
               }
              }
              else
              {
               return $next($request);   
              }
            }
            else
            {
              return $next($request);  
            }
        
        endif;
    }
}

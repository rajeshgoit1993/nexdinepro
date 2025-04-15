<?php
namespace App\Http\Middleware;
use App\Helpers\CustomHelpers;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Sentinel;
use Session;
use URL;
use Hash;
use DB;

class FanchiseMiddleware
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
        if(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise') || Sentinel::getUser()->inRole('waiter') || Sentinel::getUser()->inRole('kitchen') || Sentinel::getUser()->inRole('cashier')):
            if(Sentinel::getUser()->inRole('cashier')):
            $url=\Request::segment(1);

            if($url=='Fanchise-Stock' || $url=='Supply-List' || $url=='Newly-Order' || $url=='Order-Completed' || $url=='Supply-Order-Payment' || $url=='Franchise-Credit-History' || $url=='Manage-Staff' || $url=='Franchise-Tables' || $url=='Payment-Method' || $url=='Franchise-Food-Menu' || $url=='Kitchen' || $url=='Waiter' || $url=='foodMenuSales' || $url=='DSR-MTD' || $url=='DSR-RSC-MTD'):
            
                 $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
                else:
                 return $next($request);   
            endif;
            
            elseif(Sentinel::getUser()->inRole('waiter')):
                $url=\Request::segment(1);
            if($url=='Waiter')
            {
                return $next($request);
            }
            else
            {
                $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
            }
            elseif(Sentinel::getUser()->inRole('kitchen')):
                $url=\Request::segment(1);
            if($url=='Kitchen')
            {
                return $next($request);
            }
            else
            {
                $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
            }
            else:
                 return $next($request);
            endif;
        
        else:
          $user=Sentinel::getUser();
         Sentinel::logout($user,true);
         return redirect("/");
        endif;
        
    }
}

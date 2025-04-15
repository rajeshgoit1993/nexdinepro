<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  use Carbon\CarbonPeriod;
class BirthdayNotification extends Model
{
    use HasFactory;

    public function scopeBirthdayBetween($query, $dateBegin, $dateEnd)
    {
        $monthBegin = explode('-', $dateBegin)[0];
        $dayBegin = explode('-', $dateBegin)[1];
        $monthEnd = explode('-', $dateEnd)[0];
        $dayEnd = explode('-', $dateEnd)[1];
        $currentYear = date('Y');

        $period = CarbonPeriod::create("$currentYear-$monthBegin-$dayBegin", "$currentYear-$monthEnd-$dayEnd");

        foreach ($period as $key => $date) {
            $queryFn = function($query) use ($date) {
                $query->whereMonth("dob", '=', $date->format('m'))->whereDay("dob", '=', $date->format('d'));
            };

            if($key === 0) {
                $queryFn($query);
            } else {
                $query->orWhere(function($q) use ($queryFn) {
                    $queryFn($q);
                });
            }
        }

        return $query;
    }

}

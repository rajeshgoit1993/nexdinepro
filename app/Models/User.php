<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
  use Carbon\CarbonPeriod;
  
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
                $query->whereMonth("birthday", '=', $date->format('m'))->whereDay("birthday", '=', $date->format('d'));
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

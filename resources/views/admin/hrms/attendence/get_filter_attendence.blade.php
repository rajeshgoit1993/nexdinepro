 <thead>
                                <tr>
                                    <th style="min-width: 70px;position: sticky;left: 0px;background: white;">SL No.</th>
                                  
                                    <th style="position: sticky;left: 70px;background: white;">Employee</th>
                                  
                                  @for ($i = 1; $i <= $num_of_days; $i++)
                                      <th>{{$i}}</th>
                                  @endfor 
                                </tr>
                            </thead>
                            <tbody >
                            
                               <?php 
$s=1;
                               ?>


                                    @foreach ($user_login_data as $row=>$col)
                                    <?php 
                                 $user_id=$row;
                   $user=DB::table('users')->where('id',$user_id)->first();                
                                    ?>
                                       
                                        <tr>
                                            <td style="position: sticky;left: 0px;background: white;">{{$s++}}</td>
                                            <td style="position: sticky;left: 70px;background: white;">{{$user->name}}</td>
                            @for ($i = 1; $i <= $num_of_days; $i++)
                            <?php 
                            $num_days=sprintf('%02d', $i);
$date_print=date("$full_year-$month-$num_days");
$day=date("l",strtotime($date_print));
$day_check=DB::table('weekoffs')->where('week_day',$day)->first();
$holidays_check=DB::table('holidays')->where('date',$date_print)->first();

$login_datas=DB::table('user_logins')->where('user_id',$user_id)->whereDate('login_date','=',$date_print)->get();



$user_data_extra=DB::table('user_extra_details')->where('store_id',$user_id)->first(); 
     $shift_data=DB::table('h_r_m_s_shifts')->where('id',$user_data_extra->shift_id)->first(); 
    $time=0;
    $first_login=0;
foreach($login_datas as $login_data)
{
$start_time=strtotime($shift_data->login_time)-(int)$shift_data->login_variance*60;
$end_time=strtotime($shift_data->logout_time)+(int)$shift_data->login_variance*60;
if(strtotime($login_data->login_time)>=$start_time && strtotime($login_data->logout_time)<=$end_time)
{
$loginTime = strtotime($login_data->login_time);
if($login_data->logout_time!='')
{
$logoutTime = strtotime($login_data->logout_time);
$diff_time = (float)$logoutTime - (float)$loginTime;
  
$time=(float)$time+(float)$diff_time;    
}
if($login_data->login_date==date('Y-m-d'))
{
  $first_login=$login_data->login_time;  
}

}


}
$total_login_time=gmdate("H:i:s", $time);

$user_attendence_picture_data=DB::table('user_attendence_pictures')->where('user_id',$user_id)->whereDate('login_date',$date_print)->first();




                            ?>

@if($day_check!='')
<td class="text-danger">{{$day}}</td>

@elseif($holidays_check!='' && $holidays_check->holiday_type!=4 && $holidays_check->holiday_type!=5)
<?php 
$holidays_type=$holidays_check->holiday_type;
?>
@if($holidays_type==1 || $holidays_type==3)
 <td class="text-primary">{{$holidays_check->holiday}}
                                          </td>
@elseif($holidays_type==2)
<?php 
$check_optional_holidays=DB::table('choose_optional_holidays')->where([['user_id',$user_id],['year',$full_year]])->first();
?>
@if($check_optional_holidays!='' && $check_optional_holidays->holiday_id==$holidays_check->id)
<td class="text-primary">{{$holidays_check->holiday}}
                                          </td>
@else

@if($user_attendence_picture_data!='')
 @if($user_attendence_picture_data->status==2)
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-success">Full</td>
 @elseif($user_attendence_picture_data->status==3)
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>
 @elseif($user_attendence_picture_data->status==4)
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>
 @elseif($user_attendence_picture_data->mrg_time!='' && $user_attendence_picture_data->lunch_time!='' && $user_attendence_picture_data->evening_time!='' )
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-success">Full</td>
 @elseif($user_attendence_picture_data->mrg_time!='' && $user_attendence_picture_data->lunch_time!='' )
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>
 @elseif($user_attendence_picture_data->lunch_time!='' && $user_attendence_picture_data->evening_time!='' )<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>

 @elseif($user_attendence_picture_data->mrg_time!=''  && $user_attendence_picture_data->evening_time!='' )
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>
 @else
<td id="1"  class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-d text-danger"> A</td>
 @endif

@else
<td id="1"  class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-d text-danger"> A</td>
@endif


@endif
@endif

@elseif($date_print>date('Y-m-d'))
 <td><i class="fa fa-times text-danger"></td>

@elseif($date_print==date('Y-m-d'))
  @if($first_login==0)
<td><i class="fa fa-times text-danger">A</td>
@else
<td class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-success">P {{$first_login}}</td>
@endif


@else

@if($user_attendence_picture_data!='')
 @if($user_attendence_picture_data->status==2)
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-success">Full</td>
 @elseif($user_attendence_picture_data->status==3)
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>
 @elseif($user_attendence_picture_data->status==4)
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>
 @elseif($user_attendence_picture_data->mrg_time!='' && $user_attendence_picture_data->lunch_time!='' && $user_attendence_picture_data->evening_time!='' )
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-success">Full</td>
 @elseif($user_attendence_picture_data->mrg_time!='' && $user_attendence_picture_data->lunch_time!='' )
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>
 @elseif($user_attendence_picture_data->lunch_time!='' && $user_attendence_picture_data->evening_time!='' )<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>

 @elseif($user_attendence_picture_data->mrg_time!=''  && $user_attendence_picture_data->evening_time!='' )
<td id="1" class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-check text-info">H/L</td>
 @else
<td id="1"  class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-d text-danger"> A</td>
 @endif

@else
<td id="1"  class="date_info" user_id="{{$user_id}}" date="{{$date_print}}"><i class="fa fa-d text-danger"> A</td>


@endif
@endif


                                               
                                          
                                                  
    
                                              
                                                
                                            @endfor
                                           
                                        </tr>

                                    @endforeach
                            </tbody>
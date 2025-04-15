


<!-- Modal content-->


<div class="modal-body">
<table class="table table-bordered">
    
 <thead>
                                <tr>
                                    <th>Morning</th>
                                  
                                    <th>Lunch</th>

                                    <th>Evening</th>
<th>Status</th>
                                    <th>Action </th>

                                  
                                    

                               
                                </tr>
                            </thead>

                            <tbody>
                               
                                   
                                  
                                     <tr>
                                    <td>
                                  @if($user_attendence_picture_data!='')
                                  @if($user_attendence_picture_data->mrg_photo!='')
 <img src="{{url('/public/uploads/attendence_picture/'.$user_attendence_picture_data->mrg_photo)}}" width="150px">
                                  @endif
                              <p>  Login Time: {{$user_attendence_picture_data->mrg_time}} </p>
                                  @else
NA
                                  @endif      

                                    </td>
                                   
                                    <td>
                                         @if($user_attendence_picture_data!='')
                                  @if($user_attendence_picture_data->lunch_photo!='')
 <img src="{{url('/public/uploads/attendence_picture/'.$user_attendence_picture_data->lunch_photo)}}" width="150px"> 
                                  @endif
                               <p> Login Time: {{$user_attendence_picture_data->lunch_time}}</p>
                                  @else
NA
                                  @endif 

                                    </td>
                                     <td>
                                         @if($user_attendence_picture_data!='')
                                  @if($user_attendence_picture_data->evening_photo!='')
 <img src="{{url('/public/uploads/attendence_picture/'.$user_attendence_picture_data->evening_photo)}}" width="150px">
                                  @endif
                              <p>  Login Time: {{$user_attendence_picture_data->evening_time}}</p>
                                  @else
NA
                                  @endif 

                                    </td>
<td>
    @if($user_attendence_picture_data!='')
    @if($user_attendence_picture_data->status==2)
Full Day
 @elseif($user_attendence_picture_data->status==3)
HalfDay
 @elseif($user_attendence_picture_data->status==4)
HalfDay
 @elseif($user_attendence_picture_data->mrg_time!='' && $user_attendence_picture_data->lunch_time!='' && $user_attendence_picture_data->evening_time!='' )
Full Day
 @elseif($user_attendence_picture_data->mrg_time!='' && $user_attendence_picture_data->lunch_time!='' )
HalfDay
 @elseif($user_attendence_picture_data->lunch_time!='' && $user_attendence_picture_data->evening_time!='' )HalfDay

 @elseif($user_attendence_picture_data->mrg_time!=''  && $user_attendence_picture_data->evening_time!='' )
HalfDay
 @else
Absent
 @endif
    @endif 
</td>
                                   <td>
                                       
{!! Form::open(["files"=>true,'id'=>'store_admin_attendence'])!!}
<input type="hidden" name="user_id" value="{{$user_id}}">
<input type="hidden" name="date" value="{{$date}}">


<div class="form-group">
<label for="" class="required">Select & Submit</label>
<select class="form-control" name="status" required>   
 <option value="">--Select & Submit--</option>
 <option value="2">Full Day</option>
 <option value="3">Mrg to Lunch Half Day</option>
 <option value="4">Lunch to Evening Half Day</option>
 
</select>
</div>





{!! Form::submit('Save',["class"=>"btn btn-success"]) !!}




{!! Form::close() !!}
                                   </td>
                                   
                                    </tr>
                                   
                                

                            </tbody>

</table>



<table class="table table-bordered">
    <h3>Login History</h3>
 <thead>
                                <tr>
                                    <th>SL No.</th>
                                  
                                    <th>Login Time</th>

                                   <!--  <th>Login Accuracy </th>

                                    <th>Login Distance From Office </th>

                                    <th>Login Location </th> -->

                                    <th>Logout Time</th>

                                   <!--  <th>Logout Accuracy </th>

                                    <th>Logout Distance From Office </th> -->

                                    

                               
                                </tr>
                            </thead>
 <?php
                                    $s=1; 
                                    ?>
                            <tbody>
                               
                                   
                                    @foreach($login_datas as $login_data)
                                     <tr>
                                    <td>{{$s++}}</td>
                                    <td>{{$login_data->login_time}}</td>
                                   <!--  <td>{{round($login_data->login_accuracy,2)}} Meters</td>
                                    <td>{{$login_data->login_distance_office}} Meters</td>
                                    <td>{{$login_data->login_location}}</td> -->
                                    <td>{{$login_data->logout_time}}</td>
                                   <!--  <td>{{round($login_data->logout_accuracy,2)}} Meters</td>
                                    <td>{{$login_data->logout_distance_office}} Meters</td> -->
                                   
                                    </tr>
                                    @endforeach
                                

                            </tbody>

</table>





</div>



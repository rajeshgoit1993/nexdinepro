 
 @if($request_segment=='Edit-User' || $request_segment=='Edit-Store' || $request_segment=='Edit-Vendor' || $request_segment=='Edit-Factory' || $request_segment=='Edit-Staff')
 <input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($uers_data->id)}}">
<div class="tab-pane active" id="login_details">
      <div class="panel panel-default">
       <div class="panel-heading">Basic Details</div>
       <div class="panel-body">
     <div class="row">
             <div class="col-md-6">
      
   <div class="form-group">
<label for="package">User Role</label>

<select class="form-control" name="user_role" id="user_role">
      <option value="">--Select Role--</option>
  @foreach($all_roles as $role)
<option value="{{$role->slug}}" @foreach($user_roles as $user_role) @if($user_role->role_id==$role->id) selected="selected" @endif @endforeach>{{$role->name}}</option>
  @endforeach
</select>
  <span id="error_user_role" class="text-danger"></span>
</div>
    </div> 

     <div class="col-lg-6">
          <div class="form-group">
     <label>User ID</label>
     <input type="text" name="email" id="email" class="form-control"  placeholder="Enter Email ID" value="{{$uers_data->email}}" />
     <span id="error_email" class="text-danger"></span>
        </div> 
     </div>
     <div class="col-lg-6">
          <div class="form-group">
     <label>Name</label>
     <input type="text" name="name" id="name" class="form-control" placeholder="Enter User ID"  value="{{$uers_data->name}}" />
     <span id="error_name" class="text-danger"></span>
        </div> 
     </div>
@if($request_segment=='Edit-User' || $request_segment=='Add-Manage-Multi-Dept-Employee')
<?php
$extra_details=DB::table('user_extra_details')->where('store_id','=',$uers_data->id)->first();
?>


       <div class="col-lg-6">
          <div class="form-group">
     <label>Designation</label>
     <select class="form-control" name="designation">
       <option value="">--Select One--</option>
         @foreach($designation as $des)
<option value="{{$des->id}}" @if($extra_details!='' && $extra_details->designation==$des->id) selected @endif>{{$des->designation}}</option>
       @endforeach

      <!--  <option value="CEO" @if($extra_details!='' && $extra_details->designation=='CEO') selected @endif>CEO</option>
       <option value="Business Head" @if($extra_details!='' && $extra_details->designation=='Business Head') selected @endif>Business Head</option>
       <option value="Sales Head" @if($extra_details!='' && $extra_details->designation=='Sales Head') selected @endif>Sales Head</option>
       <option value="Ops Head" @if($extra_details!='' && $extra_details->designation=='Ops Head') selected @endif>Ops Head</option>
       <option value="Project mgr" @if($extra_details!='' && $extra_details->designation=='Project mgr') selected @endif>Project mgr</option>
       <option value="Marketing manager" @if($extra_details!='' && $extra_details->designation=='Marketing manager') selected @endif>Marketing manager</option>
       <option value="Sales manager" @if($extra_details!='' && $extra_details->designation=='Sales manager') selected @endif>Sales manager</option>
       <option value="Sales executive" @if($extra_details!='' && $extra_details->designation=='Sales executive') selected @endif>Sales executive</option>
       <option value="Ops Asst manager" @if($extra_details!='' && $extra_details->designation=='Ops Asst manager') selected @endif>Ops Asst manager</option>
       <option value="Area manager" @if($extra_details!='' && $extra_details->designation=='Area manager') selected @endif>Area manager</option>
       <option value="Training Chef" @if($extra_details!='' && $extra_details->designation=='Training Chef') selected @endif>Training Chef</option>
       <option value="Digital Mkt manager" @if($extra_details!='' && $extra_details->designation=='Digital Mkt manager') selected @endif>Digital Mkt manager</option>
       <option value="Graphic Designer" @if($extra_details!='' && $extra_details->designation=='Graphic Designer') selected @endif>Graphic Designer</option>
       <option value="MIS" @if($extra_details!='' && $extra_details->designation=='MIS') selected @endif>MIS</option>
       <option value="Pre Launch" @if($extra_details!='' && $extra_details->designation=='Pre Launch') selected @endif>Pre Launch </option>
       <option value="Account mgr" @if($extra_details!='' && $extra_details->designation=='Account mgr') selected @endif>Account mgr</option>
       <option value="Office boy" @if($extra_details!='' && $extra_details->designation=='Office boy') selected @endif>Office boy</option> -->
     </select>
     
        </div> 
     </div>
    @if($request_segment=='Edit-User')
<div class="col-md-6">
  
<div class="form-group">
<label for="password">Password</label>
<input type="password" name="password" placeholder="Password" class="form-control" >
<span class="text-danger">{{ $errors->first('password') }}</span>  
</div>    
    </div>
    <div class="col-md-6">
  
<div class="form-group">
<label for="password_confirmation">Confirm Password</label>
<input type="password" name="password_confirmation"  placeholder="Password Confirmation" class="form-control" >
<span class="text-danger">{{ $errors->first('password_confirmation') }}</span>  
</div>    
    </div>

<div class="col-lg-6">
          <div class="form-group">
     <label>Shift</label>
     <select class="form-control" required name="shift_id">
       <option value="">--Select Shift--</option>
       @foreach($shifts as $shift)
       <option value="{{$shift->id}}" @if($extra_details!='' && $extra_details->shift_id==$shift->id) selected @endif>{{$shift->shift_name}}</option>
       @endforeach
      
     </select>
     
        </div> 
     </div>

     <div class="col-lg-6">
          <div class="form-group">
     <label>Office Location</label>
     <select class="form-control" name="office_location_id">
       <option value="">--Select Office Location--</option>
      @foreach($ofce_locations as $ofce_location)
       <option value="{{$ofce_location->id}}"@if($extra_details!='' && $extra_details->shift_id==$ofce_location->id) selected @endif>{{$ofce_location->location}}</option>
       @endforeach
      
     </select>
     
        </div> 
     </div>

@endif
      <div class="col-lg-6">
          <div class="form-group">
     <label>Level</label>
     <select class="form-control" name="userlevel">
       <option value="">--Select One--</option>
       <option value="L1" @if($extra_details!='' && $extra_details->userlevel=='L1') selected @endif>L1</option>
       <option value="L2" @if($extra_details!='' && $extra_details->userlevel=='L2') selected @endif>L2</option>
       <option value="L3" @if($extra_details!='' && $extra_details->userlevel=='L3') selected @endif>L3</option>
       <option value="L4" @if($extra_details!='' && $extra_details->userlevel=='L4') selected @endif>L4</option>
       <option value="L5" @if($extra_details!='' && $extra_details->userlevel=='L5') selected @endif>L5</option>
       <option value="L6" @if($extra_details!='' && $extra_details->userlevel=='L6') selected @endif>L6</option>
      
     </select>
     
        </div> 
     </div>
    
    <div class="col-lg-6">
          <div class="form-group">
     <label>Reporting manager</label>
     <select class="form-control" name="reporting_manager">
       <option value="">--Select One--</option>
        @foreach($designation as $des)
<option value="{{$des->id}}" @if($extra_details!='' && $extra_details->reporting_manager==$des->id) selected @endif>{{$des->designation}}</option>
       @endforeach

       <!--  <option value="Board of directors" @if($extra_details!='' && $extra_details->reporting_manager=='Board of directors') selected @endif>Board of directors</option>
       <option value="CEO" @if($extra_details!='' && $extra_details->reporting_manager=='CEO') selected @endif>CEO</option>
       <option value="Business Head" @if($extra_details!='' && $extra_details->reporting_manager=='Business Head') selected @endif>Business Head</option>
       <option value="Sales Head" @if($extra_details!='' && $extra_details->reporting_manager=='Sales Head') selected @endif>Sales Head</option>
        <option value="Sales manager" @if($extra_details!='' && $extra_details->reporting_manager=='Sales manager') selected @endif>Sales manager</option>
       <option value="Sales Team leader" @if($extra_details!='' && $extra_details->reporting_manager=='Sales Team leader') selected @endif>Sales Team leader</option>
        <option value="Sales manager+Ops Head" @if($extra_details!='' && $extra_details->reporting_manager=='Sales manager+Ops Head') selected @endif>Sales manager+Ops Head</option>
        <option value="Ops Head" @if($extra_details!='' && $extra_details->reporting_manager=='Ops Head') selected @endif>Ops Head</option>
       
       <option value="Marketing manager" @if($extra_details!='' && $extra_details->reporting_manager=='Marketing manager') selected @endif>Marketing manager</option>
       <option value="Digital Mkt" @if($extra_details!='' && $extra_details->reporting_manager=='Digital Mkt') selected @endif>Digital Mkt</option>
      <option value="Project mgr" @if($extra_details!='' && $extra_details->reporting_manager=='Project mgr') selected @endif>Project mgr</option> -->
       
    
     </select>
     
        </div> 
     </div>

      <div class="col-lg-6">
          <div class="form-group">
     <label>Department</label>
     <select class="form-control" name="department">
       <option value="">--Select One--</option>
         @foreach($department as $d)
<option value="{{$d->id}}"  @if($extra_details!='' && $extra_details->department==$d->id) selected @endif>{{$d->department}}</option>
       @endforeach

        <!-- <option value="Leadership Team" @if($extra_details!='' && $extra_details->department=='Leadership Team') selected @endif>Leadership Team</option>
       <option value="Sales" @if($extra_details!='' && $extra_details->department=='Sales') selected @endif>Sales</option>
       <option value="KN & LT-Sales" @if($extra_details!='' && $extra_details->department=='KN & LT-Sales') selected @endif>KN & LT-Sales</option>
       <option value="SH-Sales" @if($extra_details!='' && $extra_details->department=='SH-Sales') selected @endif>SH-Sales</option>
        <option value="SH -Ops" @if($extra_details!='' && $extra_details->department=='SH -Ops') selected @endif>SH -Ops</option>
       <option value="Ops" @if($extra_details!='' && $extra_details->department=='Ops') selected @endif>Ops</option>
        <option value="Marketing" @if($extra_details!='' && $extra_details->department=='Marketing') selected @endif>Marketing</option>
        <option value="Projects" @if($extra_details!='' && $extra_details->department=='Projects') selected @endif>Projects</option>
        -->
      
       
    
     </select>
     
        </div> 
     </div>
@endif
       <div class="col-lg-6">
          <div class="form-group">
     <label>Mobile No</label>
     <input type="text" value="{{$uers_data->mobile}}"  name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile No"  />
     <span id="error_mobile" class="text-danger"></span>
        </div> 
     </div>
       
     <div class="col-lg-6">
          <div class="form-group">
     <label>DOB</label>
     <input type="date" value="{{$uers_data->birthday}}" name="birthday" id="birthday" class="form-control" placeholder="Enter DOB" />
     <span id="error_birthday" class="text-danger"></span>
        </div> 
     </div> 
       <div class="col-lg-6">
          
          <div class="form-group">
     <label>State</label>
     <select name="state" id="state" class="form-control">
     <option value="">--Select State--</option>
     @foreach($states as $state)
     <option value="{{ $state->state_title }}" state_id="{{ $state->id }}" @if($state->state_title==$uers_data->state) selected @endif>{{ $state->state_title }}</option>
     @endforeach
     </select >

     <span id="error_state" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
        <?php 
         $state_id=DB::table('states')->where('state_title','=',$uers_data->state)->first();
        
         $districts=DB::table('districts')->where('state_id','=',$state_id->id)->get();
         $dist_id=DB::table('districts')->where('district_title','=',$uers_data->dist)->first();
         $cities=DB::table('cities')->where('districtid','=',$dist_id->id)->get();
        
         ?>
          <div class="form-group">
     <label>District</label>
     <select name="dist" id="dist" class="form-control">
     <option value="">--Select District--</option>
    @foreach($districts as $district)
<option value="{{$district->district_title}}" @if($district->district_title==$uers_data->dist) selected @endif dist_id="{{$district->id}}">{{$district->district_title}}</option>
    @endforeach
     </select >

     <span id="error_dist" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>City</label>
     <select name="city" id="city" class="form-control">
     <option value="">--Select City--</option>
    @foreach($cities as $city)
   <option value="{{$city->name}}" @if($city->name==$uers_data->city) selected @endif>{{$city->name}}</option>
    @endforeach
     </select >

     <span id="error_city" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-12">
          <div class="form-group">
     <label>Address</label>
     <textarea name="address" id="address" class="form-control">{{$uers_data->address}}</textarea>
     
     <span id="error_address" class="text-danger"></span>
        </div> 
     </div>
     </div>


        <br />

<!---->

        <div align="center">
         <button type="button" name="btn_login_details" id="btn_login_updates" class="btn btn-info btn-lg">Update</button>
        </div>
        <br />
       </div>
      </div>
     </div>
 @else
<div class="tab-pane active" id="login_details">
      <div class="panel panel-default">
       <div class="panel-heading">Basic Details</div>
       <div class="panel-body">
     <div class="row">
             <div class="col-md-6">
      
   <div class="form-group">
<label for="package">User Role</label>

<select class="form-control" name="user_role" id="user_role">
      <option value="">--Select Role--</option>
  @foreach($all_roles as $role)
<option value="{{$role->slug}}">{{$role->name}}</option>
  @endforeach
</select>
  <span id="error_user_role" class="text-danger"></span>
</div>
    </div> 

     <div class="col-lg-6">
          <div class="form-group">
     <label>User ID</label>
     <input type="text" name="email" id="email" class="form-control"  placeholder="Enter Email ID" />
     <span id="error_email" class="text-danger"></span>
        </div> 
     </div>
     <div class="col-lg-6">
          <div class="form-group">
     <label>Name</label>
     <input type="text" name="name" id="name" class="form-control" placeholder="Enter User ID" />
     <span id="error_name" class="text-danger"></span>
        </div> 
     </div>
@if($request_segment=='Edit-User' || $request_segment=='Add-Manage-Multi-Dept-Employee')
       <div class="col-lg-6">
          <div class="form-group">
     <label>Designation</label>
     <select class="form-control" name="designation">
       <option value="">--Select One--</option>
       @foreach($designation as $des)
<option value="{{$des->id}}">{{$des->designation}}</option>
       @endforeach
     <!--   <option value="CEO">CEO</option>
       <option value="Business Head">Business Head</option>
       <option value="Sales Head">Sales Head</option>
       <option value="Ops Head">Ops Head</option>
       <option value="Project mgr">Project mgr</option>
       <option value="Marketing manager">Marketing manager</option>
       <option value="Sales manager">Sales manager</option>
       <option value="Sales executive">Sales executive</option>
       <option value="Ops Asst manager">Ops Asst manager</option>
       <option value="Area manager">Area manager</option>
       <option value="Training Chef">Training Chef</option>
       <option value="Digital Mkt manager">Digital Mkt manager</option>
       <option value="Graphic Designer">Graphic Designer</option>
       <option value="MIS">MIS</option>
       <option value="Pre Launch">Pre Launch </option>
       <option value="Account mgr">Account mgr</option>
       <option value="Office boy">Office boy</option> -->
     </select>
     
        </div> 
     </div>
    
    
    <div class="col-lg-6">
          <div class="form-group">
     <label>Shift</label>
     <select class="form-control" required name="shift_id">
     
       @foreach($shifts as $shift)
       <option value="{{$shift->id}}" >{{$shift->shift_name}}</option>
       @endforeach
      
     </select>
     
        </div> 
     </div>

     <div class="col-lg-6">
          <div class="form-group">
     <label>Office Location</label>
     <select class="form-control" name="office_location_id">
    
      @foreach($ofce_locations as $ofce_location)
       <option value="{{$ofce_location->id}}">{{$ofce_location->location}}</option>
       @endforeach
      
     </select>
     
        </div> 
     </div>

       <div class="col-lg-6">
          <div class="form-group">
     <label>Level</label>
     <select class="form-control" name="userlevel">
       <option value="">--Select One--</option>
       <option value="L1">L1</option>
       <option value="L2">L2</option>
       <option value="L3">L3</option>
       <option value="L4">L4</option>
       <option value="L5">L5</option>
       <option value="L6">L6</option>
      
     </select>
     
        </div> 
     </div>

     
    <div class="col-lg-6">
          <div class="form-group">
     <label>Reporting manager</label>
     <select class="form-control" name="reporting_manager">
       <option value="">--Select One--</option>
            @foreach($designation as $des)
<option value="{{$des->id}}">{{$des->designation}}</option>
       @endforeach
      <!--   <option value="Board of directors">Board of directors</option>
       <option value="CEO">CEO</option>
       <option value="Business Head">Business Head</option>
       <option value="Sales Head">Sales Head</option>
        <option value="Sales manager">Sales manager</option>
       <option value="Sales Team leader">Sales Team leader</option>
        <option value="Sales manager+Ops Head">Sales manager+Ops Head</option>
        <option value="Ops Head">Ops Head</option>
       
       <option value="Marketing manager">Marketing manager</option>
       <option value="Digital Mkt">Digital Mkt</option>
      <option value="Project mgr">Project mgr</option> -->
       
    
     </select>
     
        </div> 
     </div>

      <div class="col-lg-6">
          <div class="form-group">
     <label>Department</label>
     <select class="form-control" name="department">
       <option value="">--Select One--</option>
             @foreach($department as $d)
<option value="{{$d->id}}">{{$d->department}}</option>
       @endforeach
      <!--   <option value="Leadership Team">Leadership Team</option>
       <option value="Sales">Sales</option>
       <option value="KN & LT-Sales">KN & LT-Sales</option>
       <option value="SH-Sales">SH-Sales</option>
        <option value="SH -Ops">SH -Ops</option>
       <option value="Ops">Ops</option>
        <option value="Marketing">Marketing</option>
        <option value="Projects">Projects</option> -->
       
      
       
    
     </select>
     
        </div> 
     </div>
@endif


       <div class="col-lg-6">
          <div class="form-group">
     <label>Mobile No</label>
     <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile No"  />
     <span id="error_mobile" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>DOB</label>
     <input type="date" name="birthday" id="birthday" class="form-control" placeholder="Enter DOB" />
     <span id="error_birthday" class="text-danger"></span>
        </div> 
     </div> 
       <div class="col-lg-6">
          
          <div class="form-group">
     <label>State</label>
     <select name="state" id="state" class="form-control">
     <option value="">--Select State--</option>
     @foreach($states as $state)
     <option value="{{ $state->state_title }}" state_id="{{ $state->id }}">{{ $state->state_title }}</option>
     @endforeach
     </select >

     <span id="error_state" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>District</label>
     <select name="dist" id="dist" class="form-control">
     <option value="">--Select District--</option>
   
     </select >

     <span id="error_dist" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>City</label>
     <select name="city" id="city" class="form-control">
     <option value="">--Select City--</option>
   
     </select >

     <span id="error_city" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-12">
          <div class="form-group">
     <label>Address</label>
     <textarea name="address" id="address" class="form-control"></textarea>
     
     <span id="error_address" class="text-danger"></span>
        </div> 
     </div>
     </div>


        <br />

<!---->

        <div align="center">
         <button type="button" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Save</button>
        </div>
        <br />
       </div>
      </div>
     </div>
 @endif


 
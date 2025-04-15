<div class="row">
             <div class="col-md-6">
      
   <div class="form-group">
<label for="package">Fanchise Type</label>

<select class="form-control" name="user_role" id="user_role">
      <option value="">--Select Role--</option>
  @foreach($all_roles as $role)
<option value="{{$role->slug}}" @foreach($user_roles as $user_role) @if($user_role->role_id==$role->id) selected="selected" @endif @endforeach>{{$role->name}}</option>
  @endforeach
</select>
  <span id="error_user_role" class="text-danger"></span>
</div>
    </div> 
  
  <?php  
$email=CustomHelpers::partiallyHideEmail($uers_data->email);
$mobile=CustomHelpers::mask_mobile_no($uers_data->mobile);  
$official_email=CustomHelpers::partiallyHideEmail($uers_data->user_id);
$address=CustomHelpers::partiallyaddress($uers_data->address);
  ?>
     <div class="col-lg-6">
          <div class="form-group">
     <label>User ID <span style="font-size: 10px;">(Personal Email ID)</span></label>
     <input type="text" name="email" value="{{$email}}" id="user_id" class="form-control"  placeholder="Enter Email ID" />
     <span id="error_user_id" class="text-danger"></span>
        </div> 
     </div>
     
      <div class="col-lg-6">
          <div class="form-group">
     <label>Official Email ID</label>
     <input type="text" name="user_id" id="email" class="form-control" value="{{$official_email}}" placeholder="Enter Official Email ID" />
     <span id="error_email" class="text-danger"></span>
        </div> 
     </div>


     <div class="col-lg-6">
          <div class="form-group">
     <label>Name</label>
     <input type="text" name="name" value="{{$uers_data->name}}" id="name" class="form-control" placeholder="Enter User ID" />
     <span id="error_name" class="text-danger"></span>
        </div> 
     </div>

       <div class="col-lg-6">
          <div class="form-group">
     <label>Mobile No</label>
     <input type="text" name="mobile" value="{{$mobile}}" id="mobile" class="form-control" placeholder="Enter Mobile No"  />
     <span id="error_mobile" class="text-danger"></span>
        </div> 
     </div>
       
   <div class="col-lg-6">
          <div class="form-group">
     <label>DOB</label>
     <input type="date" name="birthday" value="{{$uers_data->birthday}}"  id="birthday" class="form-control" placeholder="Enter DOB" />
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
     <?php 
         $state_id=DB::table('states')->where('state_title','=',$uers_data->state)->first();
        
         $districts=DB::table('districts')->where('state_id','=',$state_id->id)->get();
         $dist_id=DB::table('districts')->where('district_title','=',$uers_data->dist)->first();
         $cities=DB::table('cities')->where('districtid','=',$dist_id->id)->get();
        
         ?>
      <div class="col-lg-6">
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
       <div class="col-lg-6 ">
          <div class="form-group fanchise_list">
     <label>Fanchises List</label>
     <select name="fanchise_list" id="fanchise_list" class="form-control ">
     <option value="">--Select Fanchise--</option>
   
     </select >

     <span id="error_city" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-12">
          <div class="form-group">
     <label>Address</label>
     <textarea name="address" id="address" class="form-control">{{$address}}</textarea>
     
     <span id="error_address" class="text-danger"></span>
        </div> 
     </div>
     </div>


       <!---->
<h4>For POS</h4>
<div class="row">

   <div class="col-lg-6">
          <div class="form-group">
     <label>Firm's Registered name</label>
    <input type="text" name="firm_name" id="firm_name" class="form-control" placeholder="Firm's Registered name"  value="{{$booking_data->firm_name}}" />

     <span id="error_firm_name" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-6 ">
          <div class="form-group">
     <label>GST Number</label>
    <input value="{{$booking_data->gst_number}}" type="text" name="gst" id="gst" class="form-control" placeholder="Enter GST"  />

     <span id="error_gst" class="text-danger"></span>
        </div> 
     </div>
       <div class="col-lg-12">
          <div class="form-group">
     <label>Outlet Address</label>
     <textarea name="outlet_address" id="outlet_address" class="form-control">{{$booking_data->outlet_address}}</textarea>
     
     <span id="error_outlet_address" class="text-danger"></span>
        </div> 
     </div>

</div>
<!---->
<h4>Franchise Fee</h4>

   <div class="row">
   <div class="col-lg-6">
       <label>Subscription Type</label>
   <select class="form-control royality" name="subscription_type" id="subscription_type" style="">

<option value="1" @if($booking_data->subscription_type==1) selected @endif>Monthly</option>
<option value="2" @if($booking_data->subscription_type==2) selected @endif>Yearly</option>
</select>
 <span id="error_subscription_type" class="text-danger"></span>
<!-- <input type="text" class="form-control number_test royality_percentage number_test" name="royality_percentage" placeholder="Enter Royality Percentage"  style="padding: 5px;color: #4a4a4a;min-width: 60px;"> -->
</div>
<div class="col-lg-6">
 <div class="form-group">
         <label>Subscription Value</label>
         <input value="{{$booking_data->subscription_value}}" type="text" name="subscription_value" id="subscription_value" class="form-control number_test subscription_value"  />
         <span id="error_subscription_value" class="text-danger"></span>
        </div>
</div>
   </div>
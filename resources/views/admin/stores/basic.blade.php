 
 @if($request_segment=='Edit-Warehouse')
 <input type="hidden" name="id" value="{{CustomHelpers::custom_encrypt($data->id)}}">
<div class="tab-pane active" id="login_details">
      <div class="panel panel-default">
       <div class="panel-heading">Basic Details</div>
       <div class="panel-body">
     <div class="row">
             
     <div class="col-lg-6">
          <div class="form-group">
     <label>Assign User</label>
     <select class="form-control valid" name="user_id" required>
      <option value="">--Select User--</option>
      @foreach($users as $user)
      <?php 
        $store_keeper_id=CustomHelpers::get_master_table_data('store_assign_users','store_id',$data->id,'user_id');
      ?>
     <option value="{{$user->id}}"  @if($user->id==$store_keeper_id) selected @endif>{{$user->name}}</option>
      @endforeach
     </select>
     
    
        </div> 
     </div>

       <div class="col-lg-6">
          <div class="form-group">
     <label>Warehouse Name</label>
     <input type="text" value="{{ $data->name }}" name="name" id="name" class="form-control valid" placeholder="Enter Warehouse Name" required />
   
        </div> 
     </div>

     <div class="col-lg-6">
          <div class="form-group">
     <label>Warehouse Mobile No</label>
     <input type="text" name="mobile" value="{{ $data->mobile }}" id="mobile" class="form-control valid" placeholder="Enter Warehouse Mobile No" required />

        </div> 
     </div>

      
       

       <div class="col-lg-6">
          
          <div class="form-group">
     <label>State</label>
     <select name="state" id="state" class="form-control valid" required>
     <option value="">--Select State--</option>
     @foreach($states as $state)
     <option value="{{ $state->state_title }}" state_id="{{ $state->id }}" @if($state->state_title==$data->state) selected @endif>{{ $state->state_title }}</option>
     @endforeach
     </select >

     <span id="error_state" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
        <?php 
         $state_id=DB::table('states')->where('state_title','=',$data->state)->first();
        
         $districts=DB::table('districts')->where('state_id','=',$state_id->id)->get();
         $dist_id=DB::table('districts')->where('district_title','=',$data->dist)->first();
         $cities=DB::table('cities')->where('districtid','=',$dist_id->id)->get();
        
         ?>
          <div class="form-group">
     <label>District</label>
     <select name="dist" id="dist" class="form-control valid" required>
     <option value="">--Select District--</option>
    @foreach($districts as $district)
<option value="{{$district->district_title}}" @if($district->district_title==$data->dist) selected @endif dist_id="{{$district->id}}">{{$district->district_title}}</option>
    @endforeach
     </select >

     <span id="error_dist" class="text-danger"></span>
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>City</label>
     <select name="city" id="city" class="form-control valid" required>
     <option value="">--Select City--</option>
    @foreach($cities as $city)
   <option value="{{$city->name}}" @if($city->name==$data->city) selected @endif>{{$city->name}}</option>
    @endforeach
     </select >

    
        </div> 
     </div>
       <div class="col-lg-12">
          <div class="form-group">
     <label>Address</label>
     <textarea name="address" id="address" class="form-control valid" required>{{$data->address}}</textarea>
     
    
        </div> 
     </div>
     <div class="col-md-12">
  <hr>
  <div class="form-check">
  <label class="form-check-label">
    <input type="checkbox" name="status" class="form-check-input partener_check" value="2" @if($data->status==2) checked @endif>Do KYC ?
  </label>
</div>
</div>
<div class="col-md-12">

<div class="partener_part" @if($data->status==2) style="display:block" @endif>
<div id="laptop_dynamic" class="laptop_dynamic">
  <div id="thirdrow1">
  <div class="row">
   
   <div class="col-lg-6">
          <div class="form-group">
     <label>Rent Agreement</label>
      @if($data->rent_aggreement!='')  
         <a target="_blank" href="{{url('public/uploads/documents/'.$data->rent_aggreement)}}">View</a>
      @endif
     <input type="file" name="rent_aggreement" @if($data->rent_aggreement=='')   id="rent_aggreement" @endif   class="form-control valid"   />
   
        </div> 
     </div>


     <div class="col-lg-6">
          <div class="form-group">
     <label>Rent Per Month</label>
     <input type="text" name="rent_per_month" id="rent_per_month" class="form-control valid" placeholder="Enter Rent Per Month" value="{{ $data->rent_per_month }}" />
   
        </div> 
     </div>
 





</div>
</div>
</div>

<!---->
</div>
</div>
     </div>


        <br />

<!---->

         <div align="center">
    <button class="btn btn-success submit">Update</button>
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
           

     <div class="col-lg-6">
          <div class="form-group">
     <label>Assign User</label>
     <select class="form-control valid" name="user_id" required>
      <option value="">--Select User--</option>
      @foreach($users as $user)
     <option value="{{$user->id}}">{{$user->name}}</option>
      @endforeach
     </select>
     
    
        </div> 
     </div>
     <div class="col-lg-6">
          <div class="form-group">
     <label>Warehouse Name</label>
     <input type="text" name="name" id="name" class="form-control valid" placeholder="Enter Warehouse Name" required />
   
        </div> 
     </div>



       <div class="col-lg-6">
          <div class="form-group">
     <label>Warehouse Mobile No</label>
     <input type="text" name="mobile" id="mobile" class="form-control valid" placeholder="Enter Warehouse Mobile No" required />

        </div> 
     </div>
  
       <div class="col-lg-6">
          
          <div class="form-group">
     <label>State</label>
     <select name="state" id="state" class="form-control valid" required>
     <option value="">--Select State--</option>
     @foreach($states as $state)
     <option value="{{ $state->state_title }}" state_id="{{ $state->id }}">{{ $state->state_title }}</option>
     @endforeach
     </select >


        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>District</label>
     <select name="dist" id="dist" class="form-control valid" required>
     <option value="">--Select District--</option>
   
     </select >

  
        </div> 
     </div>
      <div class="col-lg-6">
          <div class="form-group">
     <label>City</label>
     <select name="city" id="city" class="form-control valid" required>
     <option value="">--Select City--</option>
   
     </select >

  
        </div> 
     </div>
       <div class="col-lg-12">
          <div class="form-group">
     <label>Address</label>
     <textarea name="address" id="address" class="form-control valid" required></textarea>
     

        </div> 
     </div>

     <div class="col-md-12">
  <hr>
  <div class="form-check">
  <label class="form-check-label">
    <input type="checkbox" name="status" class="form-check-input partener_check" value="2">Do KYC ?
  </label>
</div>
</div>

<div class="col-md-12">
<div class="partener_part">
<div id="laptop_dynamic" class="laptop_dynamic">
  <div id="thirdrow1">
  <div class="row">
   
   <div class="col-lg-6">
          <div class="form-group">
     <label>Rent Agreement</label>
     <input type="file" name="rent_aggreement" id="rent_aggreement" class="form-control valid"   />
   
        </div> 
     </div>


     <div class="col-lg-6">
          <div class="form-group">
     <label>Rent Per Month</label>
     <input type="text" name="rent_per_month" id="rent_per_month" class="form-control valid" placeholder="Enter Rent Per Month"  />
   
        </div> 
     </div>
 





</div>
</div>
</div>

<!---->
</div>
</div>
     </div>


        <br />

<!---->

        <div align="center">
    <button class="btn btn-success submit">Submit</button>
        </div>
        <br />
       </div>
      </div>
     </div>
 @endif


 
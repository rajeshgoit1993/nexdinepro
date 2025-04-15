                    <div class="page slide-page">
                        <div class="title">Professional Summary</div>
                    
                        <div class="row">
<div class="col-md-6">
    <div class="form-group">
<label for="" class="">Goal 5 Years</label> 
           
{!! Form::textarea("goal_small",$data->goal_small,["class"=>"form-control valid","rows"=>"2","maxlength"=>"500"]) !!}
<span class="text-danger">{{ $errors->first('ref_no') }}</span>   
</div>
</div>
<div class="col-md-6">
    <div class="form-group">
<label for="" class="required">Experience Summary/Abstract</label> 
           
{!! Form::textarea("exp",$data->exp,["class"=>"form-control valid","required"=>"","rows"=>"2","maxlength"=>"500"]) !!}
<span class="text-danger">{{ $errors->first('ref_no') }}</span>   
</div>
</div>

     </div> 
  <div class="field">
<button class="btn btn-info firstNext next">Next</button>
    </div>
                                      
                        
                    </div>


                  
                    
                    <div class="page">
                        <div class="title required">Education <span style="font-size: 12px;font-weight: bold;"> (Note: Please Enter Details 12th & above)  </span>  </div>
               <div class="box" style="padding: 5px;
    border-bottom:  1px solid lightgray;
    margin-bottom: 10px;">

  <div class="dynamic_ten" id="dynamic_four">
    @if($data->last_degree!='')
 <?php
  $education=unserialize($data->last_degree);
  $first_size=sizeof($education);
  $i=1;
  $k=0;
  ?>
  @foreach($education as $row=>$col)
  @if($i>1)
  <div id="tenrow{{$i}}" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray">
    <div class="row">
 <div class="col-md-2">
    <input type="text" name="education[{{$k}}][qualification]"  class="form-control valid"  placeholder="Qualification"  value="{{$col['qualification']}}">
 </div>
 
 <div class="col-md-2">
    <input type="text" name="education[{{$k}}][degree]"  class="form-control valid"  placeholder="Degree" value="{{$col['degree']}}">
 </div>
  <div class="col-md-2">
    <input type="text" name="education[{{$k}}][grade]"  class="form-control valid"  placeholder="Percentage/Grade"  value="{{$col['grade']}}">
 </div>

  <div class="col-md-2">
    <input type="text" name="education[{{$k}}][institution]"  class="form-control valid"  placeholder="Institution" value="{{$col['institution']}}">
 </div>
   <div class="col-md-2">
    <input type="text" name="education[{{$k}}][year]"  class="form-control valid"  placeholder="Year" value="{{$col['year']}}">
 </div>
  <div class="col-md-2">
   <button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove_ten" style="margin-bottom: 5px">x Remove </button>  
 </div>
</div>

</div>
@else
  <div id="tenrow{{$i}}">
    <div class="row">
 <div class="col-md-2">
    <input type="text" name="education[{{$k}}][qualification]"  class="form-control valid"  placeholder="Qualification" required="" value="{{$col['qualification']}}">
 </div>
 
 <div class="col-md-2">
    <input type="text" name="education[{{$k}}][degree]"  class="form-control valid"  placeholder="Degree" required="" value="{{$col['degree']}}">
 </div>
  <div class="col-md-2">
    <input type="text" name="education[{{$k}}][grade]"  class="form-control valid"  placeholder="Percentage/Grade" required="" value="{{$col['grade']}}">
 </div>

  <div class="col-md-2">
    <input type="text" name="education[{{$k}}][institution]"  class="form-control valid"  placeholder="Institution" required="" value="{{$col['institution']}}">
 </div>
   <div class="col-md-2">
    <input type="text" name="education[{{$k}}][year]"  class="form-control valid"  placeholder="Year" required="" value="{{$col['year']}}">
 </div>
  <div class="col-md-2">
   <button id="add_education" class="btn btn-info" ><span class="fa fa-plus"></span> Education</button>  
 </div>
</div>

</div>
@endif
 

 <?php $k++; $i++;  ?>
  @endforeach 


@else

 <div id="tenrow1">
    <div class="row">
 <div class="col-md-2">
    <input type="text" name="education[0][qualification]"  class="form-control valid"  placeholder="Qualification" required="">
 </div>
 
 <div class="col-md-2">
    <input type="text" name="education[0][degree]"  class="form-control valid"  placeholder="Degree" required="">
 </div>
  <div class="col-md-2">
    <input type="text" name="education[0][grade]"  class="form-control valid"  placeholder="Percentage/Grade" required="">
 </div>

  <div class="col-md-2">
    <input type="text" name="education[0][institution]"  class="form-control valid"  placeholder="Institution" required="">
 </div>
   <div class="col-md-2">
    <input type="text" name="education[0][year]"  class="form-control valid"  placeholder="Year" required="">
 </div>
  <div class="col-md-2">
   <button id="add_education" class="btn btn-info" ><span class="fa fa-plus"></span> Education</button>  
 </div>
</div>

</div>

@endif
</div>

</div>

                        <div class="field btns">
                            <button class="btn btn-info prev-1 prev">Previous</button>
                            <button class="btn btn-success next-1 next">Next</button>
                        </div>
                    </div>
                    <div class="page">
                        <div class="title">Certifications</div>
                     <div class="box" style="padding: 15px;
    border-bottom:  1px solid lightgray;
    margin-bottom: 10px;">

  <div class="dynamic_four" id="dynamic_four">
    @if($data->certification!='')
    <?php
  $certification=unserialize($data->certification);
  $first_size=sizeof($certification);
  $i=1;
  $k=0;
  ?>
  @foreach($certification as $row=>$col)
  @if($i>1)
    <div id="fourrow{{$i}}" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray">
    <div class="row">
 <div class="col-md-5">
    <input type="text" name="certification[{{$k}}][certification]"  class="form-control valid"  placeholder="Certification" value="{{$col['certification']}}">
 </div>
 
 <div class="col-md-4">
    <input type="text" name="certification[{{$k}}][year]"  class="form-control valid"  placeholder="Year/Month" value="{{$col['year']}}">
 </div>
 <div class="col-md-3"><button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove_four" style="margin-bottom: 5px">x Remove </button></div>
</div>

</div>
  @else
    <div id="fourrow{{$i}}">
    <div class="row">
 <div class="col-md-5">
    <input type="text" name="certification[{{$k}}][certification]"  class="form-control valid"  placeholder="Certification"  value="{{$col['certification']}}">
 </div>
 
 <div class="col-md-4">
    <input type="text" name="certification[{{$k}}][year]"  class="form-control valid"  placeholder="Year/Month"  value="{{$col['year']}}">
 </div>
  <div class="col-md-3">
   <button id="add_certification" class="btn btn-info" ><span class="fa fa-plus"></span> Add Certification</button>  
 </div>
</div>

</div>
  @endif
 

 <?php $k++; $i++;  ?>
  @endforeach  




@else
 <div id="fourrow1">
    <div class="row">
 <div class="col-md-5">
    <input type="text" name="certification[0][certification]"  class="form-control valid"  placeholder="Certification">
 </div>
 
 <div class="col-md-4">
    <input type="text" name="certification[0][year]"  class="form-control valid"  placeholder="Year/Month">
 </div>
  <div class="col-md-3">
   <button id="add_certification" class="btn btn-info" ><span class="fa fa-plus"></span> Add Certification</button>  
 </div>
</div>

</div>
@endif

</div>
</div>
                        <div class="field btns">
                            <button class="btn btn-info prev-2 prev">Previous</button>
                            <button class="btn btn-success next-2 next">Next</button>
                        </div>
                    </div>

                    <div class="page">
                        <div class="title"> Extra curricular/ Soft skills</div>
                       <div class="box" style="padding: 15px;
    border-bottom:  1px solid lightgray;
    margin-bottom: 10px;">

  <div class="dynamic_five" id="dynamic_five">
    @if($data->other_accomplishments!='')
    <?php
  $other_accomplishments=unserialize($data->other_accomplishments);
  $first_size=sizeof($other_accomplishments);
  $i=1;
  $k=0;
  ?>
  @foreach($other_accomplishments as $row=>$col)
  @if($i>1)
 <div id="fiverow{{$i}}" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray">
    <div class="row">
 <div class="col-md-5">
    <input type="text" name="other_accomplishments[{{$k}}][other_accomplishments]"  class="form-control valid"  placeholder="Accomplishments" value="{{$col['other_accomplishments']}}">
 </div>
 
 <div class="col-md-4">
    <input type="text" name="other_accomplishments[{{$k}}][year]"  class="form-control valid"  placeholder="Year/Month" value="{{$col['year']}}">
 </div>
 <div class="col-md-3"><button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove_five" style="margin-bottom: 5px">x Remove </button></div>
</div>

</div>
  @else
 <div id="fiverow{{$i}}">
    <div class="row">
 <div class="col-md-5">
    <input type="text" name="other_accomplishments[{{$k}}][other_accomplishments]"  class="form-control valid"  placeholder="Accomplishments"  value="{{$col['other_accomplishments']}}">
 </div>
 
 <div class="col-md-4">
    <input type="text" name="other_accomplishments[{{$k}}][year]"  class="form-control valid"  placeholder="Year/Month"  value="{{$col['year']}}">
 </div>
  <div class="col-md-3">
   <button id="add_other_accomplishments" class="btn btn-info" ><span class="fa fa-plus"></span> Add Certification</button>  
 </div>
</div>

</div>
  @endif
 

 <?php $k++; $i++;  ?>
  @endforeach
@else

 <div id="fiverow1">
    <div class="row">
 <div class="col-md-5">
    <input type="text" name="other_accomplishments[0][other_accomplishments]"  class="valid form-control"  placeholder="Accomplishments">
 </div>
 
 <div class="col-md-4">
    <input type="text" name="other_accomplishments[0][year]"  class="form-control valid"  placeholder="Year/Month">
 </div>
  <div class="col-md-3">
   <button id="add_other_accomplishments" class="btn btn-info" ><span class="fa fa-plus"></span> Add Certification</button>  
 </div>
</div>

</div>
@endif

   
</div>

<!---->
<div class="dynamic_a" id="dynamic_a" style="margin:10px 0px;border-top: 2px solid black;padding-top: 10px;">


  <h6><i><b>Soft Skills</b></i></h6>

  @if($data->softskills!='')
  <?php
  $softskills=unserialize($data->softskills);
  $first_size=sizeof($softskills);
  $i=1;
  $k=0;
  ?>
  @foreach($softskills as $row=>$col)
  @if($i>1)
 <div id="arow{{$i}}" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="softskills[{{$k}}][softskills]"  class="form-control valid"  placeholder="Soft Skills" value="{{$col['softskills']}}">
 </div>
 
 
 <div class="col-md-3"><button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove_a" style="margin-bottom: 5px">x Remove </button></div>
</div>

</div>
  @else
 <div id="arow{{$i}}">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="softskills[{{$k}}][softskills]"  class="form-control valid"  placeholder="Soft Skills"  value="{{$col['softskills']}}">
 </div>
 

  <div class="col-md-3">
   <button id="add_softskills" class="btn btn-info" ><span class="fa fa-plus"></span> Add Soft Skills</button>  
 </div>
</div>

</div>
  @endif
 

 <?php $k++; $i++;  ?>
  @endforeach
   @else
<div id="arow1">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="softskills[0][softskills]"  class="form-control valid"  placeholder="Soft Skills" >
 </div>
 
 
  <div class="col-md-3">
   <button id="add_softskills" class="btn btn-info" ><span class="fa fa-plus"></span> Add Soft Skills</button>  
 </div>
</div>

</div>

   @endif
 
</div>
<!---->
<div class="dynamic_b" id="dynamic_b" style="margin:10px 0px;border-top: 2px solid black;padding-top: 10px;">
  <h6><i><b>Strengths</b></i></h6>
  @if($data->strengths!='')
  <?php
  $strengths=unserialize($data->strengths);
  $first_size=sizeof($strengths);
  $i=1;
  $k=0;
  ?>
  @foreach($strengths as $row=>$col)
  @if($i>1)
 <div id="brow{{$i}}" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="strengths[{{$k}}][strengths]"  class="form-control valid"  placeholder="Strengths" value="{{$col['strengths']}}">
 </div>
 
 
 <div class="col-md-3"><button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove_b" style="margin-bottom: 5px">x Remove </button></div>
</div>

</div>
  @else
 <div id="brow{{$i}}">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="strengths[{{$k}}][strengths]"  class="form-control valid"  placeholder="Strengths"  value="{{$col['strengths']}}">
 </div>
 

  <div class="col-md-3">
   <button id="add_strength" class="btn btn-info" ><span class="fa fa-plus"></span> Add Strengths</button>  
 </div>
</div>

</div>
  @endif
 

 <?php $k++; $i++;  ?>
  @endforeach

  @else
  <div id="brow1">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="strengths[0][strengths]"  class="form-control valid"  placeholder="Strengths">
 </div>
 
 
  <div class="col-md-3">
   <button id="add_strength" class="btn btn-info" ><span class="fa fa-plus"></span> Add Strengths</button>  
 </div>
</div>

</div>

  @endif
</div>
<!---->
<div class="dynamic_c" id="dynamic_c" style="margin:10px 0px;border-top: 2px solid black;padding-top: 10px;">
  <h6><i><b>Hobbies/Interests</b></i></h6>
  @if($data->hobbies!='')
  <?php
  $hobbies=unserialize($data->hobbies);
  $first_size=sizeof($hobbies);
  $i=1;
  $k=0;
  ?>
  @foreach($hobbies as $row=>$col)
  @if($i>1)
 <div id="crow{{$i}}" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="hobbies[{{$k}}][hobbies]"  class="form-control valid"  placeholder="Hobbies/Interests" value="{{$col['hobbies']}}">
 </div>
 
 
 <div class="col-md-3"><button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove_c" style="margin-bottom: 5px">x Remove </button></div>
</div>

</div>
  @else
 <div id="crow{{$i}}">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="hobbies[{{$k}}][hobbies]"  class="form-control valid"  placeholder="Hobbies/Interests"  value="{{$col['hobbies']}}">
 </div>
 

  <div class="col-md-3">
   <button id="add_hobbies" class="btn btn-info" ><span class="fa fa-plus"></span> dd Hobbies/Interests</button>  
 </div>
</div>

</div>
  @endif
 

 <?php $k++; $i++;  ?>
  @endforeach
  @else
 <div id="crow1">
    <div class="row">
 <div class="col-md-9">
    <input type="text" name="hobbies[0][hobbies]"  class="form-control valid"  placeholder="Hobbies/Interests">
 </div>
 
 
  <div class="col-md-3">
   <button id="add_hobbies" class="btn btn-info" ><span class="fa fa-plus"></span> Add Hobbies/Interests</button>  
 </div>
</div>

</div>
  @endif
</div>
<!---->

</div>


                        <div class="field btns">
                            <button class="btn btn-info prev-3 prev">Previous</button>
                            <button class="btn btn-success next-3 next">Next</button>
                        </div>
                    </div>


             <!---->
                    <div class="page">
                        <div class="title">Personal Details</div>
                       <div class="row">
  

<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">First Name</label>
      {!! Form::text("first_name",$data->first_name,["class"=>"form-control valid","placeholder"=>"First Name","required"=>""]) !!}
          
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Last Name</label>
      {!! Form::text("last_name",$data->last_name,["class"=>"form-control valid","placeholder"=>"Last Name","required"=>""]) !!}
              
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="">Nick Name</label>
      {!! Form::text("nick_name",$data->nick_name,["class"=>"form-control valid","placeholder"=>"Nick Name"]) !!}
           
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Father's Name</label>
      {!! Form::text("fathers_name",$data->fathers_name,["class"=>"form-control valid","placeholder"=>"Father's Name","required"=>""]) !!}
           
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="">Father's Email Id</label>
      {!! Form::email("email_id",$data->email_id,["class"=>"form-control valid","placeholder"=>"Father's Email Id"]) !!}
           
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Father's Mobile No</label>
      {!! Form::text("mobile_no",$data->mobile_no,["class"=>"form-control valid","placeholder"=>"Father's Mobile No","required"=>""]) !!}
          
        </div>
</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Mother's Name</label>
      {!! Form::text("mother_name",$data->mother_name,["class"=>"form-control valid","placeholder"=>"Mother's Name","required"=>""]) !!}
           
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="">Mother's Email Id</label>
      {!! Form::email("mother_email_id",$data->mother_email_id,["class"=>"form-control valid","placeholder"=>"Mother's Email Id"]) !!}
           
        </div>

</div>

<div class="col-md-4">
   <div class="form-group">
          <label for="" class="">Mother's Mobile No</label>
      {!! Form::text("mother_contact_no",$data->mother_contact_no,["class"=>"form-control valid","placeholder"=>"Mother's Mobile No"]) !!}
           
        </div>

</div>



<div class="col-md-4">
   <div class="form-group">
          <label for="" class="">Spouse's Name</label>
      {!! Form::text("spouse_name",$data->spouse_name,["class"=>"form-control","placeholder"=>"Spouse's Name"]) !!}
           
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="">Spouse's Email Id</label>
      {!! Form::email("spouse_email_id",$data->spouse_email_id,["class"=>"form-control valid","placeholder"=>"Spouse's Email Id"]) !!}
           
        </div>

</div>

<div class="col-md-4">
   <div class="form-group">
          <label for="" class="">Spouse's Mobile No</label>
      {!! Form::text("spouse_contact_no",$data->spouse_contact_no,["class"=>"form-control","placeholder"=>"Spouse's Mobile No"]) !!}
           
        </div>

</div>

<div class="col-md-4">
   <div class="form-group">
          <label for="">Passport No</label>
      {!! Form::text("passport_no",$data->passport_no,["class"=>"form-control valid","placeholder"=>"Passport No"]) !!}
          
        </div>

</div><div class="col-md-4">
    <div class="form-group">
          <label for="" class="required">Language/s</label>
          <?php
          $language=unserialize($data->language);

    ?>
        <select class="form-control valid" name="language[]" required="" multiple>
            <option value="">--Choose Language--</option>
            <option value="Hindi" @if($language!='')
            @foreach($language as $languages)  
            @if($languages=='Hindi') selected 
            @endif 
            @endforeach @endif>Hindi</option>
            <option value="English" @if($language!='') @foreach($language as $languages)  @if($languages=='English') selected @endif @endforeach @endif>English</option>
        </select>
      
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Nationality</label>
      {!! Form::text("nationality",$data->nationality,["class"=>"form-control valid","placeholder"=>"Nationality","required"=>""]) !!}
          
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Marital Status</label>
            <select class="form-control valid" name="marital_status" required="" >
            <option value="">--Choose--</option>
            <option value="Married" @if($data->marital_status=='Married') selected @endif>Married</option>
            <option value="Unmarried" @if($data->marital_status=='Unmarried') selected @endif>Unmarried</option>
        </select>

    
        </div>

</div>
<div class="col-md-4">
  <!--  <div class="form-group">
          <label for="">Hobbies</label>
      {!! Form::text("hobbies",null,["class"=>"form-control","placeholder"=>"Hobbies"]) !!}
            
        </div> -->

</div>
<div class="col-md-12">
   <div class="form-group">
          <label for="" class="required">Permanent Address</label>
      {!! Form::textarea("address_line_first",$data->address_line_first,["class"=>"form-control valid","placeholder"=>"Address Line 1","rows"=>"2","required"=>""]) !!}
             
        </div>

</div>
<!-- <div class="col-md-6">
   <div class="form-group">
          <label for="">Address Line 2</label>
      {!! Form::textarea("address_line_second",null,["class"=>"form-control valid","placeholder"=>"Address Line 2","rows"=>"2"]) !!}
          
        </div>

</div> -->

<div class="col-md-4">
  <div class="form-group">
     <label class="required">State</label>
     <select name="state" id="state" class="form-control valid" required>
     <option value="">--Select State--</option>
 @foreach($states as $state)
     <option value="{{ $state->state_title }}" state_id="{{ $state->id }}" @if($state->state_title==$data->state) selected @endif>{{ $state->state_title }}</option>
     @endforeach
 
     </select >


        </div> 

</div>
        <?php 
         $state_id=DB::table('states')->where('state_title','=',$data->state)->first();
         if($state_id!='')
         {
         $districts=DB::table('districts')->where('state_id','=',$state_id->id)->get();
         $dist_id=DB::table('districts')->where('district_title','=',$data->dist)->first();
         $cities=DB::table('cities')->where('districtid','=',$dist_id->id)->get();
         }
        
        
         ?>
<div class="col-md-4">
  <div class="form-group">
     <label class="required">District</label>
     <select name="dist" id="dist" class="form-control valid" required>
        @if($state_id!='')
          @foreach($districts as $district)
<option value="{{$district->district_title}}" @if($district->district_title==$data->dist) selected @endif dist_id="{{$district->id}}">{{$district->district_title}}</option>
    @endforeach
       @else
     <option value="">--Select District--</option>
       @endif
     </select >

  
        </div>
</div>
<div class="col-md-4">
    <div class="form-group">
     <label class="required">City</label>
     <select name="city" id="city" class="form-control valid" required>
            @if($state_id!='')
          @foreach($cities as $city)
   <option value="{{$city->name}}" @if($city->name==$data->city) selected @endif>{{$city->name}}</option>
    @endforeach
       @else
    <option value="">--Select City--</option>
       @endif

     
   
     </select >

  
        </div>

</div>

<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Pin/Zip Code</label>
      {!! Form::text("pin_code",$data->pin_code,["class"=>"form-control valid","placeholder"=>"Pin/Zip Code","required"=>""]) !!}
          
        </div>

</div>
  </div>



                        <div class="field btns">
                            <button class="btn btn-info prev-4 prev">Previous</button>
                            <button class="btn btn-success next-4 next">Next</button>

                          
                        </div>
                    </div>
                        <!---->
                      <!--    <div class="page">
                        <div class="title">Experience</div>
                        <div class="dynamic_six" id="dynamic_six">
<div id="sixrow1">
    <div class="row">
    <div class="col-md-2">
      <label class="required">Project</label>
    <input type="text" name="experience[0][project]"  class="form-control valid"  placeholder="Project" required="">
 </div>
  <div class="col-md-2">
    <label class="required">Client Name</label>
    <input type="text" name="experience[0][client_name]"  class="form-control valid"  placeholder="Client Name" required="">
 </div>
 <div class="col-md-2">
   <label class="required">Location</label>
    <input type="text" name="experience[0][location]"  class="form-control valid"  placeholder="Location" required="">
 </div>
  <div class="col-md-3">
     <label class="required">Role</label>
    <input type="text" name="experience[0][role]"  class="form-control valid"  placeholder="Role" required="">
 </div>

  <div class="col-md-3">
    <label class="required">Responsibilities</label>
    <input type="text" name="experience[0][responsibilities]"  class="form-control valid"  placeholder="Responsibilities" required="">
 </div>   
 
 <div class="col-md-3">
   <label class="required">Start Date</label>
    <input type="text" name="experience[0][date_from]"  class="form-control valid datepicker"  placeholder="dd-mm-yy" readonly="" style="background: white !important" required="">
 </div>
  <div class="col-md-3">
    <label class="required">End Date</label>
    <input type="text" name="experience[0][date_to]"  class="form-control valid datepicker"  placeholder="dd-mm-yy" readonly="" style="background: white !important" required="">
 </div>
 <div class="col-md-3">
  <label class="required">Key Technologies</label>
    <input type="text" name="experience[0][key_technologies]"  class="form-control valid"  placeholder="Key Technologies" required="">
 </div>
 <div class="col-md-3">
   <label class="required">Environment</label>
  <input type="text" name="experience[0][environment]"  class="form-control valid"  placeholder="Environment" required="">
 </div>
  <div class="col-md-11">
    <label class="required">Description</label>
    
   <textarea name="experience[0][description]" class="form-control valid" required=""></textarea>
 </div>
  <div class="col-md-1">
     <label style="visibility: hidden;">Button</label>
   <button id="add_exp" class="btn btn-info" ><span class="fa fa-plus"></span></button>  
 </div>
</div>

</div>

</div>



                        <div class="field btns">
                            <button class="btn btn-info prev-6 prev">Previous</button>
                            <button class="btn btn-success next-6 next">Next</button>

                          
                        </div>
                    </div> -->
                        <!---->
    <div class="page">
<div class="title">Employment</div>
 <div class="col-md-12">
  <hr>
  <div class="form-check">
  <label class="form-check-label">
    <input type="checkbox" name="employement_status" class="form-check-input partener_check" value="1" @if($data->employement_status==1) checked @endif>Are You Fresher ?
  </label>
</div>
</div>


<div class="dynamic_seven" id="dynamic_seven">
@if($data->employment!='')
    <?php
  $employment=unserialize($data->employment);

  $first_size=sizeof($employment);
  $i=1;
  $k=0;
  ?>
     @foreach($employment as $row=>$col)
  @if($i>1)

<div id="sevenrow{{$i}}">
    <div class="row">
        <div class="col-md-3">
      <label class="required">Company Name</label>
    <input type="text" name="employment[{{$k}}][employer_name]"  class="form-control valid"  placeholder="Company Name" value="{{$col['employer_name']}}">
 </div>

     <div class="col-md-3">
    <label class="required">Location</label>
    <input type="text" name="employment[{{$k}}][location]"  class="form-control valid "  placeholder="Location" value="{{$col['location']}}">
 </div>

  <div class="col-md-3">
   <label class="required">Designation</label>
    <input type="text" name="employment[{{$k}}][designation]"  class="form-control valid"  placeholder="Designation" value="{{$col['designation']}}">
 </div>

  <div class="col-md-3">
     <label class="required">Start Date</label>
    <input type="date" name="employment[{{$k}}][date_from]"  class="form-control valid"  placeholder="Start Date" value="{{$col['date_from']}}">
 </div>

  <div class="col-md-3">
    <label class="required">End Date</label>
    <input type="date" name="employment[{{$k}}][date_to]"  class="form-control valid"  placeholder="Responsibilities" value="{{$col['date_to']}}">
 </div>

 <div class="col-md-3">
   <label class="required">Salary</label>
    <input type="text" name="employment[{{$k}}][notice_period]"  class="form-control valid"  placeholder="Salary"  style="background: white !important" value="{{$col['notice_period']}}">
 </div>  
 

<div class="col-md-11">
    <label class="required">Remarks</label>
    
   <textarea name="employment[{{$k}}][remarks]" class="form-control valid">{{$col['remarks']}}</textarea>
 </div>


  <div class="col-md-1"><label style="visibility: hidden;">Button</label><button name="remove" id="{{$i}}" class="btn btn-danger btn_remove_seven"><span class="fa fa-times"></span></button></div>
</div>

</div>
   @else
<div id="sevenrow{{$i}}">
    <div class="row">
     <div class="col-md-3">
      <label class="required">Company Name</label>
    <input type="text" name="employment[{{$k}}][employer_name]"  class="form-control valid add_custom_required"  placeholder="Company Name" value="{{$col['employer_name']}}" required="required">
 </div>

     <div class="col-md-3">
    <label class="required">Location</label>
    <input type="text" name="employment[{{$k}}][location]"  class="form-control valid add_custom_required"  placeholder="Location" value="{{$col['location']}}" required="required">
 </div>

  <div class="col-md-3">
   <label class="required">Designation</label>
    <input type="text" name="employment[{{$k}}][designation]"  class="form-control valid add_custom_required"  placeholder="Designation" value="{{$col['designation']}}" required="required">
 </div>

  <div class="col-md-3">
     <label class="required">Start Date</label>
    <input type="date" name="employment[{{$k}}][date_from]"  class="form-control valid add_custom_required"  placeholder="Start Date" value="{{$col['date_from']}}" required="required">
 </div>

  <div class="col-md-3">
    <label class="required">End Date</label>
    <input type="date" name="employment[{{$k}}][date_to]"  class="form-control valid add_custom_required"  placeholder="Responsibilities" value="{{$col['date_to']}}" required="required">
 </div>

 <div class="col-md-3">
   <label class="required">Salary</label>
    <input type="text" name="employment[{{$k}}][notice_period]"  class="form-control valid add_custom_required"  placeholder="Salary"  style="background: white !important" value="{{$col['notice_period']}}" required="required">
 </div>  
 

<div class="col-md-11">
    <label class="required">Remarks</label>
    
   <textarea name="employment[{{$k}}][remarks]" class="form-control valid add_custom_required" required="required">{{$col['remarks']}}</textarea>
 </div>

  <div class="col-md-1">
     <label style="visibility: hidden;">Button</label>
   <button id="add_employer" class="btn btn-info" ><span class="fa fa-plus"></span></button>  
 </div>
</div>

</div>
   @endif
 

 <?php $k++; $i++; ?>
  @endforeach
@else
<div id="sevenrow1">
    <div class="row">
    <div class="col-md-3">
      <label class="required">Company Name</label>
    <input type="text" name="employment[0][employer_name]"  class="form-control valid add_custom_required"  placeholder="Company Name" required="required">
 </div>
  <div class="col-md-3">
    <label class="required">Location</label>
    <input type="text" name="employment[0][location]"  class="form-control valid add_custom_required"  placeholder="Location" required="required">
 </div>
 <div class="col-md-3">
   <label class="required">Designation</label>
    <input type="text" name="employment[0][designation]"  class="form-control valid add_custom_required"  placeholder="Designation" required="required">
 </div>
  <div class="col-md-3">
     <label class="required">Start Date</label>
    <input type="date" name="employment[0][date_from]"  class="form-control valid add_custom_required"  placeholder="Start Date" required="required">
 </div>

  <div class="col-md-3">
    <label class="required">End Date</label>
    <input type="date" name="employment[0][date_to]"  class="form-control valid add_custom_required"  placeholder="Responsibilities" required="required">
 </div>   
 
 <div class="col-md-3">
   <label class="required">Salary</label>
    <input type="text" name="employment[0][notice_period]"  class="form-control valid add_custom_required"  placeholder="Salary"  style="background: white !important" required="required">
 </div>
 


  <div class="col-md-11">
    <label class="required">Remarks</label>
    
   <textarea name="employment[0][remarks]" class="form-control valid add_custom_required" required="required"></textarea>
 </div>
  <div class="col-md-1">
     <label style="visibility: hidden;">Button</label>
   <button id="add_employer" class="btn btn-info" ><span class="fa fa-plus"></span></button>  
 </div>
</div>

</div>

@endif


</div>


                        <div class="field btns">
                            <button class="btn btn-info prev-5 prev">Previous</button>
                          <button class="btn btn-success next-5 next">Next</button>

                          
                        </div>
                    </div>
                        <!---->
                        <div class="page">
<div class="title">Doc</div>
 <div class="row">
  

<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Bank Account Name</label>
      {!! Form::text("account_name",$data->account_name,["class"=>"form-control valid","placeholder"=>"Bank Account Name","required"=>""]) !!}
             
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Bank Account No.</label>
      {!! Form::text("account_no",$data->account_no,["class"=>"form-control valid","placeholder"=>"Bank Account No.","required"=>""]) !!}
            
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Bank Name</label>
      {!! Form::text("bankname",$data->bankname,["class"=>"form-control valid","placeholder"=>"Bank Name","required"=>""]) !!}
           
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">IFSC Code</label>
      {!! Form::text("ifsc",$data->ifsc,["class"=>"form-control valid","placeholder"=>"IFSC Code","required"=>""]) !!}
            
        </div>

</div>
<!-- <div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Account Type</label>
      {!! Form::text("account_type",null,["class"=>"form-control valid","placeholder"=>"Account Type","required"=>""]) !!}
            
        </div>

</div> -->

<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Aadhar No</label>
      {!! Form::text("aadhar_no",$data->aadhar_no,["class"=>"form-control valid","placeholder"=>"Aadhar No","required"=>""]) !!}
           
        </div>

</div><div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">PAN No</label>
      {!! Form::text("pan_no",$data->pan_no,["class"=>"form-control valid","placeholder"=>"PAN No","required"=>""]) !!}
            
        </div>

</div><div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">DOB</label>
      {!! Form::date("dob",$data->dob,["class"=>"form-control valid","placeholder"=>"DOB","required"=>""]) !!}
           
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Blood Group </label>
      {!! Form::text("blood_group",$data->blood_group,["class"=>"form-control valid","placeholder"=>"Blood Group","required"=>""]) !!}
          
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="">UAN No</label>
      {!! Form::text("un_no",$data->un_no,["class"=>"form-control valid","placeholder"=>"UAN No"]) !!}
          
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="">ESI No</label>
      {!! Form::text("esi_no",$data->esi_no,["class"=>"form-control valid","placeholder"=>"ESI No"]) !!}
          
        </div>

</div>

<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Blood Group </label>
      {!! Form::text("blood_group",$data->blood_group,["class"=>"form-control valid","placeholder"=>"Blood Group","required"=>""]) !!}
          
        </div>

</div>
<!-- <div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Goal 10 Years</label>
      {!! Form::text("goal_large",null,["class"=>"form-control valid","placeholder"=>"Goal 10 Years","required"=>""]) !!}
           
        </div>

</div> -->
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Self attested Aadhar card  @if($data->doc_aadhar!='')
      <a href="{{url('public/uploads/documents/'.$data->doc_aadhar)}}" target="_blank">View Uploaded</a>
      @endif </label>
     <input type="file" name="doc_aadhar" class="form-control valid" accept="application/pdf,image/jpeg"  @if($data->doc_aadhar=='') required="" @endif >    
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Passport Photo   @if($data->photograph!='')
      <a href="{{url('public/uploads/documents/'.$data->photograph)}}" target="_blank">View Uploaded</a>
      @endif</label>
     <input type="file" name="photograph" class="form-control valid" accept="application/pdf,image/jpeg"  @if($data->photograph=='') required="" @endif >    
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Self attested PAN card  @if($data->doc_pan!='')
      <a href="{{url('public/uploads/documents/'.$data->doc_pan)}}" target="_blank">View Uploaded</a>
      @endif</label>
     <input type="file" name="doc_pan" class="form-control valid" accept="application/pdf,image/jpeg"  @if($data->doc_pan=='') required="" @endif>    
        </div>

</div>
<!-- <div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Self attested Relieving letter of last company  </label>
     <input type="file" name="doc_relieving" class="form-control valid" accept="application/pdf,image/jpeg" >    
        </div>

</div> -->
<!-- <div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Cancelled Cheque of the bank account for salary transfer   </label>
     <input type="file" name="doc_cancel_cheque" class="form-control valid" accept="application/pdf,image/jpeg" required="">    
        </div>

</div> -->
<div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Self attested  last two qualifications @if($data->doc_qualification!='')
      <a href="{{url('public/uploads/documents/'.$data->doc_qualification)}}" target="_blank">View Uploaded</a>
      @endif </label>
     <input type="file" name="doc_qualification" class="form-control valid" accept="application/pdf,image/jpeg"  @if($data->doc_qualification=='') required="" @endif >    
        </div>

</div>
<div class="col-md-4">
   <div class="form-group">
          <label for="" >Self attested copies of key certifications   @if($data->doc_certification !='')
      <a href="{{url('public/uploads/documents/'.$data->doc_certification)}}" target="_blank">View Uploaded</a>
      @endif</label>
     <input type="file" name="doc_certification" class="form-control valid" accept="application/pdf,image/jpeg" >    
        </div>

</div>
<!-- <div class="col-md-4">
   <div class="form-group">
    <label for="" class="required">Self attested address proof
  </label>
     <input type="file" name="address_proof" class="form-control valid" accept="application/pdf,image/jpeg"  required="">    
        </div>

</div> -->
<!-- <div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Self attested identity proof  </label>
     <input type="file" name="id_proof" class="form-control valid" accept="application/pdf,image/jpeg"  required="" >    
        </div>

</div> -->
<!-- <div class="col-md-4">
   <div class="form-group">
          <label for="" class="required">Self attested copies of last three payslips </label>
     <input type="file" name="payslip" class="form-control valid" accept="application/pdf,image/jpeg"  required="" >    
        </div>

</div> -->
  </div> 
 <div class="field btns">
  <button class="btn btn-info prev-7 prev">Previous</button>
                           <button class="btn btn-success submit">Submit</button>

                          
                        </div>

    </div>
<div class="card">
<div class="card-header">
<h3 class="card-title">Employee Registration Details</h3>
</div>
<!-- /.card-header -->

<!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
<div id="accordion">

<div class="card card-danger">
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
Basic Details
</a>
</h4>
</div>
<div id="collapseTwo" class="collapse" data-parent="#accordion">
<div class="card-body">
<table class="table table-bordered">


<tr>
<td><b>User ID</b></td>
<td>{{$fanchise_detail->email}}</td>
<td><b>Name</b></td>
<td>{{$fanchise_detail->name}}</td>
</tr>
<tr>
<td><b>Mobile No.</b></td>
<td>{{$fanchise_detail->mobile}}</td>
<td><b>State</b></td>
<td>{{$fanchise_detail->state}}</td>
</tr>
<tr>
<td><b>Dist</b></td>
<td>{{$fanchise_detail->dist}}</td>
<td><b>City</b></td>
<td>{{$fanchise_detail->city}}</td>
</tr>
<tr>
<td><b>Address</b></td>
<td colspan="3">{{$fanchise_detail->address}}</td>

</tr>

</table>
</div>
</div>
</div>

<!---->
 @if($fanchise_detail->status>=2)
<div class="card card-info">
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapsefour">
KYC
</a>
</h4>
</div>
<div id="collapsefour" class="collapse" data-parent="#collapsefour">
   <?php 

    $data=DB::table('user_extra_details')->where('store_id','=',$fanchise_detail->id)->first();
     ?>
<div class="card-body">
<div class="col-md-12">

<h6>Objective</h6>
<p>{{ $data->objective }}</p>
<h6>Experience Summary/Abstract</h6>
<p>{{ $data->exp }}</p>

<h6>Education</h6>
<table class="table">
  
    <tr>
      <th>Qualification</th>
      <th>Degree</th>
      <th>Percentage/Grade</th>
      <th>Institution</th>
      <th>Year</th>
    </tr>
<?php
$education=unserialize($data->last_degree);
  ?>
  @foreach($education as $educations)
    <tr>
      <td>{{$educations['qualification']}}</td>
      <td>{{$educations['degree']}}</td>
      <td>{{$educations['grade']}}</td>
      <td>{{$educations['institution']}}</td>
      <td>{{$educations['year']}}</td>
    </tr>

 @endforeach
</table>
<h6>Certifications</h6>
<table class="table">
  
    <tr>
      <th>Certification</th>
      <th>Year/Month</th>
     
    </tr>

  <?php
$certification=unserialize($data->certification);
  ?>
  @foreach($certification as $certifications)
<tr>
  <td>{{$certifications['certification']}}</td>
   <td>{{$certifications['year']}}</td>

 

</tr>
  @endforeach

</table>
<h6>Other Accomplishments</h6>
<table class="table">
  
    <tr>
      <th>Certification</th>
      <th>Year/Month</th>
     
    </tr>

  <?php
$certification=unserialize($data->other_accomplishments);
  ?>
  @foreach($certification as $certifications)
<tr>
  <td>{{$certifications['other_accomplishments']}}</td>
   <td>{{$certifications['year']}}</td>

 

</tr>
  @endforeach

</table>

<h6>Soft Skills</h6>
<table class="table">
  
    <tr>
      <th>Soft Skills</th>
     
     
    </tr>

  <?php

$softskills=unserialize($data->softskills);

  ?>
  @if(count($softskills)==0)

<tr>
  <td>NA</td>
 

 

</tr>

  @else
 @foreach($softskills as  $row=>$col)
<tr>
  <td>
  @if($col['softskills']=='')
NA
  @else

{{$col['softskills']}}

</td>
   @endif

 

</tr>
  @endforeach
  @endif
 

</table>


<h6>Strengths</h6>
<table class="table">
  
    <tr>
      <th>Strengths</th>
     
     
    </tr>

  <?php

  $strengths=unserialize($data->strengths);

  ?>
  @if(count($strengths)==0)

<tr>
  <td>NA</td>
 

 

</tr>

  @else
 @foreach($strengths as  $row=>$col)
<tr>
  <td>
  @if($col['strengths']=='')
NA
  @else

{{$col['strengths']}}

</td>
   @endif

 

</tr>
  @endforeach
  @endif
 

</table>

<h6>Hobbies/Interests</h6>
<table class="table">
  
    <tr>
      <th>Hobbies/Interests</th>
     
     
    </tr>

  <?php

    $hobbies=unserialize($data->hobbies);

  ?>
  @if(count($hobbies)==0)

<tr>
  <td>NA</td>
 

 

</tr>

  @else
 @foreach($hobbies as  $row=>$col)
<tr>
  <td>
  @if($col['hobbies']=='')
NA
  @else

{{$col['hobbies']}}

</td>
   @endif

 

</tr>
  @endforeach
  @endif
 

</table>

<h6>Personal Details</h6>
<table class="table">
  
  
  

    <tr>
      <td><b>Name</b></td>
      <td>{{$data->first_name}} {{$data->last_name}} {{$data->nick_name}}</td>
    
    </tr>
<tr>
      <td><b>Father's Name</b></td>
      <td>{{$data->fathers_name}} </td>
    
    </tr>
<tr>
      <td><b>Father's Email Id</b></td>
      <td>{{$data->email_id}} </td>
    
    </tr>

    <tr>
      <td><b>Father's Mobile No</b></td>
      <td>{{$data->mobile_no}} </td>
    
    </tr>

<tr>
      <td><b>Mother's Name</b></td>
      <td>{{$data->mother_name}} </td>
    
    </tr>
<tr>
      <td><b>Mother's Email Id</b></td>
      <td>{{$data->mother_email_id}} </td>
    
    </tr>

    <tr>
      <td><b>Mother's Mobile No</b></td>
      <td>{{$data->mother_contact_no}} </td>
    
    </tr>

    <tr>
      <td><b>Spouse's Name</b></td>
      <td>{{$data->spouse_name}} </td>
    
    </tr>
<tr>
      <td><b>Spouse's Email Id</b></td>
      <td>{{$data->spouse_email_id}} </td>
    
    </tr>

    <tr>
      <td><b>Spouse's Mobile No</b></td>
      <td>{{$data->spouse_contact_no}} </td>
    
    </tr>

  <!--   <tr>
      <td><b>Contact No</b></td>
      <td>{{$data->contact_no}} </td>
    
    </tr> -->
 <tr>
      <td><b>Passport No</b></td>
      <td>{{$data->passport_no}} </td>
    
    </tr>
<tr>
      <td><b>Nationality</b></td>
      <td>{{$data->nationality}} </td>
    
    </tr>

    <tr>
      <td><b>Marital Status</b></td>
      <td>{{$data->marital_status}} </td>
    
    </tr>

     <tr>
      <td><b>Language/s</b></td>
      <td>
<?php
          $language=unserialize($data->language);
    ?>
       @foreach($language as $languages)  
       {{$languages}}, @endforeach
      </td>
    
    </tr>

  <!--    <tr>
      <td><b>Hobbies</b></td>
      <td>
        <?php
          $hobbies=unserialize($data->hobbies);
    ?>
       @foreach($hobbies as $languages)  
       {{$languages['hobbies']}}, 
       @endforeach

         </td>
    
    </tr> -->
   <tr>
      <td><b>Address </b></td>
      <td>{{$data->address_line_first}}, {{$data->city}}, {{$data->dist}}, {{$data->state}}, {{$data->pin_code}} </td>
    
    </tr>
</table>

<?php
$employment_data=$data->employment;

 ?>
 @if($employment_data!='')
<h6>Employment</h6>
<table class="table">
  
   

  <?php
$employment=unserialize($data->employment);
$i=1;
  ?>
  @foreach($employment as $row=>$col)
  <tr>
<td colspan="4">Employer {{$i}} </td>
  </tr>
<tr>
  <td><b>Employer Name</b></td>
  <td>{{$col['employer_name']}}</td>

  <td><b>Location</b></td>
  <td>{{$col['location']}}</td>
</tr>
<tr>
  <td><b>Designation</b></td>
  <td>{{$col['designation']}}</td>

  <td><b>Start Date</b></td>
  <td>{{$col['date_from']}}</td>
</tr>
<tr>
  <td><b>End Date</b></td>
  <td>{{$col['date_to']}}</td>

  <td><b>Salary</b></td>
  <td>{{$col['notice_period']}}</td>
</tr>
<tr>


  <td><b>Remarks</b></td>
  <td>{{$col['remarks']}}</td>
</tr>
<?php

$i++;
  ?>
 @endforeach

</table>
@endif
<!---->
<h6>DOC</h6>
<table class="table">
  
  
  

    <tr>
      <td><b>Bank Account Name</b></td>
      <td>{{$data->account_name}}</td>
     <td><b>Bank Account No.</b></td>
      <td>{{$data->account_no}} </td>
    </tr>

<tr>
      <td><b>Bank Name</b></td>
      <td>{{$data->bankname}} </td>
     <td><b>IFSC Code</b></td>
      <td>{{$data->ifsc}} </td>
    </tr>



<tr>
      <td><b>Aadhar No</b></td>
      <td>{{$data->aadhar_no}} </td>
     <td><b>PAN No</b></td>
      <td>{{$data->pan_no}} </td>
    </tr>


    <tr>
      <td><b>DOB</b></td>
      <td>{{$data->dob}} </td>
      <td><b>Blood Group</b></td>
      <td>{{$data->blood_group}} </td>
    </tr>


<tr>
      <td><b>UAN No</b></td>
      <td>{{$data->un_no}} </td>
      <td><b>ESI No</b></td>
      <td>{{$data->esi_no}} </td>
    </tr>

 


 <tr>
      <td><b>Blood Group</b></td>
      <td>{{$data->blood_group}} </td>
      <td><b>Self attested Aadhar card</b></td>
      <td>@if($data->doc_aadhar!='')
      <a href="{{url('public/uploads/documents/'.$data->doc_aadhar)}}" target="_blank">View Uploaded</a>
      @endif </td>
    
    </tr>


    <tr>
      <td><b>Passport Photo</b></td>
      <td>@if($data->photograph!='')
      <a href="{{url('public/uploads/documents/'.$data->photograph)}}" target="_blank">View Uploaded</a>
      @endif</td>
      <td><b>Self attested PAN card</b></td>
      <td>
@if($data->doc_pan!='')
      <a href="{{url('public/uploads/documents/'.$data->doc_pan)}}" target="_blank">View Uploaded</a>
      @endif
      </td>
    </tr>


   <tr>
      <td><b>Self attested  last two qualifications</b></td>
      <td>
       @if($data->doc_qualification!='')
      <a href="{{url('public/uploads/documents/'.$data->doc_qualification)}}" target="_blank">View Uploaded</a>
      @endif 

         </td>
    <td><b>Self attested copies of key certifications </b></td>
      <td> @if($data->doc_certification !='')
      <a href="{{url('public/uploads/documents/'.$data->doc_certification)}}" target="_blank">View Uploaded</a>
      @endif</td>
    </tr> 
 
</table>
<!---->
</div>


</div>
</div>
</div>

@endif
<!---->


</div>

<!-- /.card-body -->
</div>
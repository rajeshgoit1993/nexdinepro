@extends("layouts.backend.master")

@section('maincontent')
<style>
 

  </style>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style type="text/css">
@import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");
.form-outer {
    width: 100%;
    overflow: hidden;
}
 .form-outer form {
    display: flex;
    width: calc(100% * var(--stepNumber));
}
.form-outer form .page {
    width: calc(100% / var(--stepNumber));
    transition: margin-left 0.3s ease-in-out;
}
.form-outer form .page .title {
    text-align: left;
    font-size: 25px;
    font-weight: 500;
}
.form-outer form .page .field {
    width: var(--containerWidth);
    height: 45px;
    margin: 45px 0;
    display: flex;
    position: relative;
}
form .page .field .label {
    position: absolute;
    top: -30px;
    font-weight: 500;
}
form .page .field input {
    box-sizing: border-box;
    height: 100%;
    width: 100%;
    border: 1px solid var(--inputBorderColor);
    border-radius: 5px;
    padding-left: 15px;
    margin: 0 1px;
    font-size: 18px;
    transition: border-color 150ms ease;
}
.invalid-input {
    border-color:red
}
form .page .field select {
    width: 100%;
    padding-left: 10px;
    font-size: 17px;
    font-weight: 500;
}
/*form .page .field button {
    width: 100%;
    height: calc(100% + 5px);
    border: none;
    background: var(--secondary);
    margin-top: -20px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: 0.5s ease;
}*/
/*form .page .field button:hover {
    background: #000;
}*/
/*form .page .btns button {
    margin-top: -20px !important;
}*/
/*form .page .btns button.prev {
    margin-right: 3px;
    font-size: 17px;
}*/
form .page .btns button.next {
    margin-left: 3px;
}
.progress-bar_new {
    display: flex;
    margin: 40px 0;
    user-select: none;
    color: black !important;
}
 .progress-bar_new .step {
    text-align: center;
    width: 100%;
    position: relative;
}
 .progress-bar_new .step p {
    font-weight: 500;
    font-size: 14px !important;
    color: #000;
    margin-bottom: 8px;
}
 .step .bullet {
    height: 30px;
    width: 30px;
    border: 2px solid #000;
    display: inline-block;
    border-radius: 50%;
    position: relative;
    transition: 0.2s;
    font-weight: 500;
    font-size: 17px;
    line-height: 25px;
}
.progress-bar_new .step .bullet.active_new {
    border-color: var(--primary);
    background: var(--primary);
}
.progress-bar_new .step .bullet span {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}
.box
{
    width: 100% ;
}
.progress-bar_new .step .bullet.active_new span {
    display: none;
}
.progress-bar_new .step .bullet:before,
.progress-bar_new .step .bullet:after {
    position: absolute;
    content: "";
    bottom: 11px;
    right: -61px;
    height: 3px;
    width: 100%;
    background: #262626;
}
.progress-bar_new .step .bullet.active_new:after {
    background: var(--primary);
    transform: scaleX(0);
    transform-origin: left;
    animation: animate 0.3s linear forwards;
}
@keyframes animate {
    100% {
        transform: scaleX(1);
    }
}
.progress-bar_new .step:last-child .bullet:before,
.progress-bar_new .step:last-child .bullet:after {
    display: none;
}
.progress-bar_new .step p.active_new {
    color: var(--primary);
    transition: 0.2s linear;
}
.progress-bar_new .step .check {
    position: absolute;
    left: 50%;
    top: 64%;
    font-size: 15px;
    transform: translate(-50%, -50%);
    display: none;
}
.progress-bar_new .step .check.active_new {
    display: block;
    color: #fff;
}
@media screen and (max-width: 660px) {
    :root {
        --containerWidth: 400px;
    }
    .progress-bar_new .step p {
        display: none;
    }
    .progress-bar_new .step .bullet::after,
    .progress-bar_new .step .bullet::before {
        display: none;
    }
    .progress-bar_new .step .bullet {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .progress-bar_new .step .check {
        position: absolute;
        left: 50%;
        top: 50%;
        font-size: 15px;
        transform: translate(-50%, -50%);
        display: none;
    }
    .step {
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

@media screen and (max-width: 490px) {
   
 
}
.form-outer
{

  color: black !important;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<div class="flex-container">
<?php
$request_segment=Request::segment(1);

 ?>





@if($request_segment=='Edit-Account')
<div class="flex-item-left"><h5>Edit User</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_dept_employee')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>

@elseif($request_segment=='Edit-Vendor-Account')
<div class="flex-item-left"><h5>Edit Vendor</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_vendor')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
@elseif($request_segment=='Edit-Franchise-Staff')
<div class="flex-item-left"><h5>Edit Staff</h5></div>
<div class="flex-item-right"><a href="{{URL::route('manage_staff')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
@else
<div class="flex-item-left"><h5>Edit User</h5></div>
<div class="flex-item-right"><a href="{{URL::route('user_account')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
@endif

</div>


</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->

<!---->

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<div class="card">
<div class="card-header">
    @if($request_segment=='Edit-Account')
<h3 class="card-title">Employee Registration Details</h3>
    @elseif($request_segment=='Edit-Vendor-Account')
    <h3 class="card-title">Vendor Registration Details</h3>
    @elseif($request_segment=='Edit-Franchise-Staff')
    <h3 class="card-title">Staff Registration Details</h3>
    @else
    <h3 class="card-title">Employee Registration Details</h3>
    @endif


</div>
<!-- /.card-header -->

<!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
<div id="accordion">
<div class="card card-primary">
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
Basic Details
</a>
</h4>
</div>
<div id="collapseOne" class="collapse" data-parent="#accordion" style="">
<div class="card-body">
<table class="table table-bordered">

<tr>
<td><b>User ID</b></td>
<td>{{$uers_data->email}}</td>
<td><b>Name</b></td>
<td>{{$uers_data->name}}</td>
</tr>
<tr>
<td><b>Mobile No</b></td>
<td>{{$uers_data->mobile}}</td>
<td><b>DOB</b></td>
<td>{{$uers_data->birthday}}</td>
</tr>
<tr>

<td><b>Role</b></td>
<td>
  @foreach($all_roles as $role)
@foreach($user_roles as $user_role) 
@if($user_role->role_id==$role->id) 
{{$role->name}}
@endif 

@endforeach
  @endforeach

 </td>
<td><b>State</b></td>
<td>{{$uers_data->state}}</td>
</tr>
<tr>
<td><b>Dist</b></td>
<td>{{$uers_data->dist}}</td>
<td><b>City</b></td>
<td>{{$uers_data->city}}</td>
</tr>
<tr>
<td><b>Address</b></td>
<td colspan="3">{{$uers_data->address}}</td>

</tr>

</table>
</div>
</div>
</div>
<div class="card card-danger">
<div class="card-header">
<h4 class="card-title w-100">
<a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
Extra Details
</a>
</h4>
</div>
<div id="collapseTwo" class="collapse" data-parent="#accordion">
<div class="card-body">

<div class="">
<div class="col-lg-12">
 <div class="">
  <div class="progress-bar_new">
                <div class="step">
                    <p>Professional Summary</p>
                    <div class="bullet">
                        <span>1</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
             
                <div class="step">
                    <p> Education</p>
                    <div class="bullet">
                        <span>2</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p> Certifications</p>
                    <div class="bullet">
                        <span>3</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p> Extra  skills</p>
                    <div class="bullet">
                        <span>4</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p> Personal Details</p>
                    <div class="bullet">
                        <span>5</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
               <!--   <div class="step">
                    <p>  Experience</p>
                    <div class="bullet">
                        <span>7</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div> -->
                <div class="step">
                    <p>   Employment</p>
                    <div class="bullet">
                        <span>6</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                 <div class="step">
                    <p>   Doc</p>
                    <div class="bullet">
                        <span>7</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
            </div>
            <!---->
 <div class="form-outer">
                {!! Form::open(["files"=>true,'route'=>'store_user_data','name'=>'store_user_data','id'=>'store_user_data'])!!}
@if($request_segment=='Edit-Account')
<input type="hidden" name="level" value="1">
<input type="hidden" name="user_id" value="{{$uers_data->id}}">
 <?php  
$sentinel_user=Sentinel::findById($uers_data->id);
$status=$sentinel_user->status;

 ?>

 <?php  
$data=DB::table('user_extra_details')->where('store_id','=',$uers_data->id)->first();

 ?>
@if($data=='')
    @include('admin.multidepartmentuser.user_extra_part_create')

@else
  @include('admin.multidepartmentuser.user_extra_part_edit')
@endif

@elseif($request_segment=='Edit-Franchise-Staff')
<input type="hidden" name="level" value="3">
<input type="hidden" name="user_id" value="{{$uers_data->id}}">
 <?php  
$sentinel_user=Sentinel::findById($uers_data->id);
$status=$sentinel_user->status;

 ?>

 <?php  
$data=DB::table('user_extra_details')->where('store_id','=',$uers_data->id)->first();

 ?>
@if($data=='')
    @include('admin.multidepartmentuser.user_extra_part_create')

@else
  @include('admin.multidepartmentuser.user_extra_part_edit')
@endif

@elseif($request_segment=='Edit-Vendor-Account')

<input type="hidden" name="level" value="2">
<input type="hidden" name="user_id" value="{{$uers_data->id}}">
 <?php  
$sentinel_user=Sentinel::findById($uers_data->id);
$status=$sentinel_user->status;

 ?>

 <?php  
$data=DB::table('user_extra_details')->where('store_id','=',$uers_data->id)->first();

 ?>
@if($data=='')
    @include('admin.multidepartmentuser.user_extra_part_create')

@else
  @include('admin.multidepartmentuser.user_extra_part_edit')
@endif


@else
<input type="hidden" name="level" value="0">
 <?php  
$sentinel_user=Sentinel::findById($uers_data->id);
$status=$sentinel_user->status;

 ?>
 @if($status==1)
 <?php  
$data=DB::table('user_extra_details')->where('store_id','=',$uers_data->id)->first();

 ?>

<input type="hidden" name="user_id" value="{{$uers_data->id}}">
@if($data=='')
    @include('admin.multidepartmentuser.user_extra_part_create')

@else
  @include('admin.multidepartmentuser.user_extra_part_edit')
@endif




                        <!---->
 @elseif($status==2)


  @endif
@endif



              {!! Form::close() !!}
            </div>

            <!---->
 </div> 



</div>

</div>

</div>
</div>
</div>

<!---->
 


<!-- /.card-body -->
</div>







<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>
@endsection
@section('custom_js')
<!-- <script src="{{asset('/resources/assets/admin-lte/plugins/jsgrid/demos/db.js')}}"></script> -->
<script src="{{asset('/resources/assets/admin-lte/plugins/jsgrid/jsgrid.min.js')}}"></script>
<!-- <script src="{{asset('/resources/assets/admin-lte/js/form_validation.js')}}"></script> -->
<script type="text/javascript">
	//
	 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 	// 
 	$(document).on("change","#state",function(){
var state_id=$('option:selected', this).attr('state_id')
 $("#overlay").fadeIn(300);
   var APP_URL=$("#APP_URL").val();
   $.ajax({
        url:APP_URL+'/get_dist',
        data:{state_id:state_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
          $("#dist").html('').html(data)
           $("#city").html('').html('<option value="">--Select City--</option>')
      
        },
        error:function(data)
        {

        }
    })


})
$(document).on("change","#dist",function(){
var dist_id=$('option:selected', this).attr('dist_id')
$("#overlay").fadeIn(300);
   var APP_URL=$("#APP_URL").val();
   $.ajax({
        url:APP_URL+'/get_city',
        data:{dist_id:dist_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
          $("#city").html('').html(data)
           
      
        },
        error:function(data)
        {

        }
    })


}) 
$('.partener_check').click(function(){
    if (this.checked) {
      $(".dynamic_seven").css("display","none")
     $(".add_custom_required").each(function() {
    $(this).attr("required",false)
});

   
  
}
 else
    {
      $(".dynamic_seven").css("display","block")
      
       $(".add_custom_required").each(function() {
    $(this).attr("required",true)
          });
     

      }
})
</script>
<script type="text/javascript">
        initMultiStepForm();

function initMultiStepForm() {
    const progressNumber = document.querySelectorAll(".step").length;
    const slidePage = document.querySelector(".slide-page");
    const submitBtn = document.querySelector(".submit");
    const progressText = document.querySelectorAll(".step p");
    const progressCheck = document.querySelectorAll(".step .check");
    const bullet = document.querySelectorAll(".step .bullet");
    const pages = document.querySelectorAll(".page");
    const nextButtons = document.querySelectorAll(".next");
    const prevButtons = document.querySelectorAll(".prev");
    const stepsNumber = pages.length;

    if (progressNumber !== stepsNumber) {
        console.warn(
            "Error, number of steps in progress bar do not match number of pages"
        );
    }

    document.documentElement.style.setProperty("--stepNumber", stepsNumber);

    let current = 1;

    for (let i = 0; i < nextButtons.length; i++) {
        nextButtons[i].addEventListener("click", function (event) {
            event.preventDefault();

            inputsValid = validateInputs(this);
            // inputsValid = true;

            if (inputsValid) {
                //

       $("#overlay").fadeIn(300);
  var form_data = new FormData($("#store_user_data")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/store_user_data_step',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {

         
            $("#overlay").fadeOut(300);
        

        },
        error:function(data)
        {

        }
    })
                 //
                slidePage.style.marginLeft = `-${
                    (100 / stepsNumber) * current
                }%`;
                bullet[current - 1].classList.add("active_new");
                progressCheck[current - 1].classList.add("active_new");
                progressText[current - 1].classList.add("active_new");
                current += 1;



            }
        });
    }

    for (let i = 0; i < prevButtons.length; i++) {
        prevButtons[i].addEventListener("click", function (event) {
            event.preventDefault();
            slidePage.style.marginLeft = `-${
                (100 / stepsNumber) * (current - 2)
            }%`;
            bullet[current - 2].classList.remove("active_new");
            progressCheck[current - 2].classList.remove("active_new");
            progressText[current - 2].classList.remove("active_new");
            current -= 1;
        });
    }
    submitBtn.addEventListener("click", function () {
        inputsValid = validateInputs(this);
        if (inputsValid) {

        bullet[current - 1].classList.add("active_new");
        progressCheck[current - 1].classList.add("active_new");
        progressText[current - 1].classList.add("active_new");
        current += 1;

        // setTimeout(function () {
        //     alert("Your Form Successfully Signed up");
        //     location.reload();
        // }, 800);
        }
       
    });

    function validateInputs(ths) {
        let inputsValid = true;

        const inputs =
            ths.parentElement.parentElement.querySelectorAll(".valid");
        for (let i = 0; i < inputs.length; i++) {
            const valid = inputs[i].checkValidity();
            if (!valid) {
                inputsValid = false;
                inputs[i].classList.add("invalid-input");
            } else {
                inputs[i].classList.remove("invalid-input");
            }
        }
        return inputsValid;
    }
}

</script>
 <script>

  //
   $('#add_measurement').click(function(e){
    e.preventDefault()
var name_count1=$(".dynamic_third").children("div:last").attr("id").slice(8)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_third").append('<div id="thirdrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-5"><input type="text" name="primary_skil['+name_count+'][com]"  class="form-control"  placeholder="Competency"></div><div class="col-md-3"><input type="text" name="primary_skil['+name_count+'][exp]"  class="form-control"  placeholder="Experience (Years)"></div><div class="col-md-3"><input type="text" name="primary_skil['+name_count+'][self]"  class="form-control"  placeholder="Self-Assessment (Out of 10)"></div><div class="col-md-1"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_third" style="margin-bottom: 5px">X</button></div></div></div>');


 })
 //
 $(document).on('click', '.btn_remove_third', function() {
      var button_id = $(this).attr("id");
      $('#thirdrow'+button_id+'').remove();
      }
      );
 //dynamic_second
   $('#add_measurement_second').click(function(e){
    e.preventDefault()
var name_count1=$(".dynamic_second").children("div:last").attr("id").slice(9)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_second").append('<div id="secondrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-5"><input type="text" name="secondry_skil['+name_count+'][com]"  class="form-control"  placeholder="Competency"></div><div class="col-md-3"><input type="text" name="secondry_skil['+name_count+'][exp]"  class="form-control"  placeholder="Experience (Years)"></div><div class="col-md-3"><input type="text" name="secondry_skil['+name_count+'][self]"  class="form-control"  placeholder="Self-Assessment (Out of 10)"></div><div class="col-md-1"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_second" style="margin-bottom: 5px">X</button></div></div></div>');


 })
 //
 $(document).on('click', '.btn_remove_second', function() {
      var button_id = $(this).attr("id");
      $('#secondrow'+button_id+'').remove();
      }
      );
 //add certifications
  $('#add_certification').click(function(e){
    e.preventDefault()
var name_count1=$(".dynamic_four").children("div:last").attr("id").slice(7)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_four").append('<div id="fourrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-5"><input type="text" name="certification['+name_count+'][certification]"  class="form-control"  placeholder="Certification"></div><div class="col-md-4"><input type="text" name="certification['+name_count+'][year]"  class="form-control"  placeholder="Year/Month"></div><div class="col-md-3"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_four" style="margin-bottom: 5px">x Remove </button></div></div></div>');


 })
 //
 $(document).on('click', '.btn_remove_four', function() {
      var button_id = $(this).attr("id");
      $('#fourrow'+button_id+'').remove();
      }
      );
 //add_education
   $('#add_education').click(function(e){
    e.preventDefault()
var name_count1=$(".dynamic_ten").children("div:last").attr("id").slice(6)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_ten").append('<div id="tenrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-2"><input type="text" name="education['+name_count+'][qualification]"  class="form-control"  placeholder="Qualification"></div><div class="col-md-2"><input type="text" name="education['+name_count+'][degree]"  class="form-control"  placeholder="Degree"></div><div class="col-md-2"><input type="text" name="education['+name_count+'][grade]"  class="form-control"  placeholder="Percentage/Grade"></div><div class="col-md-2"><input type="text" name="education['+name_count+'][institution]"  class="form-control"  placeholder="Institution"></div><div class="col-md-2"><input type="text" name="education['+name_count+'][year]"  class="form-control"  placeholder="Year"></div><div class="col-md-2"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_ten" style="margin-bottom: 5px">x Remove </button></div></div></div>');


 })
 //
 $(document).on('click', '.btn_remove_ten', function() {
      var button_id = $(this).attr("id");
      $('#tenrow'+button_id+'').remove();
      }
      );

 //Other Accomplishments
   $('#add_other_accomplishments').click(function(e){
    e.preventDefault()

var name_count1=$(".dynamic_five").children("div:last").attr("id").slice(7)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_five").append('<div id="fiverow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-5"><input type="text" name="other_accomplishments['+name_count+'][other_accomplishments]"  class="form-control"  placeholder="Accomplishments"></div><div class="col-md-4"><input type="text" name="other_accomplishments['+name_count+'][year]"  class="form-control"  placeholder="Year/Month"></div><div class="col-md-3"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_five" style="margin-bottom: 5px">x Remove </button></div></div></div>');


 })
 //
 $(document).on('click', '.btn_remove_five', function() {
      var button_id = $(this).attr("id");
      $('#fiverow'+button_id+'').remove();
      }
      );
 //soft skills
  $('#add_softskills').click(function(e){
    e.preventDefault()

var name_count1=$(".dynamic_a").children("div:last").attr("id").slice(4)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_a").append('<div id="arow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-9"><input type="text" name="softskills['+name_count+'][softskills]"  class="form-control"  placeholder="Soft Skills"></div><div class="col-md-3"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_a" style="margin-bottom: 5px">x Remove </button></div></div></div>');


 })
 //
 $(document).on('click', '.btn_remove_a', function() {
      var button_id = $(this).attr("id");
      $('#arow'+button_id+'').remove();
      }
      );
 //strength
  $('#add_strength').click(function(e){
    e.preventDefault()

var name_count1=$(".dynamic_b").children("div:last").attr("id").slice(4)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_b").append('<div id="brow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-9"><input type="text" name="strengths['+name_count+'][strengths]"  class="form-control"  placeholder="Strengths"></div><div class="col-md-3"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_b" style="margin-bottom: 5px">x Remove </button></div></div></div>');


 })
 //
 $(document).on('click', '.btn_remove_b', function() {
      var button_id = $(this).attr("id");
      $('#brow'+button_id+'').remove();
      }
      );
 //Hobbies/Interests
  $('#add_hobbies').click(function(e){
    e.preventDefault()

var name_count1=$(".dynamic_c").children("div:last").attr("id").slice(4)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_c").append('<div id="crow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-9"><input type="text" name="hobbies['+name_count+'][hobbies]"  class="form-control"  placeholder="Hobbies/Interests"></div><div class="col-md-3"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_c" style="margin-bottom: 5px">x Remove </button></div></div></div>');


 })
 //
 $(document).on('click', '.btn_remove_c', function() {
      var button_id = $(this).attr("id");
      $('#crow'+button_id+'').remove();
      }
      );
  </script>

  <!---->
  <script type="text/javascript">
    //
    
  //
 $('#add_exp').click(function(e){
    e.preventDefault()
var name_count1=$(".dynamic_six").children("div:last").attr("id").slice(6)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_six").append('<div id="sixrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-2"><label>Project</label><input type="text" name="experience['+name_count+'][project]"  class="form-control"  placeholder="Project"></div><div class="col-md-2"><label>Client Name</label><input type="text" name="experience['+name_count+'][client_name]"  class="form-control"  placeholder="Client Name"></div><div class="col-md-2"> <label>Location</label><input type="text" name="experience['+name_count+'][location]"  class="form-control"  placeholder="Location"></div><div class="col-md-3"><label>Role</label><input type="text" name="experience['+name_count+'][role]"  class="form-control"  placeholder="Role"></div><div class="col-md-3"><label>Responsibilities</label><input type="text" name="experience['+name_count+'][responsibilities]"  class="form-control"  placeholder="Responsibilities"></div><div class="col-md-3"><label>Start Date</label><input type="text" name="experience['+name_count+'][date_from]"  class="form-control datepicker datepicrwo'+name_count+'"  placeholder="dd-mm-yy" readonly="" style="background: white !important"></div><div class="col-md-3"><label>End Date</label><input type="text" name="experience['+name_count+'][date_to]"  class="form-control datepicker datepicrwodd'+name_count+'"  placeholder="dd-mm-yy" readonly="" style="background: white !important"></div> <div class="col-md-3"><label>Key Technologies</label><input type="text" name="experience['+name_count+'][key_technologies]"  class="form-control"  placeholder="Key Technologies"></div><div class="col-md-3"><label>Environment</label><input type="text" name="experience['+name_count+'][environment]"  class="form-control"  placeholder="Environment"></div><div class="col-md-11"><label>Description</label><textarea name="experience['+name_count+'][description]" class="form-control"></textarea></div><div class="col-md-1"><label style="visibility: hidden;">Button</label><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_six" ><span class="fa fa-times"></span></button></div></div></div>');


    
     $('.datepicrwo'+name_count).each(function(){
     $(this).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy (D)',
            
        });
   });
      $('.datepicrwodd'+name_count).each(function(){
     $(this).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy (D)',
            
        });
   });
$('body').on('focus',".datepicker", function(){
    $(this).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy (D)',
            
        });
    });

  })
 //
  $(document).on('click', '.btn_remove_six', function() {
      var button_id = $(this).attr("id");
      $('#sixrow'+button_id+'').remove();
      }
      );
 //
$('#add_employer').click(function(e){
    e.preventDefault()
var name_count1=$(".dynamic_seven").children("div:last").attr("id").slice(8)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_seven").append('<div id="sevenrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-3"><label>Company Name</label><input type="text" name="employment['+name_count+'][employer_name]"  class="form-control"  placeholder="Company Name"></div><div class="col-md-3"><label>Location</label><input type="text" name="employment['+name_count+'][location]"  class="form-control"  placeholder="Location"></div><div class="col-md-3"> <label>Designation</label><input type="text" name="employment['+name_count+'][designation]"  class="form-control"  placeholder="Designation"></div><div class="col-md-3"><label>Start Date</label><input type="date" name="employment['+name_count+'][date_from]"  class="form-control"  placeholder="Start Date"></div><div class="col-md-3"><label>End Date</label><input type="date" name="employment['+name_count+'][date_to]"  class="form-control"  placeholder="End Date"></div><div class="col-md-3"><label>Salary</label><input type="text" name="employment['+name_count+'][notice_period]"  class="form-control"  placeholder="Salary" ></div><div class="col-md-11"><label>Remarks</label><textarea name="employment['+name_count+'][remarks]" class="form-control"></textarea></div><div class="col-md-1"><label style="visibility: hidden;">Button</label><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_seven" ><span class="fa fa-times"></span></button></div></div></div>');


    
//      $('.datepicrwo'+name_count).each(function(){
//      $(this).datepicker({
//             uiLibrary: 'bootstrap4',
//             format: 'dd-mm-yyyy (D)',
            
//         });
//    });
//       $('.datepicrwodd'+name_count).each(function(){
//      $(this).datepicker({
//             uiLibrary: 'bootstrap4',
//             format: 'dd-mm-yyyy (D)',
            
//         });
//    });
// $('body').on('focus',".datepicker", function(){
//     $(this).datepicker({
//             uiLibrary: 'bootstrap4',
//             format: 'dd-mm-yyyy (D)',
            
//         });
//     });

  })

 //
 $(document).on('click', '.btn_remove_seven', function() {
      var button_id = $(this).attr("id");
      $('#sevenrow'+button_id+'').remove();
      }
      );
 //
</script>

@endsection
@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  .partener_part
  {
    display: none;
  }
</style>
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

<div class="flex-item-left"><h5>Add Factory</h5></div>




<div class="flex-item-right"><a href="{{URL::route('manage_factory')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span> Back</button></a></div>
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



 
<div class="col-lg-12">
 <div class="">
 
            <!---->
 <div class="form-outer">
   @if($request_segment=='Edit-Factory')
{!! Form::open(["files"=>true,"route"=>"update_factory"])!!}
   @else
{!! Form::open(["files"=>true])!!}
   @endif
                

<div class="page slide-page">


                       
  @include('admin.factory.basic')                
  







                                      
                        
                    </div>


                  
              


         
                    
                        <!---->
                      

  

              {!! Form::close() !!}
            </div>

            <!---->
 </div> 



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
//
$('.partener_check').click(function(){
    if (this.checked) {
      $(".partener_part").css("display","block")
     $("#rent_aggreement").attr("required",true)
      $("#rent_per_month").attr("required",true)
}
 else
    {
      $(".partener_part").css("display","none")
       $("#rent_aggreement").attr("required",false)
      $("#rent_per_month").attr("required", false)

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
 

@endsection
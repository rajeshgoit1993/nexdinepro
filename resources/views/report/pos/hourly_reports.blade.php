@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
 
    hr 
    {
      margin-top: .3rem !important;
      margin-bottom: .3rem !important;
    }
    </style>
    <style type="text/css">

.custom_chart span:after {
  display: inline-block;
  content: "";
  width: 0.8em;
  height: 0.8em;
  margin-left: 0.4em;
  height: 0.8em;
  border-radius: 0.2em;
  background: currentColor;
}
.card-title {
    float: left;
    font-size: .9rem;
    font-weight: 400;
    margin: 0;
}
  </style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


<section class="content">

<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
        <div class="flex-container" style="padding:0px">
  <div class="flex-item-left" style="padding:0px"><h5>Reports</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
@if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1) 
<form action="{{route('getdsr_mtd')}}" method="post" target="_blank">
{{csrf_field()}}  
 <div class="row">
   <div class="col-lg-2">
      <label>Select Region</label>
      <select name="region" id="region" class="form-control">
        <option value="0">All</option>
        @foreach($regions as $region)
    <option value="{{$region->id}}">{{$region->region_name}}</option>
        @endforeach
 
     </select>
      </div>
   <div class="col-lg-2">
      <label>Select City</label>
      <select name="city" id="city" class="form-control">
        <option value="0">All</option>
        @foreach($cities as $city)
    <option value="{{$city}}">{{$city}}</option>
        @endforeach
 
     </select>
      </div>
     <div class="col-lg-2">
      <label>Select Outlet</label>
      <select name="outlet" id="outlet" class="form-control">
     <option value="0">All</option>
   @include('report.pos.outlets')
     </select>
      </div>
       
      <div class="col-lg-2">
      <label>Date</label>
    <input type="date" name="date" max="{{date('Y-m-d')}}" class="form-control" id="date" value="{{date('Y-m-d')}}">
      </div>
     <div class="col-lg-2">
      <label>Start Time</label>
    <input type="time" name="start_time" max="{{date('Y-m-d')}}" class="form-control" id="start_time" value="00:00">
      </div>

    <div class="col-lg-2">
      <label>End Time</label>
    <input type="time" name="end_time" max="{{date('Y-m-d')}}" class="form-control" id="end_time" value="23:59">
      </div>

</div>
</form>
@elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')) 
<form action="{{route('getdsr_mtd')}}" method="post" target="_blank">
{{csrf_field()}}  
         <div class="row">
<input type="hidden" id="outlet" name="" value="{{Sentinel::getUser()->parent_id}}">
<input type="hidden" id="city" name="" value="NA">
<input type="hidden" id="region" name="" value="NA">
    <div class="col-lg-4">
      <label>Date</label>
    <input type="date" name="date" max="{{date('Y-m-d')}}" class="form-control" id="date" value="{{date('Y-m-d')}}">
      </div>
     <div class="col-lg-4">
      <label>Start Time</label>
    <input type="time" name="start_time" max="{{date('Y-m-d')}}" class="form-control" id="start_time" value="00:00">
      </div>

    <div class="col-lg-4">
      <label>End Time</label>
    <input type="time" name="end_time" max="{{date('Y-m-d')}}" class="form-control" id="end_time" value="23:59">
      </div>

  


</div>
</form>
@endif
</div>
</section>


<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
<div class="row">
<div class="col-sm-6">

<a href="#"><button class="btn btn-success btn-sm find" style="width:100%"><span class="fa fa-search">  </span> Find </button></a>


 </div>
 <div class="col-sm-6">

<a href="#"><button class="btn btn-info btn-sm download" style="width:100%"><span class="fa fa-download">  </span> Download </button></a>


 </div>
<div class="col-lg-12">
<div class="dynamic_data"> </div>



 </div>











</div>

<!-- /.content -->

</div>
</section>




</div>

</div>
</section>

</div>





<!---->
@endsection
@section('custom_js')
<script type="text/javascript">
//
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  //
  </script>


<script type="text/javascript">
  //region
  $(document).on("change","#region",function(){
var region=$(this).val()
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_region_wise_data',
        data:{region:region},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        $("#city").html('').html(data.output_city)
         $("#outlet").html('').html(data.output_outlet)

        },
        error:function(data)
        {

        }
    })

})
//
$(document).on("change","#city",function(){
var city=$(this).val()
var region=$("#region").val()
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_city_wise_outlet',
        data:{city:city,region:region},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        $("#outlet").html('').html(data)

        },
        error:function(data)
        {

        }
    })

})

$(document).ready(function(){
  get_hourly_data()
})
$(document).on("click",".find",function(){
  get_hourly_data()
})
function get_hourly_data()
{
var outlet=$("#outlet").val();
var date=$("#date").val();
var city=$("#city").val();
var region=$("#region").val()  
var start_time=$("#start_time").val();
var end_time=$("#end_time").val();
  if(start_time>=end_time)
  {
 alert('Start Time should be less than End Time')
  }
  else
  {
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_hourly_data',
        data:{outlet:outlet,date:date,city:city,region:region,start_time:start_time,end_time:end_time},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
         $(".dynamic_data").html('').html(data)

        },
        error:function(data)
        {

        }
    })
  }
}

</script>  
  
<script>
//dsr_rsc_mtd
$(document).on("click",".download",function(){
var outlet=$("#outlet").val();
var date=$("#date").val();
var city=$("#city").val();
var region=$("#region").val()  
var start_time=$("#start_time").val();
var end_time=$("#end_time").val();
  if(start_time>=end_time)
  {
 alert('Start Time should be less than End Time')
  }
  else
  {
  var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "download_hourly_report";
  
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="outlet"
    element1.value = outlet;
    element1.type = 'hidden'
    form.appendChild(element1);
    
    var element2 = document.createElement("INPUT");         
    element2.name="date"
    element2.value = date;
    element2.type = 'hidden'
    form.appendChild(element2);

      var element4 = document.createElement("INPUT");         
    element4.name="city"
    element4.value = city;
    element4.type = 'hidden'
    form.appendChild(element4);
    
    var element5 = document.createElement("INPUT");         
    element5.name="region"
    element5.value = region;
    element5.type = 'hidden'
    form.appendChild(element5);

    var element3 = document.createElement("INPUT");         
    element3.name="start_time"
    element3.value = start_time;
    element3.type = 'hidden'
    form.appendChild(element3);
    form.submit(); 

    var element6 = document.createElement("INPUT");         
    element6.name="end_time"
    element6.value = end_time;
    element6.type = 'hidden'
    form.appendChild(element6);
    form.submit(); 
}

  

  })
</script>
@endsection 
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
     <div class="col-lg-4">
      <label>Select Outlet</label>
      <select name="outlet" id="outlet" class="form-control">
     <option value="0">All</option>
   @include('report.pos.outlets')
     </select>
      </div>
        <div class="col-lg-2">
      <label>Start Date</label>
    <input type="date" name="start_date" max="{{date('Y-m-d')}}" class="form-control" id="start_date" value="{{date('Y-m-d', strtotime('-1 days'))}}" >
      </div>
      <div class="col-lg-2">
      <label>End Date</label>
    <input type="date" name="end_date" max="{{date('Y-m-d')}}" class="form-control" id="end_date" value="{{date('Y-m-d')}}">
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
     <div class="col-md-6">
      <label>Start Date</label>
    <input type="date" name="start_date" max="{{date('Y-m-d')}}" class="form-control" id="start_date" value="{{date('Y-m-d', strtotime('-1 days'))}}" >
      </div>
      <div class="col-md-6">
      <label>End Date</label>
    <input type="date" name="end_date" class="form-control" max="{{date('Y-m-d')}}" id="end_date" value="{{date('Y-m-d')}}">
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
<div class="col-sm-3">
<div class="card bg-gradient-primary">
<div class="card-header">
<h3 class="card-title">DSR MTD</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default dsr_mtd">Click here DSR MTD <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>



<div class="col-sm-3">
<div class="card bg-gradient-secondary">
<div class="card-header">
<h3 class="card-title">DSR RSC MTD</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default dsr_rsc_mtd">DSR RSC MTD Report<span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>
@if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1)
<div class="col-sm-3">
<div class="card bg-gradient-success">
<div class="card-header">
<h3 class="card-title">All Restaurants Sales Summary</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default all_restaurants_sales_summary">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>
@endif

<div class="col-sm-3">
<div class="card bg-gradient-info">
<div class="card-header">
<h3 class="card-title">Customer details</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default outlet_customers">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>
@if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1)
<div class="col-sm-3">
<div class="card bg-gradient-success">
<div class="card-header">
<h3 class="card-title">Discount Summary Report</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default discount_summary">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>


@endif

<div class="col-sm-3">
<div class="card bg-gradient-danger">
<div class="card-header">
<h3 class="card-title">Discount Report</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default detail_discount">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>

<div class="col-sm-3">
<div class="card bg-gradient-info">
<div class="card-header">
<h3 class="card-title">Bill Wise Report</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default bill_wise">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>


<div class="col-sm-3">
<div class="card bg-gradient-primary">
<div class="card-header">
<h3 class="card-title">Item wise transection</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default item_wise_transection">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>


<div class="col-sm-3">
<div class="card bg-gradient-secondary">
<div class="card-header">
<h3 class="card-title">Item wise Sale Details</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default item_wise_sale_details">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>


<div class="col-sm-3">
<div class="card bg-gradient-info">
<div class="card-header">
<h3 class="card-title">Menu Mix Details</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default menu_mix">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>


<div class="col-sm-3">
<div class="card bg-gradient-success">
<div class="card-header">
<h3 class="card-title">Monthend Void Report</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default void_report">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
</div>



<div class="col-sm-3">
<div class="card bg-gradient-secondary">
<div class="card-header">
<h3 class="card-title">Inventory Valuation</h3>
</div>

<div class="card-footer">
<button class="btn btn-sm btn-default inventory_valuation">Click here For Report <span class="fa fa-arrow-right"> </span></button>
</div>
</div>
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
  </script>

  
  
@include('report.pos.report_js.dsr_mtd')
@include('report.pos.report_js.dsr_rsc')
@include('report.pos.report_js.detail_discount') 
@include('report.pos.report_js.outlet_customers')
@if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1)


@include('report.pos.report_js.discount_summary')
@include('report.pos.report_js.all_restaurants_sales_summary')

@endif  

@include('report.pos.report_js.bill_wise')
@include('report.pos.report_js.item_wise_transection')
@include('report.pos.report_js.item_wise_sale_details')
@include('report.pos.report_js.menu_mix')
@include('report.pos.report_js.void_report')
@include('report.pos.report_js.inventory_valuation')

@endsection 
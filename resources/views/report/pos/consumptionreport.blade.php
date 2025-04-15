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
  </style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">

<div class="container-fluid">
<div class="row">
  <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
        <div class="flex-container" style="padding:0px">
  <div class="flex-item-left" style="padding:0px"><h5>Consumption Report</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
@if(Sentinel::getUser()->inRole('superadmin')) 
 <div class="row">

     <div class="col-lg-3">
      <label>Select Outlet</label>
   <select name="outlet" id="outlet" class="form-control">
    <option value="0">All</option>
     @foreach($data as $datas)
     <option value="{{$datas->id}}">{{ $datas->name }}</option>
     @endforeach 
   </select>
      </div>
        <div class="col-lg-3">
      <label>Start Date</label>
    <input type="date" name="start_date" class="form-control" id="start_date" value="{{date('Y-m-d', strtotime('-30 days'))}}" >
      </div>
      <div class="col-lg-3">
      <label>End Date</label>
    <input type="date" name="end_date" class="form-control" id="end_date" value="{{date('Y-m-d')}}">
      </div>

      <div class="col-lg-3">
        <label style="visibility:hidden;">NA</label>
<button class="btn btn-success btn-block find">Find</button>

        </div>


</div>
@elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise'))   
         <div class="row">

     <div class="col-md-5">
      <label>Start Date</label>
    <input type="date" name="start_date" class="form-control" id="start_date" value="{{date('Y-m-d', strtotime('-30 days'))}}" >
      </div>
      <div class="col-md-5">
      <label>End Date</label>
    <input type="date" name="end_date" class="form-control" id="end_date" value="{{date('Y-m-d')}}">
      </div>

      <div class="col-md-2">
        <label style="visibility:hidden;">NA</label>
<button class="btn btn-success btn-block find">Find</button>

        </div>


</div>

@endif
</div>
</section>

  
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
<div class="table-responsive">
  <table class="table table-bordered yajra-datatable">
        <thead>
    <tr>
      <th>S.No.</th>
       <th>Ingredient Name(Code)</th>
      <th>Quantity/Rate</th>
     
      
      <th>Total Cost</th>
      
   
   
    </tr>
  
  </thead>
   <tbody>
   
    </tbody>
    </table>



<!-- /.content -->
</div>
</div>
</section>

</div>

</div>
</section>

</div>





 
<!---->
@endsection
@section('custom_js')

<script>
  $(function () {

  

    //
  })

</script>
<script type="text/javascript">
  //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //



$(document).ready(function(){

get_data('change')

})

$(document).on("click",".find",function()
{
get_data('change')
})





</script>

@if(Sentinel::getUser()->inRole('superadmin')) 

<script type="text/javascript">
  function get_data($statesave)
{
var start_date=$("#start_date").val();
var end_date=$("#end_date").val();
var outlet=$("#outlet").val();
// var APP_URL=$("#APP_URL").val();


if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

    
    //
 var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('getconsumptionreport') }}",
        data: {start_date:start_date,end_date:end_date,outlet:outlet},
    },
      
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'ingredient_name', name: 'ingredient_name'},
            {data: 'qty_rate', name: 'qty_rate'},
            {data: 'total_cost', name: 'total_cost'},
           
       
        ]

    });


   
}

</script>
@elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise'))   
<script type="text/javascript">
  function get_data($statesave)
{
var start_date=$("#start_date").val();
var end_date=$("#end_date").val();
var outlet='NA';
// var APP_URL=$("#APP_URL").val();


if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

    
    //
 var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('getconsumptionreport') }}",
        data: {start_date:start_date,end_date:end_date,outlet:outlet},
    },
      
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'ingredient_name', name: 'ingredient_name'},
            {data: 'qty_rate', name: 'qty_rate'},
            {data: 'total_cost', name: 'total_cost'},
           
       
        ]

    });


   
}




</script>

@endif
@endsection
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
  <div class="flex-item-left" style="padding:0px"><h5>Outlet Menu Price</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
@if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1) 

 <div class="row">

     <div class="col-lg-9">
      <label>Select Outlet</label>
      <select name="outlet" id="outlet" class="form-control">
  @include('report.pos.outlets')
    </select>
      </div>
       
      <div class="col-lg-3"> 
        <div class="">
      <div class="row admin_report">
     <div class="col-lg-12">
        <label style="visibility:hidden;">NA</label>
<button class="btn btn-success btn-block find">Find</button>

        </div>



</div>
 </div>
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
      <th>Outlet Details</th>
       <th>Food Menu Category</th>
      <th>Price</th>
     
    
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



//

</script>

@if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1) 

<script type="text/javascript">
  function get_data($statesave)
{

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
        url: "{{ route('getoutletmenuprice') }}",
        data: {outlet:outlet},
    },
      
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'outlet_details', name: 'outlet_details'},
            {data: 'category', name: 'category'},
            {data: 'price', name: 'price'}
          
           
       
        ]

    });


   
}

</script>


@endif
@endsection
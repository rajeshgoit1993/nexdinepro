@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Transport Charge List</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('add_transport')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Transport Charge</button></a></div>
</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th width="50px">S.No.</th>
                <th>State</th>
                <th>Dist</th>
                 <th>City</th>
                  <th>Unit</th>
                   <th>Fee</th>
                   <th>GST</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>










<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>
@endsection
@section('custom_js')
<script type="text/javascript">
	  //
$(document).on("click",".remove",function(){
   var r = confirm("Are you sure ?");

     
       if (r === false) {
           return false;
        }
})
  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        url: "{{ route('transport') }}",
        data: {a:'2'},
       
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'state', name: 'state'},
            {data: 'dist', name: 'dist'},
            {data: 'city', name: 'city'},
            {data: 'unit', name: 'unit'},
            {data: 'fee', name: 'fee'},
            {data: 'gst', name: 'gst'},
       
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>

@endsection
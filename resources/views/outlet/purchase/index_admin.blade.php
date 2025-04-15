@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<input type="hidden" name="val" id="val" value="{{$val}}">
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">


    <section class="col-lg-12 connectedSortable">
    <div class="card direct-chat direct-chat-primary">
  <div class="flex-container">
  <div class="flex-item-left"><h5>Purchase List</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
@if(Session::get('error'))
<div class="alert alert-danger" role="alert">
  {{ Session::get('error') }}
</div>
@endif
</div>
</section>
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th >S.No.</th>
                <th>Outlet Details</th>
                <th>Invoice No</th>
                <th>Supplier</th>
                <th>Date</th>
                <th>Total</th> 
                <th>GST Total</th>
                <th>Sub Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


 




  <!-- Edit Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">View</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
       <div class="add_body"></div>
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>

 <!-- Pushback -->
  <div class="modal fade" id="pushback_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Pushback</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class=""> 
           <div class="col-md-12">
    {!! Form::open(["files"=>true,'id'=>'pushback_daily_purchase'])!!}
       <div class="pushback_body">
         <input type="hidden" name="id" id="pushback_id" value="">  

      <div class="form-group">
<label for="" class="required">Remarks</label>
<input type="text" name="remarks" required class="form-control" value="">
</div>
       </div>
       {!! Form::submit('Submit',["class"=>"btn btn-success"]) !!}
       <br>
       <br>
       {!! Form::close() !!}
               </div>
          </div>
   
        <!-- Modal footer -->
       
        
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
@endsection
@section('custom_js')
<script type="text/javascript">
$(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})
//
</script>
<script type="text/javascript">
    //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
  $(document).on("click",".pushback",function(e){
  e.preventDefault();
  var id=$(this).attr('id')
  $("#pushback_id").val('').val(id)
$('#pushback_modal').modal('toggle');
    
  })
//
  //
      $(document).on("submit", "#pushback_daily_purchase", function (event) {

  event.preventDefault();

   $('#pushback_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#pushback_daily_purchase")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/pushback_daily_purchase',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Pushbacked', "success");
        get_data('nochange')
        
      
       }
       else
      {
        swal("Error", data, "error"); 
       
       }

        },
        error:function(data)
        {

        }
    })
});
      //




  $(document).on("click",".accept",function(){
var id=$(this).attr('id')
if(confirm("Are you sure?"))
    {
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/accept_daily_purchase',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Accepted', "success");
        get_data('nochange')
        
      
       }
       else
      {
        swal("Error", data, "error"); 
       
       }

        },
        error:function(data)
        {

        }
    })
   }
  })
     //

    //
    $(document).on("click",".view",function(){
    var id=$(this).attr('id');
    var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/view_daily_purchase',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           
          $(".add_body").html('').html(data)
         
        },
        error:function(data)
        {

        }
    })

     $('#edit_modal').modal('toggle');

    })

       //


  //
$(document).ready(function(){
get_data('change')
})
$(document).on("click",".find",function(){
  get_data('change')  
})
function get_data($statesave)
{
// var brand=$("#brand").val()
// if(brand=='')
// {
//     var brand='NA';
// }
var item_type=$("#item_type").val()
var val=$("#val").val()
if(item_type=='')
{
    var item_type='NA';
}
var brand='NA';


if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_purchase_list_admin') }}",
        data: {brand:brand,item_type:item_type,val:val},
    },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           
            {data: 'outlet_details', name: 'outlet_details'},
            {data: 'invoice_no', name: 'invoice_no'},
          
            {data: 'supplier_name', name: 'supplier_name'},
            {data: 'date', name: 'date'},
            {data: 'grand_total', name: 'grand_total'},
            {data: 'total_gst', name: 'total_gst'},
            {data: 'total_with_gst', name: 'total_with_gst'},
           
        
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });   
}
 
</script>

@endsection
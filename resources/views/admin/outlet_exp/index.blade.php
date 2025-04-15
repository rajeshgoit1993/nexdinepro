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
  <div class="flex-item-left"><h5>Manage Franchise Exp.</h5></div>
  <div class="flex-item-right"><a href="#"><button class="btn btn-success add_exp"><span class="fa fa-plus"></span> Add Exp</button></a></div>
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
        



 <div class="row">

     <div class="col-lg-3">
      <label>Select Outlet</label>
      <select name="outlet" id="outlet" class="form-control">
        <option value="0" >All</option>
     @foreach($data as $datas)
     <?php 
     $check=DB::table('franchise_sales')->where('outlet_id',$datas->id)->get();
     ?>
     <option value="{{$datas->id}}" @if(count($check)>0) style="background:green;color:white" @endif>{{CustomHelpers::get_brand_name(POS_SettingHelpers::get_brand_by_admin_id($datas->id))}} ({{$datas->city}}) {{ $datas->name }}</option>
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
                <th width="50px">S.No.</th>
                <th>Outlet Details</th>
               
               
                <th>Exp. Details</th>
                
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
//
<div class="modal fade" id="exp_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Manage Franchise Exp.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="exp_modal">
         
        </div>
        
        <!-- Modal footer -->
       
        
      </div>
    </div>
  </div>
  
@endsection
@section('custom_js')
<script type="text/javascript">
    //
// $(document).on("click",".remove",function(){
//    var r = confirm("Are you sure ?");

     
//        if (r === false) {
//            return false;
//         }
// })
  //
   //
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     //
      $(document).on("click","#add_exp",function(e){
    e.preventDefault()
var name_count1=$(".dynamic_four").children("div:last").attr("id").slice(7)
console.log(name_count1)
var name_count=parseInt(name_count1)-"1";
name_count1++
name_count++
$(".dynamic_four").append('<div id="fourrow'+name_count1+'" style="margin-top: 10px;padding-top: 10px;border-top: 1px solid lightgray"><div class="row"><div class="col-md-3"><input type="date" name="exp['+name_count+'][exp_date]"  class="form-control"  placeholder="Date" required></div><div class="col-md-3"><select class="form-control" name="exp['+name_count+'][exp_type]" required><option value="Travel">Travel</option><option value="Accommodation">Accommodation </option><option value="Food">Food </option><option value="Other">Other </option></select></div><div class="col-md-3"><input type="text" name="exp['+name_count+'][exp]"  class="form-control"  placeholder="Expense" required></div><div class="col-md-3"><button type="button" name="remove" id="'+name_count1+'" class="btn btn-danger btn_remove_four" style="margin-bottom: 5px">x Remove </button></div></div></div>');
   //

//
 })
 $(document).on('click', '.btn_remove_four', function() {
      var button_id = $(this).attr("id");
      $('#fourrow'+button_id+'').remove();
      }
      );
//
$(document).on("click",".delete",function(){
var id=$(this).attr('id')
if(confirm("Are you sure?"))
    {
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/delete_franchise_exp',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Deleted', "success");
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
      $(document).on("submit", "#update_franchise_exp", function (event) {

  event.preventDefault();

   $('#exp_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#update_franchise_exp")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/update_franchise_exp',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Updated', "success");
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

     //edit

$(document).on("click",".edit",function(){
var id=$(this).attr('id')
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/edit_franchise_exp',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".exp_modal").html('').html(data)
       $('#exp_modal').modal('toggle');

        },
        error:function(data)
        {

        }
    })
   
  })
  

     //update_first_stock
    $(document).on("submit", "#store_franchise_exp", function (event) {

  event.preventDefault();

   $('#exp_modal').modal('hide');
  $("#overlay").fadeIn(300);
   var form_data = new FormData($("#store_franchise_exp")[0]);
 var APP_URL=$("#APP_URL").val();
    $.ajax({
        url:APP_URL+'/store_franchise_exp',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Added', "success");
        get_data('nochange')
        // var url=APP_URL+'/Utensil-List';
        // window.location.href = url;
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
  $(document).on("click",".add_exp",function(){

var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/add_franchise_exp',
        data:{id:12},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {


       $(".exp_modal").html('').html(data)
       $('#exp_modal').modal('toggle');
        
        },
        error:function(data)
        {

        }
    })
   
  })
  
$(document).ready(function(){

get_data('change')

})

$(document).on("click",".find",function()
{
get_data('change')
})

  //
  function get_data($statesave)
{

var outlet=$("#outlet").val();
var start_date=$("#start_date").val();
var end_date=$("#end_date").val();

if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
   $('.yajra-datatable').DataTable().destroy()
}

     var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: $statesave,
        ajax: {
        url: "{{ route('get_franchise_exp') }}",
         data: {outlet:outlet,start_date:start_date,end_date:end_date},
    },
     
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'outlet_details', name: 'outlet_details'},
         
            {data: 'exp_details', name: 'exp_details'},
            
        ]

    });  


   
}
 
</script>

@endsection
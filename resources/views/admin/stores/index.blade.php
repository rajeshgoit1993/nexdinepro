@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
    <?php  
  $request_segments=Request::segment(1);
  ?>
   @if($request_segments=='Manage-Warehouse') 
 <input type="hidden" name="level" value="1" id="level">
	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>Warehouse List</h5></div>
  <div class="flex-item-right"><a href="{{URL::route('add_store')}}"><button class="btn btn-success"><span class="fa fa-plus"></span> Add Warehouse</button></a></div>
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
                <th>Warehouse Name</th>
               <th>Assign Person</th>
               <th>State</th>
               <th>Dist</th>
               <th>City</th>
               <th>Mob</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php  
           $i=1;
         ?>
            @foreach($datas as $data)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$data->name}}</td>
                <td>{{CustomHelpers::get_user_data(CustomHelpers::get_master_table_data('store_assign_users','store_id',$data->id,'user_id'),'name')}}</td>
                <td>{{$data->state}}</td>
                <td>{{$data->dist}}</td>
                <td>{{$data->city}}</td>
                <td>{{$data->mobile}}</td>
                <td>

                    <a href="#" class="view" data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($data->id))}}" id="{{CustomHelpers::custom_encrypt($data->id)}}"><button class="btn btn-primary"><span class="fa fa-eye"></span> View</button></a>

          <a href="#" class="edit" id="{{CustomHelpers::custom_encrypt($data->id)}}"><button class="btn btn-success"><span class="fa fa-edit"></span> Edit</button></a>
           <a href="#"><button class="btn btn-danger delete" id="{{CustomHelpers::custom_encrypt($data->id)}}"  onclick="return confirm('Are you sure?');"><span class="fa fa-archive"></span> Delete</button></a>
             
              <div class="modal fade" id="view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($data->id))}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <table class="table table-bordered">


<tr>
<td><b>Store Name</b></td>
<td>{{$data->name}}</td>
<td><b>Assign Person</b></td>
<td>{{CustomHelpers::get_user_data(CustomHelpers::get_master_table_data('store_assign_users','store_id',$data->id,'user_id'),'name')}}</td>
</tr>
<tr>
<td><b>Mob</b></td>
<td>{{$data->mobile}}</td>
<td><b>State</b></td>
<td>{{$data->state}}</td>
</tr>
<tr>
<td><b>Dist</b></td>
<td>{{$data->dist}}</td>
<td><b>City</b></td>
<td>{{$data->city}}</td>
</tr>
<tr>
<td><b>Address</b></td>
<td colspan="3">{{$data->address}}</td>

</tr>
<tr>
<td><b>Rent Aggreement</b></td>
<td> @if($data->rent_aggreement!='')  
         <a target="_blank" href="{{url('public/uploads/documents/'.$data->rent_aggreement)}}">View</a>
      @endif</td>
<td><b>Rent Per Month</b></td>
<td>Rs. {{$data->rent_per_month}}</td>
</tr>
</table>
         
        </div>
       
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

                </td>

           </tr>
            @endforeach
        </tbody>
    </table>










<!-- /.content -->
</div>
</section>
@endif
</div>

</div>
</section>

</div>
@endsection
@section('custom_js')
<script type="text/javascript">
    //
      $(document).on("click",".edit",function(){
    var level=$("#level").val()
    if(level==1)
    {
    var id=$(this).attr('id')
    var form = document.createElement("form");
    document.body.appendChild(form);
    form.method = "POST";
    form.action = "Edit-Warehouse";
    var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

    var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();
    }
    else if(level==2)
    {
        var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Edit-Warehouse";
     var element2 = document.createElement("INPUT");         
    element2.name="_token"
    element2.value = $('meta[name="csrf-token"]').attr('content')
    element2.type = 'hidden'
    form.appendChild(element2);

   var element1 = document.createElement("INPUT");         
    element1.name="id"
    element1.value = id;
    element1.type = 'hidden'
    form.appendChild(element1);
  
    form.submit();
    }
    
  

  })

	  //
 //delete 
     $(document).on("click",".delete",function(){
    var id=$(this).attr('id')
   
     var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/delete_store',
        data:{id:id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
    
         swal("Done !", 'Successfully Deleted', "success");
        setTimeout(function(){ location.reload(); }, 1000);
        },
        error:function(data)
        {

        }
    })
    })
  //

  $(function () {
    
    var table = $('.yajra-datatable').DataTable();
    
  });
</script>

@endsection
@extends("layouts.backend.master")

@section('maincontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
	
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->
  <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th width="50px">S.No.</th>
               
                <th>Description</th>
              
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>1</td>
            <td>{{$data->description}}</td>
            <td>

<div class="btn-group btn-group-toggle" data-toggle="buttons">

  <label class="btn btn-secondary">
    <input type="radio" name="status" value="1" class="status" @if($data->status==1) checked @endif> On
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="status" value="0" class="status" @if($data->status==0) checked @endif> Off
  </label>
</div>
            </td>
            </tr>
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
	$('input[type=radio][name=status]').change(function() {
        var status=$(this).val();
        var APP_URL=$("#APP_URL").val();
     $.ajax({
            url : APP_URL+'/store_setting_status',
            type: "get",
            data: {status:status},
            // processData: false,
            // contentType: false,
            // dataType: "JSON",
            success: function(data)
            {

               if(data=='success')
               {
              swal({
                  title: "Done !",
                  text: "Successfully Changed !",
                  icon: "success",
                  timer:500
                   });
          
              
               }
               else
               {
              swal("Error", data, "error"); 
               }
          
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
});
 
</script>

@endsection
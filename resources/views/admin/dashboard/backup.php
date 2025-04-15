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
@if(count($data)>0)
<div class="col-12">
        
              <div class="card-header">
                <h3 class="card-title">Acceptance Request</h3>

               
              </div>
              <!-- /.card-header -->
           <div class="table-responsive">
  <table class="table table-bordered yajra-datatable">
        <thead>
    <tr>
      <th>Login ID</th>
      
      <th>Name</th>
      <th>Mobile No</th>
      <th>State</th>
      <th>District </th>
      <th>City</th>

      <th>Actions</th>
    </tr>
  
  </thead>
   <tbody>
    <?php

$sn=1;
    ?>
    @foreach($data as $fanchise_detail)  
 


  <tr>
  <td>{{$fanchise_detail->email}}</td>
  <td><span>{{$fanchise_detail->name}}</span></td>
  <td><span>{{$fanchise_detail->mobile}}</span></td>
  <td><span>{{$fanchise_detail->state}}</span></td>
  <td><span>{{$fanchise_detail->dist}}</span></td>
  <td><span>{{$fanchise_detail->city}}</span></td>                    
                    
           
            
                   <td>

      <a href="#" class="view" data-toggle="modal" data-target="#view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-primary btn-sm"><span class="fa fa-eye"></span> View</button></a>

    @if(Sentinel::getUser()->inRole('architect'))
    <a href="#" class="architect_add" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-success btn-sm"><span class="fa fa-edit"></span> Take Action</button></a>
    
    @elseif(Sentinel::getUser()->inRole('ops'))
    <a href="#" class="operations_actions" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-success btn-sm"><span class="fa fa-edit"></span> Take Action</button></a>
    @elseif(Sentinel::getUser()->inRole('socialmedia'))
    <a href="#" class="social_media_actions" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-success btn-sm"><span class="fa fa-edit"></span> Take Action</button></a>

    @elseif(Sentinel::getUser()->inRole('procurement'))

    @elseif(Sentinel::getUser()->inRole('accounts'))
     <a href="#" class="accounts_actions" id="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}"><button class="btn btn-success btn-sm"><span class="fa fa-edit"></span> Take Action</button></a>

    @endif
 

  <div class="modal fade" id="view_modal_{{preg_replace('/[<=>]+/', '',CustomHelpers::custom_encrypt($fanchise_detail->id))}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          @include("admin.fanchises.accordian")
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
                         <!-- /.card -->
          </div>

@endif







<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>



@endsection

@section("custom_js")

<script type="text/javascript">
//
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//close
 $(document).on("click",".architect_add",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Architect-Actions";
  
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

  })
  //social_media_actions  
   
$(document).on("click",".social_media_actions",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Social-Media-Actions";

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

  })
 //operations_actions
$(document).on("click",".operations_actions",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Operations-Actions";
 
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

  })
//accounts_actions
$(document).on("click",".accounts_actions",function(){
    var id=$(this).attr('id')
   var form = document.createElement("form");
   document.body.appendChild(form);
   form.method = "POST";
   form.action = "Accounts-Actions";

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

  })

 //
  //

 
 //
</script>
@endsection
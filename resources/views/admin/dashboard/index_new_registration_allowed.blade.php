@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
     <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">
    
         <div class="row">

  
<!---->
@include("admin.dashboard.admin_dashboard_page.birthday.today")
<!---->
@include("admin.dashboard.admin_dashboard_page.birthday.upcoming")
<!---->
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

<script>
 
</script>

<script>



//
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection
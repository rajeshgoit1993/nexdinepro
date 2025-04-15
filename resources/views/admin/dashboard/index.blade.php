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
@include("admin.dashboard.admin_dashboard_page.birthday.brandwise_chart")
  
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
@section('custom_css')
<link href="{{asset('/resources/assets/fullcal/main.css')}}" rel='stylesheet' />




@endsection
@section('custom_js')
<script src="{{asset('/resources/assets/fullcal/main.js')}}"></script>
<script>
 
</script>

<script>

//
$(document).ready(function(){

call_dashboard();

})

$(document).on("click",".find",function()
{
  call_dashboard();
})
function call_dashboard()
{
//
var brand=$("#brand").val();
var APP_URL=$("#APP_URL").val();
var button=$(this)
     $.ajax({
        url:APP_URL+'/get_admin_dashboard',
        data:{brand:brand},
        type:'get',
        cache: false,
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
     //
     $('#franchise_chart').remove(); // this is my <canvas> element
     $('.first_result_data').append('<canvas id="franchise_chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>');
     var donutChartCanvas = $('#franchise_chart').get(0).getContext('2d')
 
    var donutData        = {
      labels: [
        
          'Running',
          'Expired',
          'Inactive',
         
      ],
      datasets: [
        {
          data: [data.get_franchise_registration_launched,
            data.get_franchise_registration_tem_inactive,
            data.get_franchise_registration_inactive],
          backgroundColor : [ '#00a65a','#ffc107','#dc3545'],
        }
      ]
    }


    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
     'onClick' : function (evt, item) {
        // console.log ('legend onClick', evt);
         var APP_URL=$("#APP_URL").val();
        console.log('legd item', item[0]._index);
    if(item[0]._index==0)
{

var url= APP_URL+'/Active-Newly-Submitted';
 window.location.href = url;
}
else if(item[0]._index==1)
{
var url= APP_URL+'/Temporary-Inactive-Newly-Submitted';
 window.location.href = url;
}
else if(item[0]._index==2)
{
var url= APP_URL+'/Ongoing-KYC-Inactive'; 
 window.location.href = url;
}
else if(item[0]._index==3)
{
var brand=$("#brand").val();
var APP_URL=$("#APP_URL").val();

$.ajax({
url: APP_URL+'/set_brand_session',

data:{brand:brand},
type: 'get',
cache: false,
// contentType: false,
// processData: false,
success: function (data) {

 var url= APP_URL+'/Ongoing-Pre-launch';
 window.location.href = url;
},
error: function (xhr, status, error) {


}
}); 

}
else if(item[0]._index==4)
{
var url= APP_URL+'/Launch-Franchise';
 window.location.href = url;
}
else if(item[0]._index==5)
{
var url= APP_URL+'/Temporary-Inactive';
 window.location.href = url;
}
else if(item[0]._index==6)
{
var url= APP_URL+'/Inactive';
 window.location.href = url;
}
  //

                    }

    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
    $(".franchise_total").html('').html(data.get_franchise_total)
   //products_chart
   $('#products_chart').remove(); // this is my <canvas> element
     $('.products_result_data').append('<canvas id="products_chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>');

    var donutChartCanvas = $('#products_chart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Utensil',
          'Equipment',
          'Disposable',
          'Frozen',
          'Masala',
         
      ],
      datasets: [
        {
          data: [data.get_Utensil_count,data.get_Equipment_count,data.get_Disposable_count,data.get_Frozen_count,data.get_Masala_count],
          backgroundColor : ['#f56954', '#d2d6de',  '#00c0ef', '#f39c12', '#00a65a'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
  
   new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
    $(".product_total").html('').html(data.get_total_product)
//
    
        },
        error:function(data)
        {

        }
    })






}



//
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection
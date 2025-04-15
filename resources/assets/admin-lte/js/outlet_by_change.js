 //region
  $(document).on("change","#region",function(){
var region=$(this).val()
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_region_wise_data',
        data:{region:region},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        $("#city").html('').html(data.output_city)
         $("#outlet").html('').html('<option value="">--Select Outlet--</option>'+data.output_outlet)

        },
        error:function(data)
        {

        }
    })

})
//
$(document).on("change","#city",function(){
var city=$(this).val()
var region=$("#region").val()
  $("#overlay").fadeIn(300);
var APP_URL=$("#APP_URL").val();
     $.ajax({
        url:APP_URL+'/get_city_wise_outlet',
        data:{city:city,region:region},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {

         $("#overlay").fadeOut(300);
        $("#outlet").html('').html('<option value="">--Select Outlet--</option>'+data)

        },
        error:function(data)
        {

        }
    })

})
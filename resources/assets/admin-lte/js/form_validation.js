	$(document).on("change",".status",function(){
		if($(this).val()=='Yes')
		{
			$(this).parent().siblings().children(".status_remarks").css("display",'block')
		}
		else
		{
			$(this).parent().siblings().children(".status_remarks").css("display",'none')
		}
		
	})
	$(document).on("keyup change",".number_test",function(){
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

})
$(document).ready(function(){
    
	var gst=$(".gst").val();
	if(gst=='2')
	{
		$(".gst_percentage").css("display","block")
	}
	else
	{
		$(".gst_percentage").css("display","none")
	}
	$(".gst").change(function(){
			var gst=$(this).val();
			if(gst=='2')
	{
		$(".gst_percentage").css("display","block")
	}
	else
	{
		$(".gst_percentage").css("display","none")
	}
	})
	//
	var royality=$(".royality").val();
	if(royality=='2')
	{
		$(".royality_percentage").css("display","block")
	}
	else
	{
		$(".royality_percentage").css("display","none")
	}
	$(".royality").change(function(){
			var royality=$(this).val();
			if(royality=='2')
	{
		$(".royality_percentage").css("display","block")
	}
	else
	{
		$(".royality_percentage").css("display","none")
	}
	})
	//
	$(document).on("keyup change",".booking_amount , .gst  , .gst_percentage , .gst_amount , .royality , .royality_percentage, .royality_amount  , .total_booking_amount  , .total_received_amount , .total_pending_amount",function(){
   var booking_amount=$(".booking_amount").val();	
   if(booking_amount=='')
   {
   	var booking_amount=0;
   }	
   var gst=$(".gst").val();		
   var gst_percentage=$(".gst_percentage").val();
   var gst_amount=$(".gst_amount").val();
   var royality=$(".royality").val();
   var royality_percentage=$(".royality_percentage").val();
   var royality_amount=$(".royality_amount").val();
   var total_received_amount=$(".total_received_amount").val();
   var gst_amount=0;
   var royality_amount=0;
   if(gst==2)
   {
   	if(booking_amount!='' && gst_percentage!='')
   	{
    var gst_amount=booking_amount*gst_percentage/100;
   		$(".gst_amount").val('').val(parseFloat(gst_amount))
   	}
   }
   if(royality==2)
   {
   	if(booking_amount!='' && royality_percentage!='')
   	{
    var royality_amount=booking_amount*royality_percentage/100;
   		$(".royality_amount").val('').val(parseFloat(royality_amount))
   	}
   }
  var total='0';
  if($(".booking_amount").val()!='')
  {
  	var total=parseFloat(total)+parseFloat($(".booking_amount").val())
  }
  if($(".gst_amount").val()!='')
  {
  	var total=parseFloat(total)+parseFloat($(".gst_amount").val())
  }
  if($(".royality_amount").val()!='')
  {
  	var total=parseFloat(total)+parseFloat($(".royality_amount").val())
  }
  $(".total_booking_amount").val('').val(parseFloat(total))

var pending=0;
if($(".total_booking_amount").val()!='')
  {
  	var pending=parseFloat(pending)+parseFloat($(".total_booking_amount").val())
  }	
 if($(".total_received_amount").val()!='')
  {
  	var pending=parseFloat(pending)-parseFloat($(".total_received_amount").val())
  }	
 $(".total_pending_amount").val('').val(parseFloat(pending))

 })

})
 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
 
 $('#btn_login_details').click(function(){
  
  var error_user_id = '';
  var error_password = '';
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  
  if($.trim($('#user_id').val()).length == 0)
  {
   error_email = 'User Id is required';
   $('#error_user_id').text(error_email);
   $('#user_id').addClass('has-error');
  }
  else
  {
    error_user_id = '';
    $('#error_password').text(error_user_id);
    $('#user_id').removeClass('has-error');
  }
  
  if($.trim($('#password').val()).length == 0)
  {
   error_password = 'Password is required';
   $('#error_password').text(error_password);
   $('#password').addClass('has-error');
  }
  else
  {
   error_password = '';
   $('#error_password').text(error_password);
   $('#password').removeClass('has-error');
  }

  if(error_user_id != '' || error_password != '')
  {
   return false;
  }
  else
  {


  submit_form('btn_login_details',1)

  }
 });
 $('#previous_booking_amount').click(function(){
 	submit_form('previous_booking_amount',0)
 
 });
 $('#btn_booking_amount').click(function(){
  var error_booking_amount = '';
  var error_total_received_amount = '';
  
  if($.trim($('#booking_amount').val()).length == 0)
  {
   error_booking_amount = 'Booking Amount is required';
   $('#error_booking_amount').text(error_booking_amount);
   $('#booking_amount').addClass('has-error');
  }
  else
  {
   error_booking_amount = '';
   $('#error_booking_amount').text(error_booking_amount);
   $('#booking_amount').removeClass('has-error');
  }
  
  if($.trim($('#total_received_amount').val()).length == 0)
  {
   error_total_received_amount = 'Received Amount is required';
   $('#error_total_received_amount').text(error_total_received_amount);
   $('#total_received_amount').addClass('has-error');
  }
  else
  {
   error_total_received_amount = '';
   $('#error_total_received_amount').text(error_total_received_amount);
   $('#total_received_amount').removeClass('has-error');
  }

  if(error_booking_amount != '' || error_total_received_amount != '')
  {
   return false;
  }
  else
  {
  	submit_form('btn_booking_amount',2)
   
  }
 });
 $('#previous_btn_contact_details').click(function(){

 	submit_form('previous_btn_contact_details',0)
 
 });
  $('#btn_contact_details').click(function(){
  var error_loi = '';
  var error_adhar_card = '';
  var error_pan_card = '';
  var error_gst_card = '';
var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;

  if($.trim($('#loi').val()).length == 0)
  {
   error_loi = 'LOI is required';
   $('#error_loi').text(error_loi);
   $('#loi').addClass('has-error');
  }
  else
  {
 if (!allowedExtensions.exec($('#loi').val()))
   {
    error_loi = 'Invalid File';
    $('#error_loi').text(error_loi);
    $('#loi').addClass('has-error');
   }
   else
   {
    error_loi = '';
    $('#error_loi').text(error_loi);
    $('#loi').removeClass('has-error');
   }
  }
  //
    if($.trim($('#adhar_card').val()).length == 0)
  {
   error_adhar_card = 'Aadhar Card is required';
   $('#error_adhar_card').text(error_adhar_card);
   $('#adhar_card').addClass('has-error');
  }
  else
  {
 if (!allowedExtensions.exec($('#adhar_card').val()))
   {
    error_adhar_card = 'Invalid File';
    $('#error_adhar_card').text(error_adhar_card);
    $('#adhar_card').addClass('has-error');
   }
   else
   {
    error_adhar_card = '';
    $('#error_adhar_card').text(error_adhar_card);
    $('#adhar_card').removeClass('has-error');
   }
  }
   //
    if($.trim($('#pan_card').val()).length == 0)
  {
   error_pan_card = 'PAN Card is required';
   $('#error_pan_card').text(error_pan_card);
   $('#pan_card').addClass('has-error');
  }
  else
  {
 if (!allowedExtensions.exec($('#pan_card').val()))
   {
    error_pan_card = 'Invalid File';
    $('#error_pan_card').text(error_pan_card);
    $('#pan_card').addClass('has-error');
   }
   else
   {
    error_pan_card = '';
    $('#error_pan_card').text(error_pan_card);
    $('#pan_card').removeClass('has-error');
   }
  }
   //
    if($.trim($('#gst_card').val()).length == 0)
  {
   error_gst_card = 'GST File  is required';
   $('#error_gst_card').text(error_gst_card);
   $('#gst_card').addClass('has-error');
  }
  else
  {
 if (!allowedExtensions.exec($('#gst_card').val()))
   {
    error_gst_card = 'Invalid File';
    $('#error_gst_card').text(error_gst_card);
    $('#gst_card').addClass('has-error');
   }
   else
   {
    error_gst_card = '';
    $('#error_gst_card').text(error_gst_card);
    $('#gst_card').removeClass('has-error');
   }
  }
  if(error_loi != '' || error_adhar_card !='' || error_pan_card !='' || error_gst_card!='')
  {
   return false;
  }
  else
  {

    submit_form('btn_contact_details',3)
  

   // $('#btn_contact_details').attr("disabled", "disabled");
   // $(document).css('cursor', 'prgress');
   // $("#register_form").submit();
  }
  
 });
 $('#btn_contact_details_edit').click(function(){
  var error_loi = '';
  var error_adhar_card = '';
  var error_pan_card = '';
  var error_gst_card = '';


  if(error_loi != '' || error_adhar_card !='' || error_pan_card !='' || error_gst_card!='')
  {
   return false;
  }
  else
  {

  	submit_form('btn_contact_details',3)
  

   // $('#btn_contact_details').attr("disabled", "disabled");
   // $(document).css('cursor', 'prgress');
   // $("#register_form").submit();
  }
  
 });
$('#previous_btn_initial_checklist').click(function(){

 	submit_form('previous_btn_initial_checklist',0)
 
 });
 $('#btn_checklist_details').click(function(){

  

  	submit_form('btn_checklist_details',4)

  
 });
 $('#previous_btn_prelunch_details').click(function(){

 	submit_form('previous_btn_prelunch_details',0)
 
 });
  $('#btn_prelunch_details').click(function(){
  var error= '';

  var mobile_validation = /^\d{10}$/;
  
    if($('#registered_name_status').val() == '')
  {
   error = 'Action';

   $('#registered_name_status').addClass('has-error');
  }
  else
  {
  	if($.trim($('#firm_registered_name').val()).length == 0)
  	{
  		error = 'Action';
  	 $('#firm_registered_name').addClass('has-error');
  	}
  	else
  	{
  		error = '';
 $('#firm_registered_name').removeClass('has-error');
  	}
  	$('#registered_name_status').removeClass('has-error');
  }
 
  //
  if($('#shop_agreement_status').val() == '')
  {
   error = 'Action';

   $('#shop_agreement_status').addClass('has-error');
  }
  else
  {
  	if($.trim($('#shop_agreement_detail').val()).length == 0)
  	{
  		error = 'Action';
  	 $('#shop_agreement_detail').addClass('has-error');
  	}
  	else
  	{
  		error = '';
 $('#shop_agreement_detail').removeClass('has-error');
  	}
  	$('#shop_agreement_status').removeClass('has-error');
  }
   //
  if($('#outlet_address_status').val() == '')
  {
   error = 'Action';

   $('#outlet_address_status').addClass('has-error');
  }
  else
  {
  	if($.trim($('#outlet_address').val()).length == 0)
  	{
  		error = 'Action';
  	 $('#outlet_address').addClass('has-error');
  	}
  	else
  	{
  		error = '';
 $('#outlet_address').removeClass('has-error');
  	}
  	$('#outlet_address_status').removeClass('has-error');
  }
    //
  if($('#mail_id_status').val() == '')
  {
   error = 'Action';

   $('#mail_id_status').addClass('has-error');
  }
  else
  {
  	if($.trim($('#mail_id_name').val()).length == 0)
  	{
  		error = 'Action';
  	 $('#mail_id_name').addClass('has-error');
  	}
  	else
  	{
  		error = '';
 $('#mail_id_name').removeClass('has-error');
  	}
  	$('#mail_id_status').removeClass('has-error');
  }

  //
  if($('#outlet_mobile_status').val() == '')
  {
   error = 'Action';

   $('#outlet_mobile_status').addClass('has-error');
  }
  else
  {
  	if($.trim($('#outlet_mobile').val()).length == 0)
  	{
  		error = 'Action';
  	 $('#outlet_mobile').addClass('has-error');
  	}
  	else
  	{
  		error = '';
 $('#outlet_mobile').removeClass('has-error');
  	}
  	$('#outlet_mobile_status').removeClass('has-error');
  }
  //
  if($('#gst_status').val() == '')
  {
   error = 'Action';

   $('#gst_status').addClass('has-error');
  }
  else
  {
  	if($.trim($('#gst_name').val()).length == 0)
  	{
  		error = 'Action';
  	 $('#gst_name').addClass('has-error');
  	}
  	else
  	{
  		error = '';
 $('#gst_name').removeClass('has-error');
  	}
  	$('#gst_status').removeClass('has-error');
  }
    if($('#fssai_status').val() == '')
  {
   error = 'Action';

   $('#fssai_status').addClass('has-error');
  }
  else
  {
    
    $('#fssai_status').removeClass('has-error');
  }

  if($('#electricity_load_status').val() == '')
  {
   error = 'Action';

   $('#electricity_load_status').addClass('has-error');
  }
  else
  {
    
    $('#electricity_load_status').removeClass('has-error');
  }

  if($('#current_bank_status').val() == '')
  {
   error = 'Action';

   $('#current_bank_status').addClass('has-error');
  }
  else
  {
    
    $('#current_bank_status').removeClass('has-error');
  }
   if($('#official_mail_status').val() == '')
  {
   error = 'Action';

   $('#official_mail_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#official_mail_name').val()).length == 0)
    {
        error = 'Action';
     $('#official_mail_name').addClass('has-error');
    }
    else
    {
        error = '';
 $('#official_mail_name').removeClass('has-error');
    }
    $('#official_mail_status').removeClass('has-error');
  }

   if($('#google_list_status').val() == '')
  {
   error = 'Action';

   $('#google_list_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#google_link').val()).length == 0)
    {
        error = 'Action';
     $('#google_link').addClass('has-error');
    }
    else
    {
        error = '';
 $('#google_link').removeClass('has-error');
    }
    $('#google_list_status').removeClass('has-error');
  }

   if($('#fb_page_status').val() == '')
  {
   error = 'Action';

   $('#fb_page_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#fb_link').val()).length == 0)
    {
        error = 'Action';
     $('#fb_link').addClass('has-error');
    }
    else
    {
        error = '';
 $('#fb_link').removeClass('has-error');
    }
    $('#fb_page_status').removeClass('has-error');
  }
  
  if($('#insta_page_status').val() == '')
  {
   error = 'Action';

   $('#insta_page_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#insta_link').val()).length == 0)
    {
        error = 'Action';
     $('#insta_link').addClass('has-error');
    }
    else
    {
        error = '';
 $('#insta_link').removeClass('has-error');
    }
    $('#insta_page_status').removeClass('has-error');
  }
 
  if($('#interior_design_status').val() == '')
  {
   error = 'Action';

   $('#interior_design_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#interior_design').val()).length == 0)
    {
        error = 'Action';
     $('#interior_design').addClass('has-error');
    }
    else
    {
        error = '';
 $('#interior_design').removeClass('has-error');
    }
    $('#interior_design_status').removeClass('has-error');
  }
  if($('#branding_status').val() == '')
  {
   error = 'Action';

   $('#branding_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#branding_design').val()).length == 0)
    {
        error = 'Action';
     $('#branding_design').addClass('has-error');
    }
    else
    {
        error = '';
 $('#branding_design').removeClass('has-error');
    }
    $('#branding_status').removeClass('has-error');
  }
 if($('#menu_dine_status').val() == '')
  {
   error = 'Action';

   $('#menu_dine_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#menu_dine').val()).length == 0)
    {
        error = 'Action';
     $('#menu_dine').addClass('has-error');
    }
    else
    {
        error = '';
 $('#menu_dine').removeClass('has-error');
    }
    $('#menu_dine_status').removeClass('has-error');
  }
  if($('#menu_online_status').val() == '')
  {
   error = 'Action';

   $('#menu_online_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#menu_online').val()).length == 0)
    {
        error = 'Action';
     $('#menu_online').addClass('has-error');
    }
    else
    {
        error = '';
 $('#menu_online').removeClass('has-error');
    }
    $('#menu_online_status').removeClass('has-error');
  }
  if($('#zomato_onboarding_status').val() == '')
  {
   error = 'Action';

   $('#zomato_onboarding_status').addClass('has-error');
  }
  else
  {
  error = '';
    $('#zomato_onboarding_status').removeClass('has-error');
  }
  if($('#swiggy_onboarding_status').val() == '')
  {
   error = 'Action';

   $('#swiggy_onboarding_status').addClass('has-error');
  }
  else
  {
    
    $('#swiggy_onboarding_status').removeClass('has-error');
  }
  if($('#npi_pamphlets_status').val() == '')
  {
   error = 'Action';

   $('#npi_pamphlets_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#npi_pamphlets').val()).length == 0)
    {
        error = 'Action';
     $('#npi_pamphlets').addClass('has-error');
    }
    else
    {
        error = '';
 $('#npi_pamphlets').removeClass('has-error');
    }
    $('#npi_pamphlets_status').removeClass('has-error');
  }
  
  if($('#hoarding_design_status').val() == '')
  {
   error = 'Action';

   $('#hoarding_design_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#hoarding_design').val()).length == 0)
    {
        error = 'Action';
     $('#hoarding_design').addClass('has-error');
    }
    else
    {
        error = '';
 $('#hoarding_design').removeClass('has-error');
    }
    $('#hoarding_design_status').removeClass('has-error');
  }
  
  if($('#banner_design_status').val() == '')
  {
   error = 'Action';

   $('#banner_design_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#banner_design').val()).length == 0)
    {
        error = 'Action';
     $('#banner_design').addClass('has-error');
    }
    else
    {
        error = '';
 $('#banner_design').removeClass('has-error');
    }
    $('#banner_design_status').removeClass('has-error');
  }
  
  if($('#newspaper_ad_status').val() == '')
  {
   error = 'Action';

   $('#newspaper_ad_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#newspaper_ad_status').val()).length == 0)
    {
        error = 'Action';
     $('#newspaper_ad_status').addClass('has-error');
    }
    else
    {
        error = '';
 $('#newspaper_ad_status').removeClass('has-error');
    }
    $('#newspaper_ad_status').removeClass('has-error');
  }
  if(error != '')
  {
   return false;
  }
  else
  {

  	submit_form('btn_prelunch_details',5)
  

  }
  
 });
   $('#previous_btn_lunch_details').click(function(){

 	submit_form('previous_btn_lunch_details',0)
 
 });
     $('#btn_lunch_details').click(function(){
     var error= '';
var mobile_validation = /^\d{10}$/;
    if($('#launch_date').val() == '')
  {
   error = 'Action';

   $('#launch_date').addClass('has-error');
  }
  else
  {
    error = '';
    $('#launch_date').removeClass('has-error');
  }
   //
    if($('#aggrement_status').val() == '')
  {
   error = 'Action';

   $('#aggrement_status').addClass('has-error');
  }
  else
  {
    if($.trim($('#aggrement_doc').val()).length == 0)
    {
      error = 'Action';
     $('#aggrement_doc').addClass('has-error');
    }
    else
    {
      error = '';
 $('#aggrement_doc').removeClass('has-error');
    }
    $('#aggrement_status').removeClass('has-error');
  }
  //
  if($('#manpower_hiring_status').val() == '')
  {
   error = 'Action';

   $('#manpower_hiring_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#manpower_hiring_status').removeClass('has-error');
  }
   //
   if($('#signage_status').val() == '')
  {
   error = 'Action';

   $('#signage_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#signage_status').removeClass('has-error');
  }
   //
   if($('#menu_display_board_status').val() == '')
  {
   error = 'Action';

   $('#menu_display_board_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#menu_display_board_status').removeClass('has-error');
  }
   //
   if($('#temple_status').val() == '')
  {
   error = 'Action';

   $('#temple_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#temple_status').removeClass('has-error');
  }
   //
   if($('#edc_status').val() == '')
  {
   error = 'Action';

   $('#edc_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#edc_status').removeClass('has-error');
  }
   //
   if($('#billing_software_status').val() == '')
  {
   error = 'Action';

   $('#billing_software_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#billing_software_status').removeClass('has-error');
  }
   //
   if($('#coke_pepsi_status').val() == '')
  {
   error = 'Action';

   $('#coke_pepsi_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#coke_pepsi_status').removeClass('has-error');
  }
   //
   if($('#local_purchase_status').val() == '')
  {
   error = 'Action';

   $('#local_purchase_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#local_purchase_status').removeClass('has-error');
  }
   //
   if($('#chain_order_status').val() == '')
  {
   error = 'Action';

   $('#chain_order_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#chain_order_status').removeClass('has-error');
  }
   //
   if($('#sop_status').val() == '')
  {
   error = 'Action';

   $('#sop_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#sop_status').removeClass('has-error');
  }
   //
   if($('#uniforms_status').val() == '')
  {
   error = 'Action';

   $('#uniforms_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#uniforms_status').removeClass('has-error');
  }
   //
   if($('#kitchen_equi_status').val() == '')
  {
   error = 'Action';

   $('#kitchen_equi_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#kitchen_equi_status').removeClass('has-error');
  }
   //
   if($('#cutlery_status').val() == '')
  {
   error = 'Action';

   $('#cutlery_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#cutlery_status').removeClass('has-error');
  }
   //
   if($('#furnitures_status').val() == '')
  {
   error = 'Action';

   $('#furnitures_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#furnitures_status').removeClass('has-error');
  }
   //
   if($('#gas_status').val() == '')
  {
   error = 'Action';

   $('#gas_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#gas_status').removeClass('has-error');
  }
   //
   if($('#electricity_status').val() == '')
  {
   error = 'Action';

   $('#electricity_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#electricity_status').removeClass('has-error');
  }
   //
   if($('#water_drainage_status').val() == '')
  {
   error = 'Action';

   $('#water_drainage_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#water_drainage_status').removeClass('has-error');
  }
   //
   if($('#music_status').val() == '')
  {
   error = 'Action';

   $('#music_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#music_status').removeClass('has-error');
  }
   //
   if($('#ac_status').val() == '')
  {
   error = 'Action';

   $('#ac_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#ac_status').removeClass('has-error');
  }
   //
   if($('#wifi_status').val() == '')
  {
   error = 'Action';

   $('#wifi_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#wifi_status').removeClass('has-error');
  }
   //
   if($('#cctv_status').val() == '')
  {
   error = 'Action';

   $('#cctv_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#cctv_status').removeClass('has-error');
  }
   //
   if($('#fire_status').val() == '')
  {
   error = 'Action';

   $('#fire_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#fire_status').removeClass('has-error');
  }
   //
   if($('#stock_status').val() == '')
  {
   error = 'Action';

   $('#stock_status').addClass('has-error');
  }
  else
  {
    error = '';
    $('#stock_status').removeClass('has-error');
  }
    
   //
    if(error != '')
  {
   return false;
  }
  else
  {

  submit_form('btn_lunch_details',6)
  

  }
 	
 
 });
   
 function submit_form(parameter,id){
 	 var APP_URL=$("#APP_URL").val();
 	 $("#serial_id").val("").val(id)

 	    var form_data = new FormData($("#registration_form")[0]);
 	    

 $.ajax({
        url:APP_URL+'/fanchise_register',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            console.log(data)
        if(data=='success')
        {

        	
        	
        	if(id==1)
        	{
        		$(".login_part").html("")
        		$("#login_details").html("")
        	}
    if(parameter=='btn_login_details')
    {
         swal("Done !", 'Successfully Saved Login Details', "success");
   $('#list_login_details').removeClass('active active_tab1');
   $('#list_login_details').removeAttr('href data-toggle');
   $('#login_details').removeClass('active');
   $('#list_login_details').addClass('inactive_tab1');
   $('#list_personal_details').removeClass('inactive_tab1');
   $('#list_personal_details').addClass('active_tab1 active');
   $('#list_personal_details').attr('href', '#personal_details');
   $('#list_personal_details').attr('data-toggle', 'tab');
   $('#personal_details').addClass('active in');
    }
    else if(parameter=='previous_booking_amount')
    {
   $('#list_personal_details').removeClass('active active_tab1');
  $('#list_personal_details').removeAttr('href data-toggle');
  $('#personal_details').removeClass('active in');
  $('#list_personal_details').addClass('inactive_tab1');
  $('#list_login_details').removeClass('inactive_tab1');
  $('#list_login_details').addClass('active_tab1 active');
  $('#list_login_details').attr('href', '#login_details');
  $('#list_login_details').attr('data-toggle', 'tab');
  $('#login_details').addClass('active in');
    }
     else if(parameter=='btn_booking_amount')
    {
         swal("Done !", 'Successfully Saved Amount Details', "success");
    $('#list_personal_details').removeClass('active active_tab1');
   $('#list_personal_details').removeAttr('href data-toggle');
   $('#personal_details').removeClass('active');
   $('#list_personal_details').addClass('inactive_tab1');
   $('#list_contact_details').removeClass('inactive_tab1');
   $('#list_contact_details').addClass('active_tab1 active');
   $('#list_contact_details').attr('href', '#contact_details');
   $('#list_contact_details').attr('data-toggle', 'tab');
   $('#contact_details').addClass('active in');
    }
    else if(parameter=='previous_btn_contact_details')
    {
 $('#list_contact_details').removeClass('active active_tab1');
  $('#list_contact_details').removeAttr('href data-toggle');
  $('#contact_details').removeClass('active in');
  $('#list_contact_details').addClass('inactive_tab1');
  $('#list_personal_details').removeClass('inactive_tab1');
  $('#list_personal_details').addClass('active_tab1 active');
  $('#list_personal_details').attr('href', '#personal_details');
  $('#list_personal_details').attr('data-toggle', 'tab');
  $('#personal_details').addClass('active in');
    }
    else if(parameter=='btn_contact_details')
    {
 swal("Done !", 'Successfully Saved Documents', "success");
 $('#list_contact_details').removeClass('active active_tab1');
   $('#list_contact_details').removeAttr('href data-toggle');
   $('#contact_details').removeClass('active');
   $('#list_contact_details').addClass('inactive_tab1');
   $('#list_initial_checklist').removeClass('inactive_tab1');
   $('#list_initial_checklist').addClass('active_tab1 active');
   $('#list_initial_checklist').attr('href', '#personal_details');
   $('#list_initial_checklist').attr('data-toggle', 'tab');
   $('#checklist_details').addClass('active in');
    }
   else if(parameter=='previous_btn_initial_checklist')
    {
  $('#list_initial_checklist').removeClass('active active_tab1');
  $('#list_initial_checklist').removeAttr('href data-toggle');
  $('#checklist_details').removeClass('active in');
  $('#list_initial_checklist').addClass('inactive_tab1');
  $('#list_contact_details').removeClass('inactive_tab1');
  $('#list_contact_details').addClass('active_tab1 active');
  $('#list_contact_details').attr('href', '#personal_details');
  $('#list_contact_details').attr('data-toggle', 'tab');
  $('#contact_details').addClass('active in');
    }
     else if(parameter=='btn_checklist_details')
    {
        swal("Done !", 'Successfully Saved Initial Checklist Details', "success");
 $('#list_initial_checklist').removeClass('active active_tab1');
   $('#list_initial_checklist').removeAttr('href data-toggle');
   $('#checklist_details').removeClass('active');
   $('#list_initial_checklist').addClass('inactive_tab1');
   $('#list_prelunch_details').removeClass('inactive_tab1');
   $('#list_prelunch_details').addClass('active_tab1 active');
   $('#list_prelunch_details').attr('href', '#personal_details');
   $('#list_prelunch_details').attr('data-toggle', 'tab');
   $('#prelunch_details').addClass('active in');
    }
    else if(parameter=='previous_btn_prelunch_details')
    {
  $('#list_prelunch_details').removeClass('active active_tab1');
  $('#list_prelunch_details').removeAttr('href data-toggle');
  $('#prelunch_details').removeClass('active in');
  $('#list_prelunch_details').addClass('inactive_tab1');
  $('#list_initial_checklist').removeClass('inactive_tab1');
  $('#list_initial_checklist').addClass('active_tab1 active');
  $('#list_initial_checklist').attr('href', '#personal_details');
  $('#list_initial_checklist').attr('data-toggle', 'tab');
  $('#checklist_details').addClass('active in');
    }
     else if(parameter=='btn_prelunch_details')
    {
         swal("Done !", 'Successfully Saved Pre-Launch Details', "success");
 $('#list_prelunch_details').removeClass('active active_tab1');
   $('#list_prelunch_details').removeAttr('href data-toggle');
   $('#prelunch_details').removeClass('active');
   $('#list_prelunch_details').addClass('inactive_tab1');
   $('#list_lunch_details').removeClass('inactive_tab1');
   $('#list_lunch_details').addClass('active_tab1 active');
   $('#list_lunch_details').attr('href', '#personal_details');
   $('#list_lunch_details').attr('data-toggle', 'tab');
   $('#lunch_details').addClass('active in');
    }
     else if(parameter=='previous_btn_lunch_details')
    {
  $('#list_lunch_details').removeClass('active active_tab1');
  $('#list_lunch_details').removeAttr('href data-toggle');
  $('#lunch_details').removeClass('active in');
  $('#list_lunch_details').addClass('inactive_tab1');
  $('#list_prelunch_details').removeClass('inactive_tab1');
  $('#list_prelunch_details').addClass('active_tab1 active');
  $('#list_prelunch_details').attr('href', '#personal_details');
  $('#list_prelunch_details').attr('data-toggle', 'tab');
  $('#prelunch_details').addClass('active in');
    }
    else if(parameter=='btn_lunch_details')
    {
         swal("Done !", 'Successfully Saved All Details', "success");
         var url=APP_URL+'/Fanchise-list';
         window.location.href = url;
    }
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

 

 

 

 
});
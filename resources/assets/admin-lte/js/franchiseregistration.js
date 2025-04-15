 //

    $(document).on("click",".filter",function(e){
     e.preventDefault()
     $("#overlay").fadeIn(300);
      $(".filter").each(function(){
      if($(this).hasClass("btn-default"))
      {
        $(this).removeClass("btn-default")
         $(this).addClass("btn-primary")
      }
      });
      $(this).removeClass("btn-primary")
      $(this).addClass("btn-default")
       var value=$(this).attr('id')
       var APP_URL=$("#APP_URL").val();
       var brand_id=$(this).attr('brand_id')
       var fanchise_id=$(this).attr('fanchise_id')
  $.ajax({
        url:APP_URL+'/get_first_time_filter_data',
        data:{brand_id:brand_id,value:value,fanchise_id:fanchise_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
         $("#overlay").fadeOut(300); 
          $(".dynamic_data").html('').html(data)
          $('.count').prop('disabled', true);
        },
        error:function(data)
        {

        }
    })


    })
  //
$(document).on("click","#lblCartCount",function(){
 
   //
      
        var APP_URL=$("#APP_URL").val();
        var fanchise_id=$(this).attr('fanchise_id')
       
  $.ajax({
        url:APP_URL+'/get_cart_data',
        data:{fanchise_id:fanchise_id},
        type:'get',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          $(".cart_data_value").html('').html(data)
         $('#cart_data').modal('toggle');
        },
        error:function(data)
        {

        }
    })
    //


})
//

  //
      $(document).ready(function() {
        $('.count').prop('disabled', true);
    
         $(document).on("click",".minus",function(){
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 0 ? 0 : count;
        $input.val(count);
        $input.change();
         //
        var new_value=$input.val();
        var APP_URL=$("#APP_URL").val();
        var fanchise_id=$(this).attr('fanchise_id')

        var list_id=$(this).attr('list_id')
  $.ajax({
        url:APP_URL+'/add_data_to_cart',
        data:{fanchise_id:fanchise_id,list_id:list_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
          $("#lblCartCount").html('').html(data)
        },
        error:function(data)
        {

        }
    })
    //
        return false;
      });

  $(document).on("click",".plus",function(){
  var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        //
        var new_value=$input.val();
        var APP_URL=$("#APP_URL").val();
        var fanchise_id=$(this).attr('fanchise_id')
        var list_id=$(this).attr('list_id')
  $.ajax({
        url:APP_URL+'/add_data_to_cart',
        data:{fanchise_id:fanchise_id,list_id:list_id,new_value:new_value},
        type:'post',
        // contentType: false,
        // processData: false,
        
        success:function(data)
        {
           $("#lblCartCount").html('').html(data)
        },
        error:function(data)
        {

        }
    })
    //

        return false;

  })


     
    });
  //outlet_detail
  $('.partener_check').click(function(){
    if (this.checked) {
      $(".outlet_detail").css("display","block")


}
 else
    {
      $(".outlet_detail").css("display","none")
      }
})
  //laptop_part laptop_check
  $(document).on("change",".status",function(){

    if($(this).val()=='Yes')
    {
      $(this).siblings(".status_remarks").css("display",'block')
    }
    else
    {
      $(this).siblings(".status_remarks").css("display",'none')
    }
    
  })

$('#submit_prelaunch').click(function(){
  var level=$("#level").val();

  if(level==1)
  {
  var error_layouts='';
  var error_layouts_design='';
  var error_interior='';
  var error_interior_design='';
  var error_wall_design='';
  var error_wall_design_layouts='';
  var error_coming_soon_banner_installation='';
  var error_furnitures='';
  var error_false_ceiling_work='';
  var error_furnitures='';
  var error_electricity='';
  var error_water_drainage='';
  var error_ac='';
  var error_music_system='';
  var error_wifi='';
  var error_cctv='';
  var error_gas_bank='';
  var error_kitchen='';
  var error_menu_display='';
  var error_coke_cooler='';
  var error_fire_extinguisher='';
  var error_signage_board='';
  var error_signage_board_design='';
  var error_certificate_display='';

   if($('#layouts').val() == '')
  {
   error_layouts = 'Required Action';
   $('#error_layouts').text(error_layouts);
   $('#layouts').addClass('has-error');
  }
  else
   {

    if($('#layouts').val()=='Yes' && $('#layouts_design').length==1 &&  $.trim($('#layouts_design').val()).length == 0)
    {

     error_layouts_design = 'Choose Doc';
   $('#error_layouts_design').text(error_layouts_design);
   $('#layouts_design').addClass('has-error');;
    }
    else
    {
     error_layouts_design = '';
   $('#error_layouts_design').text(error_layouts_design);
   $('#layouts_design').removeClass('has-error');
    }
    error_layouts = '';
   $('#error_layouts').text(error_layouts);
   $('#layouts').removeClass('has-error');
    }
    //
   if($('#interior').val() == '')
  {
   error_interior = 'Required Action';
   $('#error_interior').text(error_interior);
   $('#interior').addClass('has-error');
  }
  else
   {
    if($('#interior').val()=='Yes'  && $('#interior_design').length==1 && $.trim($('#interior_design').val()).length == 0)
    {
     error_interior_design = 'Choose Doc';
   $('#error_interior_design').text(error_interior_design);
   $('#interior_design').addClass('has-error');;
    }
    else
    {
     error_interior_design = '';
   $('#error_interior_design').text(error_interior_design);
   $('#interior_design').removeClass('has-error');
    }
    error_interior = '';
   $('#error_interior').text(error_interior);
   $('#interior').removeClass('has-error');
    }
    //
     if($('#wall_design').val() == '')
  {
   error_wall_design = 'Required Action';
   $('#error_wall_design').text(error_wall_design);
   $('#wall_design').addClass('has-error');
  }
  else
   {
    if($('#wall_design').val()=='Yes' && $('#wall_design_layouts').length==1 && $.trim($('#wall_design_layouts').val()).length == 0)
    {
     error_wall_design_layouts = 'Choose Doc';
   $('#error_wall_design_layouts').text(error_wall_design_layouts);
   $('#wall_design_layouts').addClass('has-error');;
    }
    else
    {
     error_wall_design_layouts = '';
   $('#error_wall_design_layouts').text(error_wall_design_layouts);
   $('#wall_design_layouts').removeClass('has-error');
    }
    error_wall_design = '';
   $('#error_wall_design').text(error_wall_design);
   $('#wall_design').removeClass('has-error');
    }
    //
    if($('#coming_soon_banner_installation').val() == '')
  {
   error_coming_soon_banner_installation = 'Required Action';
   $('#error_coming_soon_banner_installation').text(error_coming_soon_banner_installation);
   $('#coming_soon_banner_installation').addClass('has-error');
  }
  else
   {
    error_coming_soon_banner_installation = '';
   $('#error_coming_soon_banner_installation').text(error_coming_soon_banner_installation);
   $('#coming_soon_banner_installation').removeClass('has-error');
    }
    //
     if($('#furnitures').val() == '')
  {
   error_furnitures = 'Required Action';
   $('#error_furnitures').text(error_furnitures);
   $('#furnitures').addClass('has-error');
  }
  else
   {
    error_furnitures = '';
   $('#error_furnitures').text(error_furnitures);
   $('#furnitures').removeClass('has-error');
    }
    //
    if($('#false_ceiling_work').val() == '')
  {
   error_false_ceiling_work = 'Required Action';
   $('#error_false_ceiling_work').text(error_false_ceiling_work);
   $('#false_ceiling_work').addClass('has-error');
  }
  else
   {
    error_false_ceiling_work = '';
   $('#error_false_ceiling_work').text(error_false_ceiling_work);
   $('#false_ceiling_work').removeClass('has-error');
    }
    //
     if($('#electricity').val() == '')
  {
   error_electricity = 'Required Action';
   $('#error_electricity').text(error_electricity);
   $('#electricity').addClass('has-error');
  }
  else
   {
    error_electricity = '';
   $('#error_electricity').text(error_electricity);
   $('#electricity').removeClass('has-error');
    }
    //
    if($('#water_drainage').val() == '')
  {
   error_water_drainage = 'Required Action';
   $('#error_water_drainage').text(error_water_drainage);
   $('#water_drainage').addClass('has-error');
  }
  else
   {
    error_water_drainage = '';
   $('#error_water_drainage').text(error_water_drainage);
   $('#water_drainage').removeClass('has-error');
    }
    //
     if($('#ac').val() == '')
  {
   error_ac = 'Required Action';
   $('#error_ac').text(error_ac);
   $('#ac').addClass('has-error');
  }
  else
   {
    error_ac = '';
   $('#error_ac').text(error_ac);
   $('#ac').removeClass('has-error');
    }
    //
    if($('#music_system').val() == '')
  {
   error_music_system = 'Required Action';
   $('#error_music_system').text(error_music_system);
   $('#music_system').addClass('has-error');
  }
  else
   {
    error_music_system = '';
   $('#error_music_system').text(error_music_system);
   $('#music_system').removeClass('has-error');
    }
    //
     if($('#wifi').val() == '')
  {
   error_wifi = 'Required Action';
   $('#error_wifi').text(error_wifi);
   $('#wifi').addClass('has-error');
  }
  else
   {
    error_wifi = '';
   $('#error_wifi').text(error_wifi);
   $('#wifi').removeClass('has-error');
    }
    //
    if($('#cctv').val() == '')
  {
   error_cctv = 'Required Action';
   $('#error_cctv').text(error_cctv);
   $('#cctv').addClass('has-error');
  }
  else
   {
    error_cctv = '';
   $('#error_cctv').text(error_cctv);
   $('#cctv').removeClass('has-error');
    }
    //
    if($('#gas_bank').val() == '')
  {
   error_gas_bank = 'Required Action';
   $('#error_gas_bank').text(error_gas_bank);
   $('#gas_bank').addClass('has-error');
  }
  else
   {
    error_gas_bank = '';
   $('#error_gas_bank').text(error_gas_bank);
   $('#gas_bank').removeClass('has-error');
    }
    //
     if($('#kitchen').val() == '')
  {
   error_kitchen = 'Required Action';
   $('#error_kitchen').text(error_kitchen);
   $('#kitchen').addClass('has-error');
  }
  else
   {
    error_kitchen = '';
   $('#error_kitchen').text(error_kitchen);
   $('#kitchen').removeClass('has-error');
    }
    //
    if($('#menu_display').val() == '')
  {
   error_menu_display = 'Required Action';
   $('#error_menu_display').text(error_menu_display);
   $('#menu_display').addClass('has-error');
  }
  else
   {
    error_menu_display = '';
   $('#error_menu_display').text(error_menu_display);
   $('#menu_display').removeClass('has-error');
    }
    //
    if($('#coke_cooler').val() == '')
  {
   error_coke_cooler = 'Required Action';
   $('#error_coke_cooler').text(error_coke_cooler);
   $('#coke_cooler').addClass('has-error');
  }
  else
   {
    error_coke_cooler = '';
   $('#error_coke_cooler').text(error_coke_cooler);
   $('#coke_cooler').removeClass('has-error');
    }
    //
     if($('#fire_extinguisher').val() == '')
  {
   error_fire_extinguisher = 'Required Action';
   $('#error_fire_extinguisher').text(error_fire_extinguisher);
   $('#fire_extinguisher').addClass('has-error');
  }
  else
   {
    error_fire_extinguisher = '';
   $('#error_fire_extinguisher').text(error_fire_extinguisher);
   $('#fire_extinguisher').removeClass('has-error');
    }
    //
     if($('#signage_board').val() == '')
  {
   error_signage_board = 'Required Action';
   $('#error_signage_board').text(error_signage_board);
   $('#signage_board').addClass('has-error');
  }
  else
   {
     if($('#signage_board').val()=='Yes' && $('#signage_board_design').length==1 &&  $.trim($('#signage_board_design').val()).length == 0)
    {
     error_signage_board_design = 'Choose Doc';
   $('#error_signage_board_design').text(error_signage_board_design);
   $('#signage_board_design').addClass('has-error');;
    }
    else
    {
     error_signage_board_design = '';
   $('#error_signage_board_design').text(error_signage_board_design);
   $('#signage_board_design').removeClass('has-error');
    }

    error_signage_board = '';
   $('#error_signage_board').text(error_signage_board);
   $('#signage_board').removeClass('has-error');
    }
    //
      if($('#certificate_display').val() == '')
  {
   error_certificate_display = 'Required Action';
   $('#error_certificate_display').text(error_certificate_display);
   $('#certificate_display').addClass('has-error');
  }
  else
   {
    error_certificate_display = '';
   $('#error_certificate_display').text(error_certificate_display);
   $('#certificate_display').removeClass('has-error');
    }
    //
    if(error_layouts != '' || error_layouts_design != '' || error_interior != '' || error_interior_design != '' || error_wall_design != '' || error_wall_design_layouts != '' || error_coming_soon_banner_installation != '' || error_furnitures != '' || error_false_ceiling_work != '' || error_electricity != '' || error_water_drainage != '' || error_ac != '' || error_wifi != '' || error_cctv != '' || error_gas_bank != '' || error_kitchen != '' || error_menu_display != '' || error_coke_cooler != '' || error_fire_extinguisher != '' || error_signage_board != '' || error_gas_bank != '' || error_signage_board_design != '' || error_certificate_display != '')
  {
    
   return false;
  }
  else
  {
  submit_form()
  }

    //
  }
  else if(level==2)
  {
   var error_official_mail='';
   var error_official_mail_id='';
   var error_google_listing='';
   var error_google_link='';
   var error_fbpage='';
   var error_fblink='';
   var error_instapage='';
   var error_instalink='';
   var error_menu_dine_in='';
   var error_menu_dine_in_doc='';
   var error_menu_online='';
   var error_menu_online_doc='';
   var error_coming_soon_banner_status='';
   var error_coming_soon_banner=''
   var error_npi='';
   var error_npi_template='';
   var error_hoarding='';
   var error_hoarding_design='';
   var error_banner='';
   var error_banner_doc='';
   var error_newspaper='';
   var error_newspaper_ad='';
   var error_foodshots='';
   var error_foodshots_doc='';
   //1
   if($('#official_mail').val() == '')
  {
   error_official_mail = 'Required Action';
   $('#error_official_mail').text(error_official_mail);
   $('#official_mail').addClass('has-error');
  }
  else
   {
    if($('#official_mail').val()=='Yes' && $.trim($('#official_mail_id').val()).length == 0)
    {
     error_official_mail_id = 'Enter Link';
   $('#error_official_mail_id').text(error_official_mail_id);
   $('#official_mail_id').addClass('has-error');;
    }
    else
    {
     error_official_mail_id = '';
   $('#error_official_mail_id').text(error_official_mail_id);
   $('#official_mail_id').removeClass('has-error');
    }
    error_official_mail = '';
   $('#error_official_mail').text(error_official_mail);
   $('#official_mail').removeClass('has-error');
    }
   //2
   if($('#google_listing').val() == '')
  {
   error_google_listing = 'Required Action';
   $('#error_google_listing').text(error_google_listing);
   $('#google_listing').addClass('has-error');
  }
  else
   {
    if($('#google_listing').val()=='Yes' && $.trim($('#google_link').val()).length == 0)
    {
     error_google_link = 'Enter Link';
   $('#error_google_link').text(error_google_link);
   $('#google_link').addClass('has-error');;
    }
    else
    {
     error_google_link = '';
   $('#error_google_link').text(error_google_link);
   $('#google_link').removeClass('has-error');
    }
    error_google_listing = '';
   $('#error_google_listing').text(error_google_listing);
   $('#google_listing').removeClass('has-error');
    }
   //3
   if($('#fbpage').val() == '')
  {
   error_fbpage = 'Required Action';
   $('#error_fbpage').text(error_fbpage);
   $('#fbpage').addClass('has-error');
  }
  else
   {
    if($('#fbpage').val()=='Yes' && $.trim($('#fblink').val()).length == 0)
    {
     error_fblink = 'Link';
   $('#error_fblink').text(error_fblink);
   $('#fblink').addClass('has-error');;
    }
    else
    {
     error_fblink = '';
   $('#error_fblink').text(error_fblink);
   $('#fblink').removeClass('has-error');
    }
    error_fbpage = '';
   $('#error_fbpage').text(error_fbpage);
   $('#fbpage').removeClass('has-error');
    }
   //4
   if($('#instapage').val() == '')
  {
   error_instapage = 'Required Action';
   $('#error_instapage').text(error_instapage);
   $('#instapage').addClass('has-error');
  }
  else
   {
    if($('#instapage').val()=='Yes' && $.trim($('#instalink').val()).length == 0)
    {
     error_instalink = 'Link';
   $('#error_instalink').text(error_instalink);
   $('#instalink').addClass('has-error');;
    }
    else
    {
     error_instalink = '';
   $('#error_instalink').text(error_instalink);
   $('#instalink').removeClass('has-error');
    }
    error_instapage = '';
   $('#error_instapage').text(error_instapage);
   $('#instapage').removeClass('has-error');
    }
   //5
   if($('#menu_dine_in').val() == '')
  {
   error_menu_dine_in = 'Required Action';
   $('#error_menu_dine_in').text(error_menu_dine_in);
   $('#menu_dine_in').addClass('has-error');
  }
  else
   {
    if($('#menu_dine_in').val()=='Yes' && $('#menu_dine_in_doc').length==1 && $.trim($('#menu_dine_in_doc').val()).length == 0)
    {
     error_menu_dine_in_doc = 'Choose Doc';
   $('#error_menu_dine_in_doc').text(error_menu_dine_in_doc);
   $('#menu_dine_in_doc').addClass('has-error');;
    }
    else
    {
     error_menu_dine_in_doc = '';
   $('#error_menu_dine_in_doc').text(error_menu_dine_in_doc);
   $('#menu_dine_in_doc').removeClass('has-error');
    }
    error_menu_dine_in = '';
   $('#error_menu_dine_in').text(error_menu_dine_in);
   $('#menu_dine_in').removeClass('has-error');
    }
   //6
   if($('#menu_online').val() == '')
  {
   error_menu_online = 'Required Action';
   $('#error_menu_online').text(error_menu_online);
   $('#menu_online').addClass('has-error');
  }
  else
   {



   if($('#menu_online').val()=='Yes' && $('#menu_online_doc').length==1 && $.trim($('#menu_online_doc').val()).length == 0)
    {
     error_menu_online_doc = 'Choose Doc';
   $('#error_menu_online_doc').text(error_menu_online_doc);
   $('#menu_online_doc').addClass('has-error');;
    }
    else
    {
     error_menu_online_doc = '';
   $('#error_menu_online_doc').text(error_menu_online_doc);
   $('#menu_online_doc').removeClass('has-error');
    }


   //  if($('#menu_online').val()=='Yes' &&  $.trim($('#menu_link').val()).length == 0)
   //  {
   //   error_menu_link = 'Enter Link';
   // $('#error_menu_link').text(error_menu_link);
   // $('#menu_link').addClass('has-error');;
   //  }
   //  else
   //  {
   //   error_menu_link = '';
   // $('#error_menu_link').text(error_menu_link);
   // $('#menu_link').removeClass('has-error');
   //  }
    error_menu_online = '';
   $('#error_menu_online').text(error_menu_online);
   $('#menu_online').removeClass('has-error');
    }
 
   //9
   if($('#npi').val() == '')
  {
   error_npi = 'Required Action';
   $('#error_npi').text(error_npi);
   $('#npi').addClass('has-error');
  }
  else
   {
    if($('#npi').val()=='Yes' && $('#npi_template').length==1 && $.trim($('#npi_template').val()).length == 0)
    {
     error_npi_template = 'Choose Doc';
   $('#error_npi_template').text(error_npi_template);
   $('#npi_template').addClass('has-error');;
    }
    else
    {
     error_npi_template = '';
   $('#error_npi_template').text(error_npi_template);
   $('#npi_template').removeClass('has-error');
    }
    error_npi = '';
   $('#error_npi').text(error_npi);
   $('#npi').removeClass('has-error');
    }
     //9
   if($('#coming_soon_banner_status').val() == '')
  {
   error_coming_soon_banner_status = 'Required Action';
   $('#error_coming_soon_banner_status').text(error_coming_soon_banner_status);
   $('#coming_soon_banner_status').addClass('has-error');
  }
  else
   {
    if($('#coming_soon_banner_status').val()=='Yes' && $('#coming_soon_banner').length==1  && $.trim($('#coming_soon_banner').val()).length == 0)
    {
     error_coming_soon_banner = 'Choose Doc';
   $('#error_coming_soon_banner').text(error_coming_soon_banner);
   $('#coming_soon_banner').addClass('has-error');;
    }
    else
    {
     error_coming_soon_banner = '';
   $('#error_coming_soon_banner').text(error_coming_soon_banner);
   $('#coming_soon_banner').removeClass('has-error');
    }
    error_coming_soon_banner_status = '';
   $('#error_coming_soon_banner_status').text(error_coming_soon_banner_status);
   $('#coming_soon_banner_status').removeClass('has-error');
    }
   //10
   if($('#hoarding').val() == '')
  {
   error_hoarding = 'Required Action';
   $('#error_hoarding').text(error_hoarding);
   $('#hoarding').addClass('has-error');
  }
  else
   {
    if($('#hoarding').val()=='Yes' && $('#hoarding_design').length==1  &&  $.trim($('#hoarding_design').val()).length == 0)
    {
     error_hoarding_design = 'Choose Doc';
   $('#error_hoarding_design').text(error_hoarding_design);
   $('#hoarding_design').addClass('has-error');;
    }
    else
    {
     error_hoarding_design = '';
   $('#error_hoarding_design').text(error_hoarding_design);
   $('#hoarding_design').removeClass('has-error');
    }
    error_hoarding = '';
   $('#error_hoarding').text(error_hoarding);
   $('#hoarding').removeClass('has-error');
    }
   //11
   if($('#banner').val() == '')
  {
   error_banner = 'Required Action';
   $('#error_banner').text(error_banner);
   $('#banner').addClass('has-error');
  }
  else
   {
    if($('#banner').val()=='Yes' && $('#banner_doc').length==1  &&  $.trim($('#banner_doc').val()).length == 0)
    {
     error_banner_doc = 'Choose Doc';
   $('#error_banner_doc').text(error_banner_doc);
   $('#banner_doc').addClass('has-error');;
    }
    else
    {
     error_banner_doc = '';
   $('#error_banner_doc').text(error_banner_doc);
   $('#banner_doc').removeClass('has-error');
    }
    error_banner = '';
   $('#error_banner').text(error_banner);
   $('#banner').removeClass('has-error');
    }
   //12
   if($('#newspaper').val() == '')
  {
   error_newspaper = 'Required Action';
   $('#error_newspaper').text(error_newspaper);
   $('#newspaper').addClass('has-error');
  }
  else
   {
    if($('#newspaper').val()=='Yes' && $('#newspaper_ad').length==1  && $.trim($('#newspaper_ad').val()).length == 0)
    {
     error_newspaper_ad = 'Choose Doc';
   $('#error_newspaper_ad').text(error_newspaper_ad);
   $('#newspaper_ad').addClass('has-error');;
    }
    else
    {
     error_newspaper_ad = '';
   $('#error_newspaper_ad').text(error_newspaper_ad);
   $('#newspaper_ad').removeClass('has-error');
    }
    error_newspaper = '';
   $('#error_newspaper').text(error_newspaper);
   $('#newspaper').removeClass('has-error');
    }
   //13
   if($('#foodshots').val() == '')
  {
   error_foodshots = 'Required Action';
   $('#error_foodshots').text(error_foodshots);
   $('#foodshots').addClass('has-error');
  }
  else
   {
    if($('#foodshots').val()=='Yes' && $('#foodshots_doc').length==1  && $.trim($('#foodshots_doc').val()).length == 0)
    {
     error_foodshots_doc = 'Choose Doc';
   $('#error_foodshots_doc').text(error_foodshots_doc);
   $('#foodshots_doc').addClass('has-error');;
    }
    else
    {
     error_foodshots_doc = '';
   $('#error_foodshots_doc').text(error_foodshots_doc);
   $('#foodshots_doc').removeClass('has-error');
    }
    error_foodshots = '';
   $('#error_foodshots').text(error_foodshots);
   $('#foodshots').removeClass('has-error');
    }
   //
    if(error_official_mail != '' || error_official_mail_id != '' || error_google_listing != '' || error_google_link != '' || error_fbpage != '' || error_fblink != '' || error_instapage != '' || error_instalink != '' || error_menu_dine_in != '' || error_menu_dine_in_doc != '' || error_menu_online != '' || error_menu_online_doc != '' || error_npi != '' || error_npi_template != '' || error_hoarding != '' || error_hoarding_design != '' || error_banner != '' || error_banner_doc != '' || error_newspaper != '' || error_newspaper_ad != '' || error_foodshots != '' || error_foodshots_doc != '' || error_coming_soon_banner_status != '' || error_coming_soon_banner != '')
  {
   return false;
  }
  else
  {
     submit_form()
  }
   //
  }
   else if(level==4)
  {
    var error_agreement='';
    var error_agreement_doc='';
    var error_gst_ops='';
    var error_zomato='';
    var error_zomato_text='';
    var error_swiggy='';
    var error_swiggy_text='';
    var error_local_food='';
    var error_local_food_text='';
    var error_man_power_mou='';
    var error_man_power_mou_doc='';
    var error_billing_software='';
    var error_edc_machine='';
    var error_cctv_access='';
    var error_sops='';
    var chef_travel_plan='';
    var error_dry_run='';
    var error_dry_run_text='';
    var error_cutlery='';
    var error_uniforms='';
    var error_central_supply='';
    var error_temple='';
    var error_man_power='';
    var error_local_purchase='';
   
    //1
    if($('#agreement').val() == '')
  {
   error_agreement = 'Required Action';
   $('#error_agreement').text(error_agreement);
   $('#agreement').addClass('has-error');
  }
  else
   {
    if($('#agreement').val()=='Yes' && $('#agreement_doc').length==1 && $.trim($('#agreement_doc').val()).length == 0)
    {
     error_agreement_doc = 'Choose Doc';
   $('#error_agreement_doc').text(error_agreement_doc);
   $('#agreement_doc').addClass('has-error');;
    }
    else
    {
     error_agreement_doc = '';
   $('#error_agreement_doc').text(error_agreement_doc);
   $('#agreement_doc').removeClass('has-error');
    }
    error_agreement = '';
   $('#error_agreement').text(error_agreement);
   $('#agreement').removeClass('has-error');
    }
   //2
    if($('#gst_ops').val() == '')
  {
   error_gst_ops = 'Required Action';
   $('#error_gst_ops').text(error_gst_ops);
   $('#gst_ops').addClass('has-error');
  }
  else
   {
    error_gst_ops = '';
   $('#error_gst_ops').text(error_gst_ops);
   $('#gst_ops').removeClass('has-error');
    }
      //3
   if($('#zomato').val() == '')
  {
   error_zomato = 'Required Action';
   $('#error_zomato').text(error_zomato);
   $('#zomato').addClass('has-error');
  }
  else
   {
    
   if($('#zomato').val()=='Yes' && $.trim($('#zomato_text').val()).length == 0)
    {
     error_zomato_text = 'Enter Text';
   $('#error_zomato_text').text(error_zomato_text);
   $('#zomato_text').addClass('has-error');;
    }
    else
    {
     error_zomato_text = '';
   $('#error_zomato_text').text(error_zomato_text);
   $('#zomato_text').removeClass('has-error');
    }

    error_zomato = '';
   $('#error_zomato').text(error_zomato);
   $('#zomato').removeClass('has-error');
    }
   //4
   if($('#swiggy').val() == '')
  {
   error_swiggy = 'Required Action';
   $('#error_swiggy').text(error_swiggy);
   $('#swiggy').addClass('has-error');
  }
  else
   {
    if($('#swiggy').val()=='Yes' && $.trim($('#swiggy_text').val()).length == 0)
    {
     error_swiggy_text = 'Enter Text';
   $('#error_swiggy_text').text(error_swiggy_text);
   $('#swiggy_text').addClass('has-error');;
    }
    else
    {
     error_swiggy_text = '';
   $('#error_swiggy_text').text(error_swiggy_text);
   $('#swiggy_text').removeClass('has-error');
    }
    error_swiggy = '';
   $('#error_swiggy').text(error_swiggy);
   $('#swiggy').removeClass('has-error');
    }
     //5
   if($('#local_food').val() == '')
  {
   error_local_food = 'Required Action';
   $('#error_local_food').text(error_local_food);
   $('#local_food').addClass('has-error');
  }
  else
   {
    if($('#local_food').val()=='Yes' && $.trim($('#local_food_text').val()).length == 0)
    {
     error_local_food_text = 'Enter Text';
   $('#error_local_food_text').text(error_local_food_text);
   $('#local_food_text').addClass('has-error');;
    }
    else
    {
     error_local_food_text = '';
   $('#error_local_food_text').text(error_local_food_text);
   $('#local_food_text').removeClass('has-error');
    }
    error_local_food = '';
   $('#error_local_food').text(error_local_food);
   $('#local_food').removeClass('has-error');
    }
     //6
   if($('#man_power_mou').val() == '')
  {
   error_man_power_mou = 'Required Action';
   $('#error_man_power_mou').text(error_man_power_mou);
   $('#man_power_mou').addClass('has-error');
  }
  else
   {
    if($('#man_power_mou').val()=='Yes' && $('#man_power_mou_doc').length==1  && $.trim($('#man_power_mou_doc').val()).length == 0)
    {
     error_man_power_mou_doc = 'Choose Doc';
   $('#error_man_power_mou_doc').text(error_man_power_mou_doc);
   $('#man_power_mou_doc').addClass('has-error');;
    }
    else
    {
     error_man_power_mou_doc = '';
   $('#error_man_power_mou_doc').text(error_man_power_mou_doc);
   $('#man_power_mou_doc').removeClass('has-error');
    }
    error_man_power_mou = '';
   $('#error_man_power_mou').text(error_man_power_mou);
   $('#man_power_mou').removeClass('has-error');
    }
     //7
    if($('#billing_software').val() == '')
  {
   error_billing_software = 'Required Action';
   $('#error_billing_software').text(error_billing_software);
   $('#billing_software').addClass('has-error');
  }
  else
   {
    error_billing_software = '';
   $('#error_billing_software').text(error_billing_software);
   $('#billing_software').removeClass('has-error');
    }
  
     //8
    if($('#edc_machine').val() == '')
  {
   error_edc_machine = 'Required Action';
   $('#error_edc_machine').text(error_edc_machine);
   $('#edc_machine').addClass('has-error');
  }
  else
   {
    error_edc_machine = '';
   $('#error_edc_machine').text(error_edc_machine);
   $('#edc_machine').removeClass('has-error');
    }
    //9
    if($('#cctv_access').val() == '')
  {
   error_cctv_access = 'Required Action';
   $('#error_cctv_access').text(error_cctv_access);
   $('#cctv_access').addClass('has-error');
  }
  else
   {
    error_cctv_access = '';
   $('#error_cctv_access').text(error_cctv_access);
   $('#cctv_access').removeClass('has-error');
    }
    //10
    if($('#sops').val() == '')
  {
   error_sops = 'Required Action';
   $('#error_sops').text(error_sops);
   $('#sops').addClass('has-error');
  }
  else
   {
    error_sops = '';
   $('#error_sops').text(error_sops);
   $('#sops').removeClass('has-error');
    }
     //11
    if($('#chef_travel_plan').val() == '')
  {
   error_chef_travel_plan = 'Required Action';
   $('#error_chef_travel_plan').text(error_chef_travel_plan);
   $('#chef_travel_plan').addClass('has-error');
  }
  else
   {
    error_chef_travel_plan = '';
   $('#error_chef_travel_plan').text(error_chef_travel_plan);
   $('#chef_travel_plan').removeClass('has-error');
    }
    //12
     if($('#dry_run').val() == '')
  {
   error_dry_run = 'Required Action';
   $('#error_dry_run').text(error_dry_run);
   $('#dry_run').addClass('has-error');
  }
  else
   {
    if($('#dry_run').val()=='Yes' && $.trim($('#dry_run_text').val()).length == 0)
    {
     error_dry_run_text = 'Enter Text';
   $('#error_dry_run_text').text(error_dry_run_text);
   $('#dry_run_text').addClass('has-error');;
    }
    else
    {
     error_dry_run_text = '';
   $('#error_dry_run_text').text(error_dry_run_text);
   $('#dry_run_text').removeClass('has-error');
    }
    error_dry_run = '';
   $('#error_dry_run').text(error_dry_run);
   $('#dry_run').removeClass('has-error');
    }
    //13
    if($('#cutlery').val() == '')
  {
   error_cutlery = 'Required Action';
   $('#error_cutlery').text(error_cutlery);
   $('#cutlery').addClass('has-error');
  }
  else
   {
    error_cutlery = '';
   $('#error_cutlery').text(error_cutlery);
   $('#cutlery').removeClass('has-error');
    }
    //14
    if($('#uniforms').val() == '')
  {
   error_uniforms = 'Required Action';
   $('#error_uniforms').text(error_uniforms);
   $('#uniforms').addClass('has-error');
  }
  else
   {
    error_uniforms = '';
   $('#error_uniforms').text(error_uniforms);
   $('#uniforms').removeClass('has-error');
    }
    //15
    if($('#central_supply').val() == '')
  {
   error_central_supply = 'Required Action';
   $('#error_central_supply').text(error_central_supply);
   $('#central_supply').addClass('has-error');
  }
  else
   {
    error_central_supply = '';
   $('#error_central_supply').text(error_central_supply);
   $('#central_supply').removeClass('has-error');
    }
   
   //16
    if($('#temple').val() == '')
  {
   error_temple = 'Required Action';
   $('#error_temple').text(error_temple);
   $('#temple').addClass('has-error');
  }
  else
   {
    error_temple = '';
   $('#error_temple').text(error_temple);
   $('#temple').removeClass('has-error');
    }
  
   //17
    if($('#man_power').val() == '')
  {
   error_man_power = 'Required Action';
   $('#error_man_power').text(error_man_power);
   $('#man_power').addClass('has-error');
  }
  else
   {
    error_man_power = '';
   $('#error_man_power').text(error_man_power);
   $('#man_power').removeClass('has-error');
    }
   
   //18
    if($('#local_purchase').val() == '')
  {
   error_local_purchase = 'Required Action';
   $('#error_local_purchase').text(error_local_purchase);
   $('#local_purchase').addClass('has-error');
  }
  else
   {
    error_local_purchase = '';
   $('#error_local_purchase').text(error_local_purchase);
   $('#local_purchase').removeClass('has-error');
    }
   
     //
    if(error_agreement != '' || error_agreement_doc != '' || error_gst_ops != ''  || error_zomato != '' || error_zomato_text != '' || error_swiggy != ''  || error_swiggy_text != '' || error_local_food != '' || error_local_food_text != '' || error_man_power_mou != ''  || error_man_power_mou_doc != ''    || error_billing_software != '' || error_edc_machine != '' || error_cctv_access!='' || error_sops != '' || chef_travel_plan != '' || error_dry_run != '' || error_dry_run_text != '' || error_cutlery != '' || error_uniforms != '' || error_central_supply != '' || error_temple != '' || error_man_power != '' || error_local_purchase != '')
  {
   return false;
  }
  else
  {
     submit_form()
  }
   //
    //
  }
   else if(level==5)
  {
    var error_no_dues='';
    var error_payment_clearance='';
    var error_royalty_pdc='';
    var error_royalty_pdc_text_data='';
    var error_royalty_pdc_agreement_data='';
    var error_agreementstatus='';
    var error_agreement_return_date='';
    var error_agreement='';
    if($('#no_dues').val() == '')
  {
   error_no_dues = 'Required Action';
   $('#error_no_dues').text(error_no_dues);
   $('#no_dues').addClass('has-error');
  }
  else
   {
    if($('#no_dues').val()=='Yes'  && $('#payment_clearance').length==1  && $.trim($('#payment_clearance').val()).length == 0)
    {
     error_payment_clearance = 'Choose Doc';
   $('#error_payment_clearance').text(error_payment_clearance);
   $('#payment_clearance').addClass('has-error');;
    }
    else
    {
     error_payment_clearance = '';
   $('#error_payment_clearance').text(error_payment_clearance);
   $('#payment_clearance').removeClass('has-error');
    }
    error_no_dues = '';
   $('#error_no_dues').text(error_no_dues);
   $('#no_dues').removeClass('has-error');
    }
    //
     if($('#royalty_pdc').val() == '')
  {
   error_royalty_pdc = 'Required Action';
   $('#error_royalty_pdc').text(error_royalty_pdc);
   $('#royalty_pdc').addClass('has-error');
  }
  else
   {

    if($('#royalty_pdc').val()==2 &&  $.trim($('#royalty_pdc_text_data').val()).length == 0)
    {
     error_royalty_pdc_text_data = 'Enter Text';
   $('#error_royalty_pdc_text_data').text(error_royalty_pdc_text_data);
   $('#royalty_pdc_text_data').addClass('has-error');;
    }
    else
    {
     error_royalty_pdc_text_data = '';
   $('#error_royalty_pdc_text_data').text(error_royalty_pdc_text_data);
   $('#royalty_pdc_text_data').removeClass('has-error');
    }
    //
     if($('#royalty_pdc').val()==2  && $('#royalty_pdc_agreement_data').length==1  &&  $.trim($('#royalty_pdc_agreement_data').val()).length == 0)
    {
     error_royalty_pdc_agreement_data = 'Choose Doc';
   $('#error_royalty_pdc_agreement_data').text(error_royalty_pdc_agreement_data);
   $('#royalty_pdc_agreement_data').addClass('has-error');;
    }
    else
    {
     error_royalty_pdc_agreement_data = '';
   $('#error_royalty_pdc_agreement_data').text(error_royalty_pdc_agreement_data);
   $('#royalty_pdc_agreement_data').removeClass('has-error');
    }
    //
    error_royalty_pdc = '';
   $('#error_royalty_pdc').text(error_royalty_pdc);
   $('#royalty_pdc').removeClass('has-error');
    }
    //
    if($('#agreementstatus').val() == '')
  {
   error_agreementstatus = 'Required Action';
   $('#error_agreementstatus').text(error_agreementstatus);
   $('#agreementstatus').addClass('has-error');
  }
  else
   {
    if($('#agreementstatus').val()==2 &&  $.trim($('#agreement_return_date').val()).length == 0)
    {
     error_agreement_return_date = 'Select Date';
   $('#error_agreement_return_date').text(error_agreement_return_date);
   $('#agreement_return_date').addClass('has-error');


    }
    else
    {
     error_agreement_return_date = '';
   $('#error_agreement_return_date').text(error_agreement_return_date);
   $('#agreement_return_date').removeClass('has-error');
    }
    //
     if($('#agreementstatus').val()==2  && $('#agreement').length==1 &&  $.trim($('#agreement').val()).length == 0)
    {
     
     error_agreement = 'Choose Doc';
   $('#error_agreement').text(error_agreement);
   $('#agreement').addClass('has-error');;
    }
    else
    {
     error_agreement = '';
   $('#error_agreement').text(error_agreement);
   $('#agreement').removeClass('has-error');
    }
    //
    error_agreementstatus = '';
   $('#error_agreementstatus').text(error_agreementstatus);
   $('#agreementstatus').removeClass('has-error');
    }
    //
    if(error_no_dues != '' || error_payment_clearance != '' || error_royalty_pdc != '' || error_royalty_pdc_text_data != '' || error_royalty_pdc_agreement_data != '' || error_agreementstatus != '' || error_agreement_return_date != '' || error_agreement != '')
  {

   return false;
  }
  else
  {
     submit_form()
  }

    //

  }
  else if(level==6 || level==7)
  {
    
   var error_firm_name='';

    if($('#firm_name').val() == '')
  {
   error_firm_name = 'Required Action';
   $('#error_firm_name').text(error_firm_name);
   $('#firm_name').addClass('has-error');
  }
  else
   {
   
    error_firm_name = '';
   $('#error_firm_name').text(error_firm_name);
   $('#firm_name').removeClass('has-error');
    }
    //
if(error_firm_name != '')
  {
   return false;
  }
  else
  {
     submit_form()
  }


    //
  }





})


function submit_form()
{

 $("#overlay").fadeIn(300);
  var form_data = new FormData($("#registration_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/store_pre_launch_data',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
           
        if(data=='success')
        {
       swal("Done !", 'Successfully Saved Basic Details', "success");
       if($("#level").val()==6)
       {
         var url=APP_URL+'/Fanchise-Account';
        window.location.href = url;
       }
       else
       {
         var url=APP_URL+'/Ongoing-Pre-launch';
        window.location.href = url;
       }
       
     
       }
       else if(data=='launch')
       {
        var url=APP_URL+'/Launch-Franchise';
        window.location.href = url;
       }
       else if(data=='Kindly Clear Due Amount')
       {
         swal("Error", data, "error"); 
         var url=APP_URL+'/Pending-Fee';
        window.location.href = url;
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
//
   //aggrementstatus
      $(document).on("change","#agreementstatus",function()
      {
        var value=$(this).val()

        if(value==2)
        {
   $("#agreement_account_doc").css("display","block")
   $("#agreement_return").css("display","block")
 
        }
        else
        {
  $("#agreement_account_doc").css("display","none")
  $("#agreement_return").css("display","none")
  
        }
      })
      //Royalty PDC 
      $(document).on("change","#royalty_pdc",function()
      {
        var value=$(this).val()

        if(value==2)
        {
   $("#royalty_pdc_text").css("display","block")
   $("#royalty_pdc_agreement").css("display","block")
 
        }
        else
        {
  $("#royalty_pdc_text").css("display","none")
  $("#royalty_pdc_agreement").css("display","none")
  
        }
      })
  //


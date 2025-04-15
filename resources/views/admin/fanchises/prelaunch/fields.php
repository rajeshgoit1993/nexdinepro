
       
PreLaunch
PreLaunchDoc








layouts  error_layouts


layouts_design              error_layouts_design

interior                   error_interior
interior_design            error_interior_design
wall_design                error_wall_design
wall_design_layouts        error_wall_design_layouts

official_mail   error_official_mail
official_mail_id error_official_mail_id
google_listing   error_google_listing
google_link  error_google_link
fbpage    error_fbpage
fblink    error_fblink
instapage error_instapage
instalink  error_instalink
menu_dine_in error_menu_dine_in
menu_dine_in_doc  error_menu_dine_in_doc
menu_online   error_menu_online
menu_link     error_menu_link
zomato  error_zomato
swiggy   error_swiggy
npi  error_npi
npi_template  error_npi_template
hoarding   error_hoarding
hoarding_design  error_hoarding_design
banner   error_banner
banner_doc   error_banner_doc
newspaper   error_newspaper
newspaper_ad error_newspaper_ad
foodshots  error_foodshots
foodshots_doc  error_foodshots_doc

agreement error_agreement
agreement_doc error_agreement_doc
man_power  error_man_power
signage_board error_signage_board
menu_display  error_menu_display
temple   error_temple
edc_machine  error_edc_machine
billing_software  error_billing_software
coke_cooler  error_coke_cooler
local_purchase  error_local_purchase
central_supply  error_central_supply
sops   error_sops
uniforms  error_uniforms
kitchen   error_kitchen
cutlery   error_cutlery
furnitures  error_furnitures
gas_bank    error_gas_bank
electricity  error_electricity
water_drainage   error_water_drainage
music_system    error_music_system
ac  error_ac
wifi  error_wifi
cctv   error_cctv
fire_extinguisher error_fire_extinguisher



no_dues  error_no_dues
payment_clearance error_payment_clearance


firm_name           error_firm_name
registration_doc    error_registration_doc

shop_aggrement      error_shop_aggrement

shop_aggrement_doc  error_shop_aggrement_doc

outlet_address  error_outlet_address

outlet_address_doc  error_outlet_address_doc

outlet_mail        error_outlet_mail

outlet_mobile     error_outlet_mobile

gst               error_gst

gst_doc           error_gst_doc

fssai           error_fssai

fssai_doc       error_fssai_doc


electricity_load   error_electricity_load

electricity_load_doc   error_electricity_load_doc

current_bank         error_current_bank

current_bank_doc        error_current_bank_doc

advance_reveived
first_installment_reveived
second_installment_reveived
third_installment_reveived
total_installments_amount

advance_reveived   error_advance_reveived
advance_reveived_date  error_advance_reveived_date
first_installment_reveived error_first_installment_reveived
first_installment_reveived_date  error_first_installment_reveived_date
second_installment_reveived  error_second_installment_reveived
second_installment_reveived_date  error_second_installment_reveived_date
third_installment_reveived   error_third_installment_reveived
third_installment_reveived_date  error_third_installment_reveived_date

<input type="hidden" id="level" name="level" value="1">
  $("#overlay").fadeIn(300);
  var form_data = new FormData($("#registration_form")[0]);
 var APP_URL=$("#APP_URL").val();
  $.ajax({
        url:APP_URL+'/kyc_update',
        data:form_data,
        type:'post',
        contentType: false,
        processData: false,
        
        success:function(data)
        {
            $("#overlay").fadeOut(300);
        if(data=='success')
        {
       swal("Done !", 'Successfully Uploaded KYC', "success");
        var url=APP_URL+'/Fanchise-Account';
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






















































       $table->string('mobile')->nullable();
 $table->string('level')->nullable();
 $table->string('fanchise_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('reporting_manager')->nullable();
            $table->string('user_fanchiseid')->nullable();
            
            $table->string('register_system_ip')->nullable();
            $table->string('brands')->nullable();
            $table->string('state')->nullable();
            $table->string('dist')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
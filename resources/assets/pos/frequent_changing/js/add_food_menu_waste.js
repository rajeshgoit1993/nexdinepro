$(function() {
    "use strict";
    let ingredient_already_remain = $("#ingredient_already_remain").val();
    let supplier_field_required = $("#supplier_field_required").val();
    let date_field_required = $("#date_field_required").val();
    let at_least_ingredient = $("#at_least_ingredient").val();
    let paid_field_required = $("#paid_field_required").val();
    let are_you_sure = $("#are_you_sure").val();
    let warning = $("#warning").val();
    let a_error = $("#a_error").val();
    let ok = $("#ok").val();
    let cancel = $("#cancel").val();
    let alert2 = $("#alert").val();
    let ingredient_id_container = [];
    //Initialize Select2 Elements
    $('.select2').select2();
    let suffix =0;

    let tab_index = 4;

    $(document).on('change', '#ingredient_id', function() {
        let ingredient_details = $('#ingredient_id').val();
        var gst_data = $('option:selected', this).attr('gst_data');
       
        if (ingredient_details != '') {
            let ingredient_details_array = ingredient_details.split('|');
            $(".rowCount").each(function() {
               let id_temp = $(this).attr('data-item_id');
               if(id_temp==(ingredient_details_array[0])){
                   swal({
                       title: alert2+"!",
                       text: ingredient_already_remain,
                       confirmButtonText: ok,
                       confirmButtonColor: '#3c8dbc'
                   });
                   $('#ingredient_id').val('').change();
                   exit;
                   return false;
               }

            });
            let currency = '';

            if($(".rowCount").length>0)
            {
              suffix=parseInt($(".rowCount").last().attr('data-id'))+parseInt(1);  
            }
            else
            {
              suffix++  
            }
            tab_index++;

            let cart_row = '<tr class="rowCount" data-item_id="' + ingredient_details_array[0] + '" data-id="' + suffix + '" id="row_' + suffix + '">' +
                '<td style="padding-left: 10px;"><p id="sl_' + suffix + '">' + suffix + '</p></td>' +
                '<td><span style="padding-bottom: 5px;">' + ingredient_details_array[1] +
                '</span></td>' +
                '<input type="hidden" id="ingredient_id_' + suffix +
                '" name="ingredient_id[]" value="' + ingredient_details_array[0] + '"/>' +
                 '<td><input type="text" required data-countID="' + suffix + '" tabindex="' + tab_index + 1 +
                '" id="quantity_amount_' + suffix +
                '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID"  placeholder="Qty"  ><span class="label_aligning">Pcs</span></td>' +

               

                '<td><a class="btn btn-danger btn-xs" style="margin-left: 5px; margin-top: 10px;" onclick="return deleter(' +
                suffix + ',' + ingredient_details_array[0] +
                ');" ><i style="color:white" class="fa fa-trash"></i> </a></td>' +
                '</tr>';
            tab_index++;

            $('#purchase_cart tbody').append(cart_row);

            $('#ingredient_id').val('').change();
            
        }
    });




})



function deleter(suffix, ingredient_id) {
    
    let alert2 = $("#alert").val();
    let are_you_sure = $("#are_you_sure").val();
    let warning = $("#warning").val();
    let a_error = $("#a_error").val();
    let ok = $("#ok").val();
    let cancel = $("#cancel").val();
    swal({
        title: alert2,
        text: are_you_sure,
        confirmButtonColor: '#3c8dbc',
        cancelButtonText: cancel,
        confirmButtonText: ok,
        showCancelButton: true
    }, function() {
        $("#row_" + suffix).remove();
       
    });
}


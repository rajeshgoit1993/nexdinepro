<table class="table"> 

<tr>
    <td>Waste Type :
        @if($data->loss_type==0)
Ingredient Wise
        @else
Food Menu Wise
        @endif
     </td>
    <td>Date :
<?php echo date("d-m-Y",strtotime($data->date)); ?></td>

</tr>
</table>
@if($data->loss_type==0)

 <table class="table">
                                    <thead>
                                    <tr>
                                            <th>SN</th>
                                            <th>Ingredient</th>
                                             <th>Quantity</th>    
                                               
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
<?php
 $i = 0;
 $ingredients_saved=DB::table('waste_ingredients')->where('waste_id',$data->id)->get();
  ?>
@foreach($ingredients_saved as $ing)
<?php
$i++;
  ?>
<tr class="rowCount" data-item_id="{{$ing->ingredient_id}}" data-id="{{$i}}" id="row_{{$i}}">
    <td style="padding-left: 10px;"><p id="sl_{{$i}}">{{$i}}</p></td>
    <td><span style="padding-bottom: 5px;">{{CustomHelpers::get_master_table_data('master_products','id',$ing->ingredient_id,'product_name')}} ({{CustomHelpers::get_master_table_data('master_products','id',$ing->ingredient_id,'item_code')}})</span></td>
    <input type="hidden" id="ingredient_id_{{$i}}" name="ingredient_id[]" value="{{$ing->ingredient_id}}">

    <td><input type="text" readonly required="" data-countid="{{$i}}"  id="quantity_amount_{{$i}}" name="quantity_amount[]" onfocus="this.select();" class=" integerchk aligning countID" placeholder="Qty" value="{{$ing->waste_amount}}"><span class="label_aligning"> {{CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_master_table_data('master_products','id',$ing->ingredient_id,'unit'),'unit')}}</span></td>



</tr>
@endforeach

                                    </tbody>

                                </table>
@else
<?php  
$food_menus=DB::table('waste_ingredients')->where('waste_id',$data->id)->groupBy('food_menu_id')->get();

?>
 <table class="table">
                                    <thead>
                                      <tr>
                                            <th>SN</th>
                                            <th>Food Menu</th>
                                             <th>Quantity</th>   
                                               
                                            
                                        </tr>
                                    </thead>
                                    <?php
 $i = 0;
  ?>
                                    <tbody>
@foreach($food_menus as $row=>$col)
<?php
$i++;

  ?>
<tr class="rowCount" data-item_id="{{$col->food_menu_id}}" data-id="{{$i}}" id="row_{{$i}}">
    <td style="padding-left: 10px;"><p id="sl_{{$i}}">{{$i}}</p></td>

    <td><span style="padding-bottom: 5px;">{{CustomHelpers::get_master_table_data('food_menus','id',$col->food_menu_id,'name')}} ({{CustomHelpers::get_master_table_data('food_menus','id',$col->food_menu_id,'code')}})</span></td>



    <td>{{$col->food_menu_qty}} Pcs </td>

 

</tr>
@endforeach

                                    </tbody>

                                </table>
                           


@endif
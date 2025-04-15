
<html>
<table>



    <tr>  
        
        
        <th>Item Code</th>
        
        <th>Ingredient Name</th>
        <th>Consumption</th>
        
        <th>Unit</th>
        

    </tr>
    @foreach($data as $d)


  <tr>
  <td >{{$d->ingredient_code}}</td>
 <td>{{CustomHelpers::get_master_table_data('master_products','id',$d->ingredient_id,'product_name')}} </td>
 <td>{{$d->consumption}}</td>

 <td>{{CustomHelpers::get_master_table_data('units','id',CustomHelpers::get_master_table_data('master_products','id',$d->ingredient_id,'unit'),'unit')}}</td>
 



  </tr>
    @endforeach
  
     
   
</table>


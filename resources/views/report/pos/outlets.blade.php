
    
     @foreach($data as $datas)
     <?php 
     $check=DB::table('franchise_sales')->where('outlet_id',$datas->id)->get();
     ?>
     <option value="{{$datas->id}}" @if(count($check)>0) style="background:green;color:white" @endif>{{ $datas->name }} ({{$datas->city}}) </option>
     @endforeach 
 
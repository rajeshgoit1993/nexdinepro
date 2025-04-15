<input type="hidden" id="level" name="level" value="1">
  <div class="col-md-4">

  <label class="required">Layout</label>
<select class="form-control status" name="layouts" id="layouts">
<option value="">--Select--</option>
<option value="Yes"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->layouts!='' && $fanchise_pre_launch_data->layouts=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->layouts!='' && $fanchise_pre_launch_data->layouts=='No') selected  @endif>No</option>
</select>

<span id="error_layouts" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->layouts!='' && $fanchise_pre_launch_data->layouts=='Yes') style='display:block'  @endif>
<label>Layout Design</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','layouts_design']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach

<input type="file" name="layouts_design[]" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->layouts!='' && $fanchise_pre_launch_data->layouts=='Yes')  @else id="layouts_design" @endif class="form-control" multiple>
<span id="error_layouts_design" class="text-danger"></span>
</div>


</div>
    
<!---->
<div class="col-md-4">

  <label class="required">Interior 2D/3D</label>
<select class="form-control status" name="interior" id="interior">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->interior!='' && $fanchise_pre_launch_data->interior=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->interior!='' && $fanchise_pre_launch_data->interior=='No') selected  @endif>No</option>
</select>
<span id="error_interior" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->interior!='' && $fanchise_pre_launch_data->interior=='Yes') style='display:block'  @endif>
<label>Interior 2D/3D Design</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','interior_design']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="interior_design[]" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->interior!='' && $fanchise_pre_launch_data->interior=='Yes') @else id="interior_design" @endif  class="form-control" multiple>
<span id="error_interior_design" class="text-danger"></span>
</div>


</div>
<!---->
  <div class="col-md-4">

  <label class="required">Wall Designs</label>
<select class="form-control status" name="wall_design" id="wall_design">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->wall_design!='' && $fanchise_pre_launch_data->wall_design=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->wall_design!='' && $fanchise_pre_launch_data->wall_design=='No') selected  @endif>No</option>
</select>
<span id="error_wall_design" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->wall_design!='' && $fanchise_pre_launch_data->wall_design=='Yes') style='display:block'  @endif>
<label>Wall Designs Layout</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','wall_design_layouts']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach
<input type="file" name="wall_design_layouts[]"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->wall_design!='' && $fanchise_pre_launch_data->wall_design=='Yes')  @else id="wall_design_layouts" @endif class="form-control" multiple>
<span id="error_wall_design_layouts" class="text-danger"></span>
</div>


</div>
<!---->
 <div class="col-md-4">

  <label class="required">Coming Soon Banner Installation</label>
<select class="form-control status" name="coming_soon_banner_installation" id="coming_soon_banner_installation">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->coming_soon_banner_installation!='' && $fanchise_pre_launch_data->coming_soon_banner_installation=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->coming_soon_banner_installation!='' && $fanchise_pre_launch_data->coming_soon_banner_installation=='No') selected  @endif>No</option>
</select>
<span id="error_coming_soon_banner_installation" class="text-danger"></span>

</div>
<!---->
<div class="col-md-4">

  <label class="required">Furnitures</label>
<select class="form-control status" name="furnitures" id="furnitures">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->furnitures!='' && $fanchise_pre_launch_data->furnitures=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->furnitures!='' && $fanchise_pre_launch_data->furnitures=='No') selected  @endif>No</option>
</select>
<span id="error_furnitures" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 
<div class="col-md-4">

  <label class="required">False ceiling work</label>
<select class="form-control status" name="false_ceiling_work" id="false_ceiling_work">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->false_ceiling_work!='' && $fanchise_pre_launch_data->false_ceiling_work=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->false_ceiling_work!='' && $fanchise_pre_launch_data->false_ceiling_work=='No') selected  @endif>No</option>
</select>
<span id="error_false_ceiling_work" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Electricity</label>
<select class="form-control status" name="electricity" id="electricity">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->electricity!='' && $fanchise_pre_launch_data->electricity=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->electricity!='' && $fanchise_pre_launch_data->electricity=='No') selected  @endif>No</option>
</select>
<span id="error_electricity" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Water drainage and Sink</label>
<select class="form-control status" name="water_drainage" id="water_drainage">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->water_drainage!='' && $fanchise_pre_launch_data->water_drainage=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->water_drainage!='' && $fanchise_pre_launch_data->water_drainage=='No') selected  @endif>No</option>
</select>
<span id="error_water_drainage" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">AC</label>
<select class="form-control status" name="ac" id="ac">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->ac!='' && $fanchise_pre_launch_data->ac=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->ac!='' && $fanchise_pre_launch_data->ac=='No') selected  @endif>No</option>
</select>
<span id="error_ac" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 
 <div class="col-md-4">

  <label class="required">Music System</label>
<select class="form-control status" name="music_system" id="music_system">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->music_system!='' && $fanchise_pre_launch_data->music_system=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->music_system!='' && $fanchise_pre_launch_data->music_system=='No') selected  @endif>No</option>
</select>
<span id="error_music_system" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 
<div class="col-md-4">

  <label class="required">Wifi</label>
<select class="form-control status" name="wifi" id="wifi">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->wifi!='' && $fanchise_pre_launch_data->wifi=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->wifi!='' && $fanchise_pre_launch_data->wifi=='No') selected  @endif>No</option>
</select>
<span id="error_wifi" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">CCTV</label>
<select class="form-control status" name="cctv" id="cctv">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->cctv!='' && $fanchise_pre_launch_data->cctv=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->cctv!='' && $fanchise_pre_launch_data->cctv=='No') selected  @endif>No</option>
</select>
<span id="error_cctv" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Gas Bank </label>
<select class="form-control status" name="gas_bank" id="gas_bank">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->gas_bank!='' && $fanchise_pre_launch_data->gas_bank=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->gas_bank!='' && $fanchise_pre_launch_data->gas_bank=='No') selected  @endif>No</option>
</select>
<span id="error_gas_bank" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->  
 <div class="col-md-4">

  <label class="required">Kitchen Equipment Instalation</label>
<select class="form-control status" name="kitchen" id="kitchen">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->kitchen!='' && $fanchise_pre_launch_data->kitchen=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->kitchen!='' && $fanchise_pre_launch_data->kitchen=='No') selected  @endif>No</option>
</select>
<span id="error_kitchen" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 
<div class="col-md-4">

  <label class="required">Menu Display board</label>
<select class="form-control status" name="menu_display" id="menu_display">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->menu_display!='' && $fanchise_pre_launch_data->menu_display=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->menu_display!='' && $fanchise_pre_launch_data->menu_display=='No') selected  @endif>No</option>
</select>
<span id="error_menu_display" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Coke/Pepsi Visi cooler</label>
<select class="form-control status" name="coke_cooler" id="coke_cooler">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->coke_cooler!='' && $fanchise_pre_launch_data->coke_cooler=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->coke_cooler!='' && $fanchise_pre_launch_data->coke_cooler=='No') selected  @endif>No</option>
</select>
<span id="error_coke_cooler" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!----> 
<div class="col-md-4">

  <label class="required">Fire extinguisher</label>
<select class="form-control status" name="fire_extinguisher" id="fire_extinguisher">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->fire_extinguisher!='' && $fanchise_pre_launch_data->fire_extinguisher=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->fire_extinguisher!='' && $fanchise_pre_launch_data->fire_extinguisher=='No') selected  @endif>No</option>
</select>
<span id="error_fire_extinguisher" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
<div class="col-md-4">

  <label class="required">Signage Board</label>
<select class="form-control status" name="signage_board" id="signage_board">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->signage_board!='' && $fanchise_pre_launch_data->signage_board=='Yes') selected  @endif>Yes</option>
<option value="No"  @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->signage_board!='' && $fanchise_pre_launch_data->signage_board=='No') selected  @endif>No</option>
</select>
<span id="error_signage_board" class="text-danger"></span>
<div class="status_remarks" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->signage_board!='' && $fanchise_pre_launch_data->signage_board=='Yes') style='display:block'  @endif>
<label>Signage Board Attachment</label>
<?php 
$docs=DB::table('pre_launch_docs')->where([['fanchise_id','=',$fanchise_detail->id],['doc_name','=','signage_board_design']])->get();
$a=1;
?>

@foreach($docs as $doc)
<a href="{{url('public/uploads/fanchise_doc/'.$doc->doc)}}"  target="_blank" style="color: blue;">View{{$a++}}</a>
@endforeach

<input type="file" name="signage_board_design[]" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->signage_board!='' && $fanchise_pre_launch_data->signage_board=='Yes') @else id="signage_board_design"
  @endif   class="form-control" multiple>
<span id="error_signage_board_design" class="text-danger"></span>
</div>



</div>
<!---->
<div class="col-md-4">

  <label class="required">Certificate display</label>
<select class="form-control status" name="certificate_display" id="certificate_display">
<option value="">--Select--</option>
<option value="Yes" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->certificate_display!='' && $fanchise_pre_launch_data->certificate_display=='Yes') selected  @endif>Yes</option>
<option value="No" @if($fanchise_pre_launch_data!='' && $fanchise_pre_launch_data->certificate_display!='' && $fanchise_pre_launch_data->certificate_display=='No') selected  @endif>No</option>
</select>
<span id="error_certificate_display" class="text-danger"></span>
<div class="status_remarks">

</div>


</div>
<!---->
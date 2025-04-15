 <input type="hidden" name="franchise_id" value="{{CustomHelpers::custom_encrypt($fanchise_detail->id)}}">
 <div class="col-md-12">
  <label>Add Fund Amount (Min: Rs. {{$fanchise_detail->subscription_value}})</label>
  <input type="number" required  class="form-control" name="subscription_value" min="{{$fanchise_detail->subscription_value}}">
  </div>
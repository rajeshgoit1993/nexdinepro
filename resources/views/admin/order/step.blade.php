<style type="text/css">
   .custom_progress {
  height: 100%;
  position: relative;
  z-index: 1;
  /*Image only BG fallback*/
  
  /*background = gradient + image pattern combo*/
  background: 
    linear-gradient();
}


/*form styles*/
#msform {
  width: 100%;
 /* margin: 50px auto;*/
  text-align: center;
  position: relative;
}

/*Hide all except first fieldset*/




/*progressbar*/
#progressbar_custom {
  margin-top: 30px;
  overflow: hidden;
  /*CSS counters to number the steps*/
  counter-reset: step;
}
#progressbar_custom li {
  list-style-type: none;
  color: black;
  text-transform: uppercase;
  font-size: 14px;
  width: 20%;
  float: left;
  position: relative;
}
#progressbar_custom li:before {
  content: counter(step);
  counter-increment: step;
  width: 20px;
  line-height: 20px;
  display: block;
  font-size: 10px;
  color: #333;
  background: #F45B69;
  border-radius: 3px;
  margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar_custom li:after {
  content: '';
  width: 100%;
  height: 2px;
  background: #f9dfe2;
  position: absolute;
  left: -50%;
  top: 9px;
  z-index: -1; /*put it behind the numbers*/
}
#progressbar_custom li:first-child:after {
  /*connector not needed before the first step*/
  content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar_custom li.active_second:before,  #progressbar_custom li.active_second:after{
  background: #27AE60;
  color: white;
}



</style>
  <!-- progressbar -->
 <div class="custom_progress">
  <form id="msform">
  <!-- progressbar -->
  <ul id="progressbar_custom">
    
    @if($data->status==0)
    <li class="active_second">Order Placed</li>
    <li>Payment Confirmed</li>
    <li>Order Confirmed</li>
    <li>Dispatch</li>
    <li>Delivered</li>
    @elseif($data->status==1 && ($orders->status==1 || $orders->status==3 || $orders->status==5))
    <li class="active_second">Order Placed</li>
    <li class="active_second">Payment Confirmed</li>
    <li class="active_second">Order Confirmed</li>
    <li>Dispatch</li>
    <li>Delivered</li>
    @elseif($data->status==1 && ($orders->status==2 || $orders->status==4 || $orders->status==6))
 <li class="active_second">Order Placed</li>
 <li class="active_second">Payment Confirmed</li>
    <li class="active_second">Order Confirmed</li>
    <li class="active_second">Dispatch</li>
    <li>Delivered</li>


     @elseif(($data->status==1 || $data->status==2) && $orders->status==7)
    <li class="active_second">Order Placed</li>
    <li class="active_second">Payment Confirmed</li>
    <li class="active_second">Order Confirmed</li>
    <li class="active_second">Dispatch</li>
    <li class="active_second">Delivered</li>
    @endif
   
   
   
  
  </ul>
  <!-- fieldsets -->
</form>
</div>
  <!-- fieldsets -->
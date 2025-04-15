@extends("layouts.frontend.master")
@section("maincontent")

<!--Header Ends================================================ -->
<section id="carouselSection" style="text-align:center">
<div id="myCarousel" class="carousel slide">
<div class="carousel-inner">
<div  style="text-align:center"  class="item active">
<div class="wrapper"><img src="{{url('resources/assets/front')}}/themes/images/carousel/restaurant.jpg" alt="Restaurant Management Software">
<div class="carousel-caption">
<h2>Restaurant Management</h2>
<p>A complete Point-Of-Sale software solution for your restaurant. We provide comprehensive set of features that suffices all your day-to-day requirements.</p>
<a href="{{route('pos_front')}}" class="btn btn-small btn-success">Read more</a>
</div>
</div>
</div>
<!-- <div  style="text-align:center"  class="item">
<div class="wrapper"><img src="{{url('resources/assets/front')}}/themes/images/carousel/foodCourt.jpg" alt="Food Court Software">
<div class="carousel-caption">
<h2>Food Court Management</h2>
<p>A complete software solution for the food-court. It comprises of Billing Module and Cashier Module. </p>
<a href="#" class="btn btn-small btn-success">Read more</a>
</div>
</div>
</div> -->
<div  style="text-align:center"  class="item">
<div class="wrapper"><img src="{{url('resources/assets/front')}}/themes/images/carousel/business_website_templates_3.jpg" alt="Restaurant Inventory Software">
<div class="carousel-caption">
<h2>Material Management</h2>
<p>A complete Material-Management-System software solution to track what goes in and what goes out of your restaurant. </p>
<a href="{{route('mms')}}" class="btn btn-small btn-success">Read more</a>
</div>
</div>
</div>
<!-- <div  style="text-align:center"  class="item">
<div class="wrapper"><img src="{{url('resources/assets/front')}}/themes/images/carousel/kitchen_base.jpg" alt="Base Kitchen Software">
<div class="carousel-caption">
<h2>Base Kitchen</h2>
<p>Covers all the operations in the Base Kitchen. From Kitchen Production to Issues & Adjustment, it takes care of specific requirements of your kitchen. </p>
<a href="#" class="btn btn-small btn-success">Read more</a>
</div>
</div>
</div> -->
<div  style="text-align:center"  class="item">
<div class="wrapper"><img src="{{url('resources/assets/front')}}/themes/images/carousel/demo.jpg" alt="For Demo, contact us">
<div class="carousel-caption">
<h2>Fix a Demo</h2>
<p>Give us an opportunity to showcase our strengths in form of a live-demo.</p>
<a href="{{route('contact')}}" class="btn btn-small btn-success">Contact us</a>
</div>
</div>
</div>
</div>
<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>
</section>

<!--POS Features-->
<section id="pos_features">
<div class="container">
<div class="row">
<div class="span6">
<div class="features_image">
<img src="{{url('resources/assets/front')}}/themes\images\pos_features\pos_features.webp">
</div>
</div>
<div class="span6">
<div class="">
<h2 color="#7D0552"><b>POS Features</b></h2>
<p>Our cloud-based POS software powers 16,000+ restaurants in 100+ countries and comes equipped with all of the features you need to streamline operations, increase sales and save time and money.<br/></p>
</div>

</div>
</div>
<div class="row">
<div class="span6">
<div class="feature_text">
<div class="icon_header">
<div class="svg_icon">
<svg xmlns="http://www.w3.org/2000/svg" id="Line" viewBox="0 0 24 24"><path d="M6.92,22.5a.47.47,0,0,1-.3-.1L3.71,20.27a.49.49,0,0,1-.21-.4V2A.5.5,0,0,1,4,1.5H20a.5.5,0,0,1,.5.5V19.72a.5.5,0,0,1-.17.38l-2.59,2.28a.52.52,0,0,1-.67,0L15,20.47l-2.28,1.91a.5.5,0,0,1-.64,0l-2.38-2-2.43,2A.51.51,0,0,1,6.92,22.5ZM4.5,19.61l2.4,1.76,2.45-2a.5.5,0,0,1,.63,0l2.37,2,2.31-1.93a.5.5,0,0,1,.65,0l2.1,1.9L19.5,19.5V2.5H4.5Z"></path><path d="M16,8.88H8.12a.51.51,0,0,1-.5-.5.5.5,0,0,1,.5-.5H16a.5.5,0,0,1,.5.5A.5.5,0,0,1,16,8.88Z"></path><path d="M16,13.94H8.12a.5.5,0,0,1,0-1H16a.5.5,0,0,1,0,1Z"></path></svg>
</div>
<div class="icon_header_text">
Easy Bill Splitting
</div>

</div>
<div class="icon_text">
<p>Help your servers instantly split bills between customers, evenly or by item – all with a simple swipe.</p>
</div>	
</div>


</div>
<!---->
<div class="span6">
<div class="feature_text">
<div class="icon_header">
<div class="svg_icon">
<svg xmlns="http://www.w3.org/2000/svg" id="Line" viewBox="0 0 24 24"><path d="M10.86,22.5a9.36,9.36,0,0,1,0-18.72.5.5,0,0,1,.5.5v8.36h8.36a.5.5,0,0,1,.5.5A9.37,9.37,0,0,1,10.86,22.5Zm-.5-17.71a8.36,8.36,0,1,0,8.85,8.85H10.86a.51.51,0,0,1-.5-.5Z"></path><path d="M22,10.37H14.13a.5.5,0,0,1-.5-.5V2a.5.5,0,0,1,.5-.5A8.38,8.38,0,0,1,22.5,9.87.5.5,0,0,1,22,10.37Zm-7.37-1h6.85a7.36,7.36,0,0,0-6.85-6.85Z"></path></svg>
</div>
<div class="icon_header_text">
Reporting & Analytics
</div>

</div>
<div class="icon_text">
<p>Make informed business decisions faster with more than 50 reports that provide deep insights into sales trends, staff performance, and much more.</p>
</div>	
</div>


</div>
<!---->
<div class="span6">
<div class="feature_text">
<div class="icon_header">
<div class="svg_icon">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Line" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve"><style type="text/css">	.st0{fill:#00A3AD;}</style><g>	<path class="st0" d="M20.3,3.5c-2.8,0-5.5,0-8.3,0c-2.8,0-5.7,0-8.5,0c-2,0-2.9,0.9-2.9,2.9c0,3.8,0,7.6,0,11.3  c0,1.8,0.9,2.7,2.6,2.7c5.8,0,11.6,0,17.4,0c1.8,0,2.7-0.9,2.7-2.8c0-3.7,0-7.4,0-11.1C23.4,4.4,22.5,3.5,20.3,3.5z M22.4,17.4  c0,1.7-0.4,2.1-2.1,2.1c-2.8,0-5.5,0-8.3,0c-2.7,0-5.4,0-8.1,0c-1.8,0-2.2-0.4-2.2-2.2c0-3.5,0-7.1,0-10.6c0-1.8,0.4-2.2,2.2-2.2  c5.5,0,10.9,0,16.4,0c1.7,0,2.1,0.4,2.1,2.1C22.4,10.2,22.4,13.8,22.4,17.4z"></path>	<path class="st0" d="M16.4,9.5c-1,0-2,0-3.1,0c-0.3,0-0.7-0.1-0.7-0.5c0-0.4,0.3-0.4,0.6-0.4c2.1,0,4.2,0,6.3,0  c0.3,0,0.7,0,0.7,0.5c0,0.4-0.4,0.5-0.7,0.5C18.5,9.5,17.4,9.5,16.4,9.5z"></path>	<path class="st0" d="M16.3,12.5c-1,0-2,0-2.9,0c-0.3,0-0.7,0-0.7-0.5c0-0.4,0.3-0.5,0.7-0.5c2.1,0,4.2,0,6.3,0  c0.3,0,0.7,0.1,0.7,0.5c0,0.4-0.4,0.5-0.7,0.5C18.5,12.5,17.4,12.5,16.3,12.5z"></path>	<path class="st0" d="M16.4,14.5c1.1,0,2.1,0,3.2,0c0.3,0,0.6,0.1,0.7,0.4c0,0.4-0.3,0.5-0.7,0.5c-2.1,0-4.2,0-6.3,0  c-0.3,0-0.7,0-0.7-0.5c0-0.4,0.4-0.5,0.7-0.5C14.4,14.5,15.4,14.5,16.4,14.5z"></path>	<path class="st0" d="M7,8c-2.2,0-3.9,1.8-3.9,4c0,2.2,1.8,4,4,4c2.2,0,3.9-1.9,3.9-4C11,9.8,9.2,8,7,8z M7,15c-1.6,0-3-1.4-2.9-3.1  c0-1.6,1.4-2.9,3-2.9c1.6,0,3,1.4,2.9,3.1C10,13.7,8.6,15,7,15z"></path></g></svg>
</div>
<div class="icon_header_text">
Payments
</div>

</div>
<div class="icon_text">
<p>Accept payments quickly, easily, and securely with a fully integrated payment processing solution.</p>
</div>	
</div>


</div>
<!---->
<div class="span6">
<div class="feature_text">
<div class="icon_header">
<div class="svg_icon">
<svg xmlns="http://www.w3.org/2000/svg" id="Line" viewBox="0 0 24 24"><path d="M14,22.5H10a.5.5,0,0,1-.5-.5V20a7.62,7.62,0,0,1-1.39-.56L6.7,20.84a.53.53,0,0,1-.36.15h0A.51.51,0,0,1,6,20.84L3.16,18a.51.51,0,0,1,0-.71l1.38-1.37a8.59,8.59,0,0,1-.62-1.43H2a.5.5,0,0,1-.5-.5V10A.5.5,0,0,1,2,9.5H3.84A9.1,9.1,0,0,1,4.45,8L3.16,6.7a.51.51,0,0,1,0-.71L6,3.16a.51.51,0,0,1,.71,0L7.94,4.41A8.9,8.9,0,0,1,9.5,3.75V2a.5.5,0,0,1,.5-.5h4a.5.5,0,0,1,.5.5V3.75a8.9,8.9,0,0,1,1.56.66L17.3,3.16a.51.51,0,0,1,.71,0L20.84,6a.51.51,0,0,1,0,.71L19.55,8a8.77,8.77,0,0,1,.61,1.52H22a.5.5,0,0,1,.5.5v4a.5.5,0,0,1-.5.5H20.08a9.51,9.51,0,0,1-.62,1.43l1.38,1.37a.53.53,0,0,1,.15.36.51.51,0,0,1-.15.35L18,20.84a.51.51,0,0,1-.71,0l-1.41-1.42A7.62,7.62,0,0,1,14.5,20v2A.5.5,0,0,1,14,22.5Zm-3.5-1h3V19.61a.5.5,0,0,1,.38-.49,7.48,7.48,0,0,0,1.85-.75.5.5,0,0,1,.6.08l1.33,1.33,2.12-2.12-1.3-1.3a.5.5,0,0,1-.07-.61,7.63,7.63,0,0,0,.81-1.88.5.5,0,0,1,.48-.37h1.8v-3H19.77a.49.49,0,0,1-.48-.38,7.59,7.59,0,0,0-.79-2,.5.5,0,0,1,.08-.6l1.2-1.2L17.66,4.22,16.49,5.39a.5.5,0,0,1-.61.07,7.67,7.67,0,0,0-2-.85.48.48,0,0,1-.38-.48V2.5h-3V4.13a.48.48,0,0,1-.38.48,7.82,7.82,0,0,0-2,.85.5.5,0,0,1-.61-.07L6.34,4.22,4.22,6.34l1.2,1.2a.5.5,0,0,1,.08.6,7.59,7.59,0,0,0-.79,2,.49.49,0,0,1-.48.38H2.5v3H4.3a.5.5,0,0,1,.48.37,7.27,7.27,0,0,0,.81,1.88.5.5,0,0,1-.07.61l-1.3,1.3,2.12,2.12,1.33-1.33a.5.5,0,0,1,.6-.08,7.48,7.48,0,0,0,1.85.75.5.5,0,0,1,.38.49ZM12,16.1A4.1,4.1,0,1,1,16.1,12,4.11,4.11,0,0,1,12,16.1Zm0-7.2A3.1,3.1,0,1,0,15.1,12,3.1,3.1,0,0,0,12,8.9Z"></path></svg>
</div>
<div class="icon_header_text">
POS Integrations
</div>

</div>
<div class="icon_text">
<p>Our restaurant POS software integrates with best-in-class technology solutions, making it a truly all-in-one platform for powering your business.</p>
</div>	
</div>


</div>
<!---->
<div class="span6">
<div class="feature_text">
<div class="icon_header">
<div class="svg_icon">
<svg xmlns="http://www.w3.org/2000/svg" id="Line" viewBox="0 0 24 24"><path d="M9.07,14.33H9a5,5,0,0,1,.13-10,5,5,0,0,1-.07,10Zm0-9a4,4,0,0,0-4,4A4,4,0,0,0,9,13.33h.05a4,4,0,0,0,4-4A4,4,0,0,0,9.13,5.3Z"></path><path d="M16.66,11a.51.51,0,0,1-.45-.29.49.49,0,0,1,.24-.66,4,4,0,0,0,1.14-6.43,4,4,0,0,0-2.81-1.21h-.06a4,4,0,0,0-2.61,1,.5.5,0,1,1-.66-.75,4.78,4.78,0,0,1,3.34-1.22,5,5,0,0,1,4.93,5.08A5,5,0,0,1,16.88,11,.54.54,0,0,1,16.66,11Z"></path><path d="M9.25,22.41c-.88,0-5.44-.11-7.15-2.28a2.77,2.77,0,0,1-.49-2.53,7.36,7.36,0,0,1,4.51-5.15.5.5,0,1,1,.31,1,6.35,6.35,0,0,0-3.85,4.45,1.77,1.77,0,0,0,.31,1.66c1,1.34,4.11,1.93,6.45,1.9h0a.5.5,0,1,1,0,1Z"></path><path d="M9.22,22.41H9.06a.5.5,0,1,1,0-1h.16c2.32,0,5.21-.58,6.23-1.88a1.84,1.84,0,0,0,.31-1.68,6.35,6.35,0,0,0-3.85-4.45.5.5,0,0,1,.31-1,7.38,7.38,0,0,1,4.51,5.15,2.81,2.81,0,0,1-.49,2.54C14.92,21.82,11.67,22.41,9.22,22.41Z"></path><path d="M19.67,19.31a.5.5,0,0,1-.11-1,2.44,2.44,0,0,0,1.62-1.08,2.68,2.68,0,0,0,.19-2.13,6.38,6.38,0,0,0-4.28-4.33.5.5,0,0,1-.36-.61.51.51,0,0,1,.61-.36,7.36,7.36,0,0,1,5,5,3.68,3.68,0,0,1-.3,2.91,3.47,3.47,0,0,1-2.27,1.54Z"></path></svg>
</div>
<div class="icon_header_text">
Staff Management
</div>

</div>
<div class="icon_text">
<p>Save time, track employee activity, and optimize labor costs with built-in staff management software designed just for restaurants.</p>
</div>	
</div>


</div>
<!---->
<div class="span6">
<div class="feature_text">
<div class="icon_header">
<div class="svg_icon">
<svg xmlns="http://www.w3.org/2000/svg" id="Line" viewBox="0 0 24 24"><path d="M22,22.5H2a.5.5,0,0,1-.5-.5V2A.5.5,0,0,1,2,1.5H22a.5.5,0,0,1,.5.5V22A.5.5,0,0,1,22,22.5Zm-19.5-1h19V2.5H2.5Z"></path><path d="M12.31,9.77H2a.5.5,0,0,1-.5-.5.5.5,0,0,1,.5-.5H12.31a.5.5,0,0,1,.5.5A.5.5,0,0,1,12.31,9.77Z"></path><path d="M21.56,13.22H18.75a.5.5,0,0,1-.5-.5.5.5,0,0,1,.5-.5h2.81a.5.5,0,0,1,.5.5A.5.5,0,0,1,21.56,13.22Z"></path><path d="M12.31,22.45a.51.51,0,0,1-.5-.5v-4a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v4A.5.5,0,0,1,12.31,22.45Z"></path><path d="M12.31,13.22a.5.5,0,0,1-.5-.5V5.82a.51.51,0,0,1,.5-.5.5.5,0,0,1,.5.5v6.9A.5.5,0,0,1,12.31,13.22Z"></path></svg>
</div>
<div class="icon_header_text">
Custom Floor Plans
</div>

</div>
<div class="icon_text">
<p>Customize and edit your floor plan by looking at critical factors like distance between tables, time seated, and spend per table.</p>
</div>	
</div>


</div>
<!---->
<div class="span6">
<div class="feature_text">
<div class="icon_header">
<div class="svg_icon">
<svg xmlns="http://www.w3.org/2000/svg" id="Line" viewBox="0 0 24 24"><path d="M18.3,11.55c-2.2,0-4-2.25-4-5s1.8-5,4-5,4,2.26,4,5S20.51,11.55,18.3,11.55Zm0-9c-1.65,0-3,1.81-3,4s1.35,4,3,4,3-1.8,3-4S20,2.5,18.3,2.5Z"></path><path d="M18.3,22.5a.5.5,0,0,1-.5-.5V11.05a.51.51,0,0,1,.5-.5.5.5,0,0,1,.5.5V22A.5.5,0,0,1,18.3,22.5Z"></path><path d="M5.7,22.5a.5.5,0,0,1-.5-.5V2a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5V22A.5.5,0,0,1,5.7,22.5Z"></path><path d="M6.25,11.25H5.15A3.21,3.21,0,0,1,1.7,8.39V2a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5V8.39c0,1,1.12,1.86,2.45,1.86h1.1c1.33,0,2.45-.86,2.45-1.86V2a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5V8.39A3.21,3.21,0,0,1,6.25,11.25Z"></path></svg>
</div>
<div class="icon_header_text">
Menu Management
</div>

</div>
<div class="icon_text">
<p>Upsell with ease, manage on- and off-premise menus, and easily build and update menus from anywhere.</p>
</div>	
</div>


</div>
<!---->
<div class="span6">
<div class="feature_text">
<div class="icon_header">
<div class="svg_icon">
<svg xmlns="http://www.w3.org/2000/svg" id="Line" viewBox="0 0 24 24"><rect x="3.5" y="18.04" width="16.6" height="1"></rect><ellipse cx="12" cy="20.53" rx="0.74" ry="0.74"></ellipse><path d="M18.56,23H5.44A2.44,2.44,0,0,1,3,20.56V3.43A2.43,2.43,0,0,1,5.44,1H18.56A2.43,2.43,0,0,1,21,3.43V20.56A2.44,2.44,0,0,1,18.56,23ZM5.44,2A1.43,1.43,0,0,0,4,3.43V20.56A1.43,1.43,0,0,0,5.44,22H18.56A1.43,1.43,0,0,0,20,20.56V3.43A1.43,1.43,0,0,0,18.56,2Z"></path></svg>
</div>
<div class="icon_header_text">
Tableside Ordering
</div>

</div>
<div class="icon_text">
<p>Take orders, upsell, and split bills right at the table with a mobile POS that moves with you.”</p>
</div>	
</div>


</div>
<!---->




</div>
</div>
</section>
<!-- POS Features second section ======================================== -->
<section id="pos_features_second">
<div class="container">
<div class="row">
<div class="span12">
<div class="well-medium" style="text-align:center;padding: 20px 0px;">
<h2 color="#7D0552"><b>POS Features</b></h2>
<p>Our cloud-based POS software powers 16,000+ restaurants in 100+ countries and comes equipped with all of the features you need to streamline operations, increase sales and save time and money.<br/></p>
</div>
</div>
</div>
</div>
</section>
<!-- -->
<section class="pos_features_text">
<div class="container">

<div class="row">
<div class="span6">
<div class="flex_image">
<img src="{{url('resources/assets/front')}}/themes\images\pos_features\easy-bill-splitting.webp">
</div>

</div>
<div class="span6">
<div class="flex_text">
<h2>Easy Bill Splitting</h2>
<p>Help your servers instantly split bills between customers, evenly or by item – all with a simple swipe.</p>
<a href="#">BOOK A DEMO ></a>
</div>
</div>


</div>

</div>
</section>

<!-- -->

<section class="pos_features_text">
<div class="container">

<div class="row">

<div class="span6">
<div class="flex_text">
<h2>Reporting & Analytics</h2>
<p>Make informed business decisions faster with more than 50 reports that provide deep insights into sales trends, staff performance, and much more.</p>
<a href="#">BOOK A DEMO ></a>
</div>
</div>

<div class="span6">
<div class="flex_image">
<img src="{{url('resources/assets/front')}}/themes\images\pos_features\reporting-analytics.webp">
</div>

</div>
</div>

</div>
</section>

<!-- -->

<section class="pos_features_text">
<div class="container">

<div class="row">
<div class="span6">
<div class="flex_image">
<img src="{{url('resources/assets/front')}}/themes\images\pos_features\custom-floor-plan-2.webp">
</div>

</div>
<div class="span6">
<div class="flex_text">
<h2>Custom Floor Plans</h2>
<p>Customize and edit your floor plan by looking at critical factors like distance between tables, time seated, and spend per table.</p>
<a href="#">BOOK A DEMO ></a>
</div>
</div>


</div>

</div>
</section>

<!-- -->

<section class="pos_features_text">
<div class="container">

<div class="row">

<div class="span6">
<div class="flex_text">
<h2>Menu Management</h2>
<p>Upsell with ease, manage on- and off-premise menus, and easily build and update menus from anywhere.</p>
<a href="#">BOOK A DEMO ></a>
</div>
</div>
<div class="span6">
<div class="flex_image">
<img src="{{url('resources/assets/front')}}/themes\images\pos_features\menu-management-4.webp">
</div>

</div>

</div>

</div>
</section>
@endsection


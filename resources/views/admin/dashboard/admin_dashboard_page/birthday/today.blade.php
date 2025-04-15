 <?php  
 use App\Models\User;
 use App\Models\KeyContacts;
?>
 <?php  
 $today_day_month = date('m-d');
$today_all=User::whereIn('registration_level',[1,2,3])->birthdayBetween($today_day_month, $today_day_month)->orderBy('birthday', 'asc')->get();

$today_franchise=User::whereIn('registration_level',[1,2])->birthdayBetween($today_day_month, $today_day_month)->orderBy('birthday', 'asc')->get();

$today_employees=User::whereIn('registration_level',[3])->birthdayBetween($today_day_month, $today_day_month)->orderBy('birthday', 'asc')->get();


     ?>
<div class="col-md-12">
  <div class="card card-info">
     <div class="card-header">
                <h3 class="card-title"><i class="fa fa-birthday-cake" aria-hidden="true"></i> Today Birthdays </h3>

               
        </div>

   <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#all_today">All</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#employees_today">Employees</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#franchise_today">Franchise</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="all_today" class="container tab-pane active" style="padding-top:5px">
        <table class="table table-bordered yajra-datatable" >
        <thead>
    <tr>
    
      <th>Name</th>
      <th>Type</th>
      <th>Date of birth</th>
      <th>Birthday</th>
     
    </tr>
  
  </thead>
   <tbody>
    @foreach($today_all as $data)

     <tr>
       <td>{{$data->name}}  <br> 
         {{$data->mobile}}
       </td>
       <td>
         @if($data->registration_level==1 || $data->registration_level==2)
         Franchise, {{$data->state}}, {{$data->dist}}, {{$data->city}}


         @else
         Employee, {{$data->state}}, {{$data->dist}}, {{$data->city}}
         @endif
       </td>
       <td>
        <?php
$date=date_create($data->birthday);
echo date_format($date,"d M Y");
     ?>
        

       </td>
        <td>
        <?php
$date=date_create($data->birthday);
echo date_format($date,"d M ");
     ?>
        

       </td>
     </tr>
    @endforeach
   
    </tbody>
    </table>


    </div>
    <div id="employees_today" class="container tab-pane fade" style="padding-top:5px"> 
     <table class="table table-bordered yajra-datatable" >
        <thead>
    <tr>
    
      <th>Name</th>
      <th>Type</th>
      <th>Date of birth</th>
      <th>Birthday</th>
     
    </tr>
  
  </thead>
   <tbody>
    @foreach($today_employees as $data)

     <tr>
       <td>{{$data->name}}  <br> 
         {{$data->mobile}}
       </td>
       <td>
         @if($data->registration_level==1 || $data->registration_level==2)
         Franchise, {{$data->state}}, {{$data->dist}}, {{$data->city}}


         @else
         Employee, {{$data->state}}, {{$data->dist}}, {{$data->city}}
         @endif
       </td>
       <td>
        <?php
$date=date_create($data->birthday);
echo date_format($date,"d M Y");
     ?>
        

       </td>
        <td>
        <?php
$date=date_create($data->birthday);
echo date_format($date,"d M ");
     ?>
        

       </td>
     </tr>
    @endforeach
   
    </tbody>
    </table>
    </div>
    <div id="franchise_today" class="container tab-pane fade" style="padding-top:5px">  
      <table class="table table-bordered yajra-datatable" >
        <thead>
    <tr>
    
      <th>Name</th>
      <th>Type</th>
      <th>Date of birth</th>
      <th>Birthday</th>
     
    </tr>
  
  </thead>
   <tbody>
    @foreach($today_franchise as $data)

     <tr>
       <td>{{$data->name}}  <br> 
         {{$data->mobile}}
       </td>
       <td>
         @if($data->registration_level==1 || $data->registration_level==2)
         Franchise, {{$data->state}}, {{$data->dist}}, {{$data->city}}


         @else
         Employee, {{$data->state}}, {{$data->dist}}, {{$data->city}}
         @endif
       </td>
       <td>
        <?php
$date=date_create($data->birthday);
echo date_format($date,"d M Y");
     ?>
        

       </td>
        <td>
        <?php
$date=date_create($data->birthday);
echo date_format($date,"d M ");
     ?>
        

       </td>
     </tr>
    @endforeach
   
    </tbody>
    </table>
    </div>
  </div>         
        </div>
        </div>
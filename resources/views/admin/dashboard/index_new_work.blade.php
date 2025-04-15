@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
     <section class="col-lg-12 connectedSortable">
  <div class="card direct-chat direct-chat-primary">

    @include("admin.dashboard.admin_dashboard_page.daily_cal")


    <!---->
    <?php 
     $id=Sentinel::getUser()->id;
      $role=DB::table('role_users')->where('user_id','=',$id)->first();
      $role_id=$role->role_id;
      $page_acess=DB::table('page_accesses')->where('role_id','=',$role_id)->first();

     $role_wise_array=['prelaunch_action'=>$page_acess->prelaunch_date,
                        'fanchise_status'=>$page_acess->fanchise_data,
                        'architect_status'=>$page_acess->architect,
                        'social_media_status'=>$page_acess->social,
                        'procurement_status'=>$page_acess->procurement,
                        'operations_status'=>$page_acess->operations,
                        'accounts_status'=>$page_acess->accounts,
                        ];
      $new_query[]=['status','=',6];     
        foreach($role_wise_array as $row=>$col):
           if($col==1):
            if($col=='procurement_status'):
 $new_query[]=[$row,'>=',1];
  $new_query[]=[$row,'<=',3];
            else:
    $new_query[]=[$row,'=',1];
            endif;
 
           endif;
        endforeach;
         $ongoing = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
            ->where($new_query)
            ->get();
        //
  $second_query[]=['status','=',6];     
        foreach($role_wise_array as $row=>$col):
           if($col==1):
            if($col=='procurement_status'):
 $second_query[]=[$row,'=',4];
 
            else:
    $second_query[]=[$row,'=',2];
            endif;
 
           endif;
        endforeach;
        //
      $completed = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
            ->where($second_query)
            ->get(); 
            
     ?>
<div class="row">
         <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{count($data)}}</h3>

                <p>Pending Pre-Launch Task</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('new_work_list')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
       
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{count($ongoing)}}</h3>

                <p>Ongoing Pre-Launch Task</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('ongoing_request')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
             <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{count($completed)}}</h3>

                <p>Completed Pre-Launch Task</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('ongoing_request')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
         
          <!-- ./col -->
        </div>

    <!---->
<div class="row">

  
<!---->
@include("admin.dashboard.admin_dashboard_page.birthday.today")
<!---->
@include("admin.dashboard.admin_dashboard_page.birthday.upcoming")
<!---->
</div>








<!-- /.content -->
</div>
</section>

</div>

</div>
</section>

</div>
@endsection
@section('custom_css')
<link href="{{asset('/resources/assets/fullcal/main.css')}}" rel='stylesheet' />




@endsection
@section('custom_js')

<script src="{{asset('/resources/assets/fullcal/main.js')}}"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var APP_URL=$("#APP_URL").val();
    var url=APP_URL+'/fullcalendar';
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialDate: new Date(),
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
      },
      height: 'auto',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      selectMirror: true,
      nowIndicator: true,
      events: url
    });

    calendar.render();
  });


//
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
       
       
       
    });
    
  });
</script>

@endsection
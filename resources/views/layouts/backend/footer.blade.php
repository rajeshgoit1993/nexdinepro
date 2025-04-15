
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} <a href="#">NexCen POS </a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
       <strong>Design & Develop By <a href="https://www.nexcenglobal.com/" target="_blank">NexCen Global INC</a>.</strong>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('/resources/assets/admin-lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/resources/assets/admin-lte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('/resources/assets/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('/resources/assets/admin-lte/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('/resources/assets/admin-lte/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('/resources/assets/admin-lte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('/resources/assets/admin-lte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('/resources/assets/admin-lte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('/resources/assets/admin-lte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/resources/assets/admin-lte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('/resources/assets/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- Summernote -->
<script src="{{asset('/resources/assets/admin-lte/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/resources/assets/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->

<script src="{{asset('/resources/assets/admin-lte/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/resources/assets/admin-lte/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('/resources/assets/admin-lte/dist/js/pages/dashboard.js')}}"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">


</script>
@yield("datatable")
@yield("custom_js")
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
});

  

</script>

<script>


$(document).on("click",".logout",function(){
 
    get_location()

})
  



        function get_location(){
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(success, error);

            }else{
                alert('Your browser is not supporting geolocation.')
            }

            function success(position) {
               
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                document.getElementById('accuracy').value = position.coords.accuracy;
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
              
                 $("#logout-form").submit();  
                var options = {
                    'zoom':10,
                    'center':{lat:position.coords.latitude,lng:position.coords.longitude},
                }

                var my_map = new google.maps.Map(document.getElementById('map'),options);

                var geocoder = new google.maps.Geocoder();

                
                
            }

            function error(error) {
                switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert('You must allow geolocation before login.');
                    location.reload();
                    break;

                case error.TIMEOUT:
                    // Handle timeout.
                    break;
            
                default:
                    break;
            }
            }
     
        }

       
    </script>
</body>
</html>

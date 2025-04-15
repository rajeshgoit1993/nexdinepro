@extends("layouts.backend.master")

@section('maincontent')
<style type="text/css">
  .set
  {
    display: none;
  }
  .user_name
  {
    cursor: pointer;
  }
   #video {
      /*  border: 1px solid black;*/
        width: 100%;
      /* margin-top: 100px;*/
    }

    #photo {
        border: 1px solid black;
        width: 100%;
       
    }

    #canvas {
        display: none;
    }

    .camera {
        width: 100%;
        display: inline-block;
    }

    .output {
        width: 100%;
        display: inline-block;
    }

    #startbutton {
        display: block;
        position: relative;
        margin-left: auto;
        margin-right: auto;
        bottom: 36px;
        padding: 5px;
        background-color: #6a67ce;
        border: 1px solid rgba(255, 255, 255, 0.7);
        font-size: 14px;
        color: rgba(255, 255, 255, 1.0);
        cursor: pointer;
    }

    .contentarea {
        font-size: 16px;
        font-family: Arial;
        text-align: center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">
<div class="row">
	<section class="col-lg-12 connectedSortable">
	<div class="card direct-chat direct-chat-primary">
		<div class="flex-container">
  <div class="flex-item-left"><h5>{{$header}} Take Snapshot</h5></div>

</div>

@if(Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ Session::get('success') }}
</div>
@endif
@if(Session::get('error'))
<div class="alert alert-danger" role="alert">
  {{ Session::get('error') }}
</div>
@endif
</div>
</section>
<section class="col-lg-12 connectedSortable">
<div class="card direct-chat direct-chat-primary">
<!-- /.content -->

<div class="row">


<div class="col-md-12">
      <div class="form-card">


<div class="mb-2">
 
{!! Form::open(["files"=>true,'route'=>'save_attendence_picture'])!!}
 <div class="row">
  <div class="col-md-6">
    <div class="camera">
            <video id="video" width="100%" height="100%">Video stream not available.</video>
        </div>
        <div>
            <button id="startbutton">Take photo</button></div>

   

  </div> 
  <div class="col-md-6">
      <div class="contentarea">
      
        
        <canvas id="canvas"></canvas>
        <div class="output">
            <img id="photo" alt="The screen capture will appear in this box." >
        </div>
        <input type="hidden" name="image" class="image-tag">
    </div>

  </div>
    <div class="col-md-12">
  <?php 
$check_optional_holidays=DB::table('choose_optional_holidays')->where([['user_id',Sentinel::getUser()->id],['year',date('Y')]])->first();
$holiday_s=DB::table('holidays')->where([['holiday_type',2],['year',date('Y')]])->get();


  ?>
@if($check_optional_holidays=='' && count($holiday_s)>0)
<div class="form-group">
<label for="" class="required">Select Any One Optional Holidays</label>
<select class="form-control" name="holiday_id" required="">   
 
 <option value="">Select Any One</option>
 @foreach($holiday_s as $holi_day)
 <option value="{{$holi_day->id}}">{{$holi_day->holiday}}</option>
 @endforeach



</select>
</div>
@endif
  </div>
 </div>
{!! Form::submit('Submit',["class"=>"btn btn-success"]) !!}


{!! Form::close() !!}
</div>
</div>
</div>
</div>


</div>
</section>

</div>

</div>
</section>

</div>
@endsection
@section('custom_js')

<script>
    /* JS comes here */
    (function() {

        var width = 320; // We will scale the photo width to this
        var height = 320; // This will be computed based on the input stream

        var streaming = false;

        var video = null;
        var canvas = null;
        var photo = null;
        var startbutton = null;

        function startup() {
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            photo = document.getElementById('photo');
            startbutton = document.getElementById('startbutton');

            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.log("An error occurred: " + err);
                });

            video.addEventListener('canplay', function(ev) {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    if (isNaN(height)) {
                        height = width / (4 / 3);
                    }

                    // video.setAttribute('width', 200);
                    // video.setAttribute('height', 200);
                    canvas.setAttribute('width', 200);
                    canvas.setAttribute('height', 200);
                    streaming = true;
                }
            }, false);

            startbutton.addEventListener('click', function(ev) {
                takepicture();
                ev.preventDefault();
            }, false);

            clearphoto();
        }


        function clearphoto() {
            var context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }

        function takepicture() {
            var context = canvas.getContext('2d');
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                var data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);

                $(".image-tag").val(data)
                $(".set").css("display","block")

            } else {
                clearphoto();
            }
        }

        window.addEventListener('load', startup, false);
    })();
    </script>

    @endsection
@component('mail::message')
Hello {{ $notifiable->first_name }} ,
<?php  
$data=DB::table('reminders')->where([['user_id','=',$notifiable->id],['completed','=',0]])->first();

?>
<p>Please Click the following link to reset your password <a href="{{url('/activate/'.$notifiable->email.'/'.$data->code)}}">Reset Password</a></p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
Hello {{ $notifiable->name }} ,

<p>Warmest welcome from NexCen POS Group and we are happy to have you onboard.</p>
<p>Please login by using the below link and credentials.</p>
<p>Link: <a href="{{url('/')}}">{{url('/')}}</a></p>
 <p>Login ID: <a href="#">{{ $notifiable->email  }}</a></p>
<p>Your Password is: NexBilling@1342
</p>



Best wishes,<br>
Skyland Group
@endcomponent

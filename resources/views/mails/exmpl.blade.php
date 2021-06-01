@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Thank you for register at Moonlight!

Click below to verify your email
@component('mail::button', ['url' => $link])
Verify
@endcomponent
Happy Shopping!

Best Regards,
Moonlight.
@endcomponent
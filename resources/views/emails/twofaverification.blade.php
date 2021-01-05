@component('mail::message')
# <h1 style="color:#2774AE">{{ $details['title'] }}</h1>

<p style="color: rgb(144,144,144)">{{ $details['body'] }}</p>
<p class="lead"> {{ $details['token'] }} </p>

<p style="color: rgb(144,144,144)">Thanks,</p>
<p style="color: rgb(144,144,144) ">{{ config('app.name') }}</p>
@endcomponent

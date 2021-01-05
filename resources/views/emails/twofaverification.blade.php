@component('mail::message')
# <h1 style="color:#2774AE">{{ $details['title'] }}</h1>

<p style="color: rgb(153, 148, 148)">{{ $details['body'] }}</p>
<p class="lead"> {{ $details['token'] }} </p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

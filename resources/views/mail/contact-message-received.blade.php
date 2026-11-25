<x-mail::message>
# New portfolio enquiry

**From:** {{ $contactMessage->name }} ({{ $contactMessage->email }})
@if($contactMessage->subject)

**Subject:** {{ $contactMessage->subject }}
@endif

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

<x-mail::button :url="$adminUrl">
View in admin
</x-mail::button>

Reply to this email to answer {{ $contactMessage->name }} directly.
</x-mail::message>

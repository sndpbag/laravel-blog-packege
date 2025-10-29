<x-mail::message>
# Verify Your Email Address

Hello,

Thank you for subscribing to our newsletter!  
Please click the button below to verify your email address and confirm your subscription.

<x-mail::button :url="$url">
Verify Email
</x-mail::button>

If you did not request this subscription, please ignore this email.

Thank you,<br>
{{ config('app.name') }}
</x-mail::message>

@component('mail::message')
# {{ config('app.name').' '.$invoice->client->clientType->name. ': Invoice '. $invoice->number_formatted }}

Dear {{ $invoice->client->name }},
@component('mail::panel')
<?php echo $text; ?>
@endcomponent
Regards,<br />
Tom

@endcomponent

@component('mail::message')
# {{ config('app.name').' '.$invoice->client->clientType->name. ': Invoice '. $invoice->number_formatted }}

Dear {{ $invoice->client->name }},

<?php echo $text; ?>
<br /><br />
Regards,<br />
Tom<br />

<em>Attached invoice sent from {{ config('app.name') }} invoice system.</em>

@endcomponent

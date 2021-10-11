<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            html,
            body {
                font-size: 16px;
            }

            html {
                font-family: "Helvetica", sans-serif;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            }

            h1 {
                margin-bottom: 0;
            }

            .font-small {
                font-size: 14px;
            }

            .green {
                color: #0c4128;
            }

            .bold {
                font-weight: bold;
            }

            .underline {
                text-decoration: underline;
            }

            .right {
                text-align: right;
            }

            .margin-correct {
                margin-top: -18px;
            }

            .margin-correct-48 {
                margin-top: -48px;
            }

            .margin-correct-70 {
                margin-top: -70px;
            }

            .margin-correct-100 {
                margin-top: -100px;
            }

            .padding-3 {
                padding: 3px 0;
            }

            .padding-5 {
                padding: 5px 0;
            }

            .padding-10 {
                padding: 10px 0;
            }

            .padding-20 {
                padding: 20px 0;
            }

            .border-bottom {
                border-bottom: 2px solid #18222b;
            }

            .border-bottom-light {
                border-bottom: 1px solid #18222b;
            }

            .item-text {
                max-width: 600px;
            }

            #invoice {
                width: 710px;
            }

            #header {
                text-align: right;
            }

            #top {
                margin-bottom: 30px;
            }

            #top #date {
                text-align: right;
            }

            #middle {
                margin-bottom: 10px;
                border-bottom: 2px solid #18222b;
            }

            #payments {
                color: red;
                border: 2px solid red;
                width: 250px;
                margin: 20px 0 0 180px;
                font-weight: bold;
                padding: 0 10px;
                background: #FFF;
                z-index: 10;
            }

            #payments h2 {
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div id="invoice">
            <div id="header" class="border-bottom-light green">
                <h1>INVOICE #{{ $invoice->number }}</h1>
            </div>
            <div id="top">
                <h2>{{ config('app.name') }} {{ $invoice->client->clientType->name }}</h2>
                <div id="date" class="margin-correct-48">
                    <span>DATE:</span>
                    <span>{{ date('d/m/Y', strtotime($invoice->date_sent)) }}</span>
                </div>
            </div>
            <div id="middle">
                <div id="customer" class="padding-10">
                    <div class="underline padding-3 green">Customer Details</div>
                    <div class="padding-3 font-small">
                        {{ $invoice->client->name }}
                    </div>
                    @if($invoice->business && $invoice->business->address)
                        <div class="padding-3 font-small">{{ $invoice->business->address->name }}</div>
                        <div class="padding-3 font-small">{{ $invoice->business->address->address_1 }}</div>
                        <div class="padding-3 font-small">{{ $invoice->business->address->address_2 }}</div>
                        <div class="padding-3 font-small">{{ $invoice->business->address->address_3 }}</div>
                        <div class="padding-3 font-small">{{ $invoice->business->address->postcode }}</div>
                    @elseif($invoice->client->address)
                        <div class="padding-3 font-small">{{ $invoice->client->address->name }}</div>
                        <div class="padding-3 font-small">{{ $invoice->client->address->address_1 }}</div>
                        <div class="padding-3 font-small">{{ $invoice->client->address->address_2 }}</div>
                        <div class="padding-3 font-small">{{ $invoice->client->address->address_3 }}</div>
                        <div class="padding-3 font-small">{{ $invoice->client->address->postcode }}</div>
                    @endif
                </div>
                <div id="business" class="padding-10 right margin-correct-100">
                    <div id="address">
                        <div class="underline padding-3 green">Details</div>
                        <div class="padding-3 font-small">{{ $settings->name }}</div>
                        @if($settings->address)
                            <div class="padding-3 font-small">{{ $settings->address->name }}</div>
                            <div class="padding-3 font-small">{{ $settings->address->address_1 }}</div>
                            <div class="padding-3 font-small">{{ $settings->address->address_2 }}</div>
                            <div class="padding-3 font-small">{{ $settings->address->address_3 }}</div>
                            <div class="padding-3 font-small">{{ $settings->address->postcode }}</div>
                        @endif
                        <div>{{ $settings->phone }}</div>
                    </div>
                    <div id="bank" class="right padding-10 font-small">
                        <div class="padding-3">
                            <span>Bank information:</span>
                            <span>Nationwide</span>
                        </div>
                        <div class="padding-3">
                            <span>Account number:</span>
                            <span>46215981</span>
                        </div>
                        <div class="padding-3">
                            <span>Sort code:</span>
                            <span>07-04-36</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="items">
                <div class="border-bottom-light">
                    <div class="bold green">DESCRIPTION</div>
                    <div class="bold right margin-correct green">AMOUNT</div>
                </div>
                @foreach($invoice->items as $item)
                    <div class="border-bottom-light padding-10 font-small">
                        <div class="item-text">{{ $item->description }}</div>
                        <div class="right margin-correct">{{ $item->price_formatted }}</div>
                    </div>
                @endforeach
                <div id="total" class="padding-10 bold border-bottom-light">
                    <div>TOTAL</div>
                    <div class="right margin-correct">{{ $invoice->total_formatted }}</div>
                </div>
            </div>
        </div>
        @if($withPayments)
            <div id="payments">
                <h2>PAID</h2>
                @foreach($invoice->payments as $payment)
                    <div class="font-small">
                        <div>{{ date('d/m/Y', strtotime( $payment->date_paid)) }}</div>
                        <div class="right margin-correct">{{ $payment->total_formatted }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </body>
</html>

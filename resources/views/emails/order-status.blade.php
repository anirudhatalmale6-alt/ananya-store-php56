@include('emails.partials.header')
@php
    $cur = config('store.currency');
    // Laravel 5.4 has no Str::of(); take the first word of the name directly.
    $parts = preg_split('/\s+/', trim($order->shipping_name));
    $firstName = isset($parts[0]) ? $parts[0] : $order->shipping_name;
@endphp

<h2 style="font-family:Georgia,serif;color:#FF0000;margin:0 0 14px;font-size:20px">{{ $forAdmin ? 'Order Status Updated' : 'Update on your order ' . $order->order_number }}</h2>

@if($forAdmin)
    <p style="font-size:14px;color:#333333;margin:0 0 8px">The status of order {{ $order->order_number }} has been changed.</p>
@else
    <p style="font-size:14px;color:#333333;margin:0 0 8px">Hi {{ $firstName }}, there's an update on your Ananya order.</p>
@endif

<div style="background:#ffffff;border:1px solid #e5e5e5;border-left:4px solid #FF0000;border-radius:10px;padding:16px;margin:14px 0">
    <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Order Number:</span> <strong style="color:#FF0000">{{ $order->order_number }}</strong></p>
    <p style="margin:8px 0;font-size:15px;color:#333333"><span style="color:#777777">Status:</span> <span style="text-decoration:line-through;color:#999999">{{ ucfirst($previousStatus) }}</span> &nbsp;&rarr;&nbsp; <strong style="color:#FF0000">{{ ucfirst($order->status) }}</strong></p>
    <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Date &amp; Time:</span> <strong style="color:#111111">{{ date('d M Y, h:i A') }}</strong></p>
    @if(!empty($note))
        <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Remarks:</span> <strong style="color:#111111">{{ $note }}</strong></p>
    @endif
</div>

<h3 style="font-family:Georgia,serif;color:#FF0000;font-size:16px;margin:16px 0 4px">Order Summary</h3>
<table style="width:100%;border-collapse:collapse;margin:8px 0 4px">
    @foreach($order->orderItems as $item)
        <tr>
            <td style="padding:6px 0;border-bottom:1px solid #eeeeee;color:#111111;font-size:14px">{{ $item->product_name }} <span style="color:#777777">&times; {{ $item->quantity }}</span></td>
            <td style="padding:6px 0;border-bottom:1px solid #eeeeee;text-align:right;color:#111111;font-size:14px;white-space:nowrap">{{ $cur }} {{ number_format($item->total, 2) }}</td>
        </tr>
    @endforeach
    <tr>
        <td style="padding-top:10px;text-align:right;color:#111111;font-weight:bold">Total</td>
        <td style="padding-top:10px;text-align:right;color:#FF0000;font-weight:bold;white-space:nowrap">{{ $cur }} {{ number_format($order->total, 2) }}</td>
    </tr>
</table>

@if(!$forAdmin)
    <p style="margin-top:18px;font-size:13px;color:#777777">Track your order anytime from your account dashboard.</p>
@endif

@include('emails.partials.footer')

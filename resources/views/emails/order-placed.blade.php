@include('emails.partials.header')
@php
    $cur = config('store.currency');
    // Laravel 5.4 has no Str::of(); take the first word of the name directly.
    $parts = preg_split('/\s+/', trim($order->shipping_name));
    $firstName = isset($parts[0]) ? $parts[0] : $order->shipping_name;

    // Human-readable payment label ("cod" would otherwise print as "Cod").
    $paymentLabels = array(
        'cod'      => 'Cash on Delivery',
        'card'     => 'Card',
        'bank'     => 'Bank Transfer',
        'transfer' => 'Bank Transfer',
    );
    $paymentKey = strtolower(trim($order->payment_method));
    $paymentLabel = isset($paymentLabels[$paymentKey])
        ? $paymentLabels[$paymentKey]
        : ($paymentKey === '' ? 'Cash on Delivery' : ucfirst($order->payment_method));
@endphp

<h2 style="font-family:Georgia,serif;color:#FF0000;margin:0 0 14px;font-size:20px">{{ $forAdmin ? 'New Order Received' : 'Your order is confirmed' }}</h2>

@if($forAdmin)
    <p style="font-size:14px;color:#333333;margin:0 0 8px">A new order has just been placed on the Ananya store.</p>
@else
    <p style="font-size:14px;color:#333333;margin:0 0 8px">Hi {{ $firstName }}, thank you for shopping with Ananya! We've received your order and it is now being processed.</p>
@endif

<div style="background:#ffffff;border:1px solid #e5e5e5;border-left:4px solid #FF0000;border-radius:10px;padding:16px;margin:14px 0">
    <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Order Number:</span> <strong style="color:#FF0000">{{ $order->order_number }}</strong></p>
    <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Customer:</span> <strong style="color:#111111">{{ $order->shipping_name }}</strong></p>
    <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Order Date:</span> <strong style="color:#111111">{{ $order->created_at->format('d M Y, h:i A') }}</strong></p>
    <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Payment:</span> <strong style="color:#111111">{{ $paymentLabel }}</strong></p>
    <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Current Status:</span> <strong style="color:#FF0000">{{ ucfirst($order->status) }}</strong></p>
    @if($forAdmin)
        <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Contact:</span> <strong style="color:#111111">{{ $order->shipping_email }} &middot; {{ $order->shipping_phone }}</strong></p>
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
        <td style="padding:6px 0;text-align:right;color:#777777;font-size:13px">Subtotal</td>
        <td style="padding:6px 0;text-align:right;color:#111111;font-size:13px;white-space:nowrap">{{ $cur }} {{ number_format($order->subtotal, 2) }}</td>
    </tr>
    <tr>
        <td style="padding:2px 0;text-align:right;color:#777777;font-size:13px">Shipping</td>
        <td style="padding:2px 0;text-align:right;color:#111111;font-size:13px;white-space:nowrap">{{ (float) $order->shipping_cost == 0.0 ? 'FREE' : $cur . ' ' . number_format($order->shipping_cost, 2) }}</td>
    </tr>
    <tr>
        <td style="padding-top:10px;text-align:right;color:#111111;font-weight:bold">Total</td>
        <td style="padding-top:10px;text-align:right;color:#FF0000;font-weight:bold;white-space:nowrap">{{ $cur }} {{ number_format($order->total, 2) }}</td>
    </tr>
</table>

<div style="margin-top:16px">
    <p style="margin:3px 0;font-size:14px;color:#333333"><span style="color:#777777">Shipping To:</span>
    <strong style="color:#111111">{{ collect(array($order->shipping_address, $order->shipping_city, $order->shipping_state, $order->shipping_zip))->filter()->implode(', ') }}</strong></p>
</div>

@if($forAdmin)
    <p style="margin-top:18px"><a href="{{ url('/admin/orders/' . $order->id) }}" style="background:#FF0000;color:#ffffff;text-decoration:none;padding:10px 18px;border-radius:8px;font-size:13px;display:inline-block">Manage Order</a></p>
@else
    <p style="margin-top:18px;font-size:13px;color:#777777">You can track your order anytime from your account dashboard. We'll email you as the status changes.</p>
@endif

@include('emails.partials.footer')

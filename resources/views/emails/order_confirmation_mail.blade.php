<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order!</h1>
    <p>Dear {{ $order->customer->name }},</p>
    <p>Your order <strong>#{{ $order->id }}</strong> has been successfully placed.</p>

    <h3>Order Details:</h3>
    <ul>
        <li><strong>Order ID:</strong> {{ $order->id }}</li>
        <li><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</li>
        <li><strong>Status:</strong> {{ $order->status }}</li>
    </ul>

    <h3>Products:</h3>
    <ul>
        @foreach($order->orderItems as $item)
            <li>{{ $item->product->name }} - {{ $item->quantity }} pcs - ₹{{ number_format($item->subtotal, 2) }}</li>
        @endforeach
    </ul>

    <p>We will notify you once your order is shipped. If you have any questions, feel free to contact us.</p>

    <p>Best Regards,<br> The {{ config('app.name') }} Team</p>
</body>
</html>

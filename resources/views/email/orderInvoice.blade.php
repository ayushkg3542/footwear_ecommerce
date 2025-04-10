<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0;">
  <div style="max-width: 700px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
    
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 30px;">
      <h2 style="margin: 0; color: #333;">Order Invoice</h2>
      <p style="margin: 5px 0;">Order ID: #{{ $order->id }}</p>
      <p style="margin: 5px 0;">Date: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
    </div>

    <!-- Customer Info -->
    <div style="margin-bottom: 30px;">
      <p><strong>Customer Name:</strong> {{ $order->name }}</p>
      <p><strong>Email:</strong> {{ $order->email }}</p>
      <p><strong>Phone:</strong> {{ $order->phone ?? '-' }}</p>
    </div>

    <!-- Table -->
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
      <thead>
        <tr>
          <th style="border: 1px solid #ddd; padding: 10px; background-color: #f0f0f0; text-align: left;">#</th>
          <th style="border: 1px solid #ddd; padding: 10px; background-color: #f0f0f0; text-align: left;">Product</th>
          <th style="border: 1px solid #ddd; padding: 10px; background-color: #f0f0f0; text-align: left;">Qty</th>
          <th style="border: 1px solid #ddd; padding: 10px; background-color: #f0f0f0; text-align: left;">Price</th>
          <th style="border: 1px solid #ddd; padding: 10px; background-color: #f0f0f0; text-align: left;">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @php $total = 0; @endphp
        @foreach($order->orderItems as $key => $item)
          @php
            $subtotal = $item->price * $item->quantity;
            $total += $subtotal;
          @endphp
          <tr>
            <td style="border: 1px solid #ddd; padding: 10px;">{{ $key + 1 }}</td>
            <td style="border: 1px solid #ddd; padding: 10px;">{{ $item->product->name }}</td>
            <td style="border: 1px solid #ddd; padding: 10px;">{{ $item->quantity }}</td>
            <td style="border: 1px solid #ddd; padding: 10px;">₹{{ number_format($item->price, 2) }}</td>
            <td style="border: 1px solid #ddd; padding: 10px;">₹{{ number_format($subtotal, 2) }}</td>
          </tr>
        @endforeach
        <tr>
          <td colspan="4" style="border: 1px solid #ddd; padding: 10px; text-align: right; background-color: #f9f9f9; font-weight: bold;">Total</td>
          <td style="border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9; font-weight: bold;">₹{{ number_format($total, 2) }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Footer -->
    <div style="text-align: right; margin-top: 20px; font-weight: bold;">
      Thank you for your purchase!
    </div>

  </div>
</body>
</html>

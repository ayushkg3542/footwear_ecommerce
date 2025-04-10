@foreach($orders as $order)
<tr>
    <td>
        <input class="form-check-input" type="checkbox">
    </td>
    <td>
        @if(isset($order->id))
        <a href="{{ route('order.details', ['order' => encrypt($order->id)]) }}">#{{ $order->id }}</a>
        @endif
    </td>
    <td>₹{{ number_format($order->total_amount, 2) }}</td>
    <td>
        <a class="d-flex align-items-center gap-3" href="javascript:;">
            <p class="mb-0 customer-name fw-bold">{{ $order->user->name }}</p>
        </a>
    </td>
    <td>
        <span class="lable-table bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}-subtle 
    text-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} rounded 
    border border-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}-subtle 
    font-text2 fw-bold">
            {{ ucfirst($order->payment_status) }}
            <i class="bi bi-{{ $order->payment_status == 'paid' ? 'check2' : 'exclamation-lg' }} ms-2"></i>
        </span>
    </td>
    <td>
        <select class="form-select form-select-sm fw-bold 
                                            bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'shipped' ? 'info' : ($order->status == 'delivered' ? 'success' : 'danger')) }}-subtle 
                                            text-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'shipped' ? 'info' : ($order->status == 'delivered' ? 'success' : 'danger')) }} 
                                            border border-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'shipped' ? 'info' : ($order->status == 'delivered' ? 'success' : 'danger')) }}-subtle 
                                            status-dropdown" data-order-id="{{ $order->id }}">

            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </td>
    <td>{{ ucfirst($order->payment_method == 'prepaid' ? 'Net Banking' : '') }}</td>
    <td>{{ $order->created_at->format('M d, h:i A') }}</td>
</tr>
@endforeach
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderMailer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a paginated listing of orders with optional status filter.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        $status = $request->input('status');
        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->query());

        $statuses = array('pending', 'processing', 'shipped', 'delivered', 'cancelled');

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Display the specified order with its items.
     */
    public function show(Order $order)
    {
        $order->load(array('user', 'orderItems.product'));

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order, OrderMailer $mailer)
    {
        $this->validate($request, array(
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'note'   => 'nullable|string|max:1000',
        ));

        $newStatus = $request->input('status');
        $note      = $request->input('note');

        $previousStatus = $order->status;
        $order->update(array('status' => $newStatus));

        // Notify the customer + admin of the status change (native PHP mail).
        if ($previousStatus !== $newStatus || ! empty($note)) {
            $mailer->statusChanged($order->fresh(), $previousStatus, $note);
        }

        return redirect()
            ->back()
            ->with('success', 'Order status updated to "' . $newStatus . '". Customer & admin notified by email.');
    }
}

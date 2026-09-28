<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a paginated listing of customers (users with role=customer).
     */
    public function index()
    {
        // "Total Spent" needs a SUM per customer. Eloquent's withSum() only
        // exists from Laravel 8, so the same value is produced here with a
        // correlated sub-select aliased to the column name the view expects.
        $spentSubQuery = '(select coalesce(sum(orders.total), 0) from orders'
            . ' where orders.user_id = users.id) as orders_sum_total';

        $customers = User::where('role', 'customer')
            ->select('users.*')
            ->selectRaw($spentSubQuery)
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Display the specified customer with their orders.
     */
    public function show(User $customer)
    {
        $customer->load(array('orders' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }));

        // Lifetime value for this customer. The view renders this as
        // "Total Spent"; it was never passed through before.
        $totalSpent = Order::where('user_id', $customer->id)->sum('total');

        return view('admin.customers.show', compact('customer', 'totalSpent'));
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orders()
    {

     try {

       $orders = DB::table('orders')
       ->join('users', 'orders.user_id', '=', 'users.id')
       ->select( 'users.name as Name','users.email as Email','orders.total_price as Price','orders.status as Status')
       ->orderBy('Price','desc')
       ->paginate(10);

       return response()->json([
         'orders' => $orders,
         'message' => 'All orders fetched successfully.'
       ],200);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'An error occurred while fetching orders. Please try again later.',
            'details' => $e->getMessage()
        ], 500);
    }
    }

    public function showOrder($id)
    {
        $order = Order::findOrfail($id);

        return response()->json([
            'order' => [
                'User' => $order->user->name,
                'Price' => $order->total_price,
                'Status' => $order->status,
                'Date' => $order->created_at,
            ],
            'message' => 'Order fetched successfully.'
        ], 200);
    }

    public function storeOrder(OrderRequest $request)
    {
       
        try {
            $order = Order::create($request->all());

            return response()->json([
                'order' => $order,
                'message' => 'Order created successfully.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating order. Please try again later.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    public function updateOrder(UpdateOrderRequest $request,$id)
    {
       
        $order = Order::findOrfail($id);

        try {
            $order->update($request->all());

            return response()->json([
                'order' => $order,
                'message' => 'Order updated successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating order. Please try again later.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyOrder($id)
    {
        $order = Order::findOrfail($id);

        try {
            $order->delete();

            return response()->json([
               'message' => 'Order deleted successfully.'
            ], 204);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting order. Please try again later.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}

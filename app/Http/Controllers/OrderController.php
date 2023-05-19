<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exceptions\ItemDoesNotExit;
use App\Http\Requests\CreateProductRequest;
use App\Exceptions\InvalidForeignKey;
use App\Http\Resources\OrderResource;
use App\Http\Requests\PaymentOrderRequest;
use App\Models\Order;
Use Carbon\Carbon;
Use App\Http\Requests\UpdateOrderStatus;

class OrderController extends Controller
{
    public function getOrders($id) {
        $user_id = auth('jwt')->user()->user_id;

        if ($user_id !== (int)$id ) {
            return response()->json([
                'status' => 401 ,
                'message' => 'Access Denied',
            ]);
        }

        $user = User::find($id);
        throw_if(!$user, ItemDoesNotExit::class);
        $orders = $user->orders;
        throw_if(!$orders, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => OrderResource::collection($orders)
        ]);
    }

    public function getOrder($id, $id_order) {
        $user_id = auth('jwt')->user()->user_id;

        if ($user_id !== (int)$id ) {
            return response()->json([
                'status' => 401 ,
                'message' => 'Access Denied',
            ]);
        }

        $user = User::find($id);
        throw_if(!$user, ItemDoesNotExit::class);
        $order = $user->orders()->find($id_order);
        throw_if(!$order, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new OrderResource($order)
        ]);
    }

    public function paymentOrder($id ,PaymentOrderRequest $request) {
        $user_id = auth('jwt')->user()->user_id;

        if ($user_id !== (int)$id ) {
            return response()->json([
                'status' => 401 ,
                'message' => 'Access Denied',
            ]);
        }


        $user = User::find($id);
        throw_if(!$user, ItemDoesNotExit::class);
        $cart = $user->cart;

        if(!$cart) {
            return response()->json([
                'status' => 200,
                'message' => 'user not have any product in cart'
            ]);
        }

        $order = Order::create([
            'user_id' => $id,
            'reciver' => $request->reciver,
            'phone' => $request->phone,
            'address' => $request->address,
            'total_money' => $cart->total_price,
            'order_date' => Carbon::now()->toDateString(),
            'order_status' => 'đang xử lí',
            'method_payment' => $request->method_payment,
            'total_quantity' => $cart->total_quantity
        ]);

        $cart->products->map(function ($product) use ($order){
            $order->products()->attach($product->product_id, ['quantity' => $product->pivot->quantity]);
        });

        return response()->json([
            'status' => 201,
            'message' => 'The item was created successfully',
            'data' => new OrderResource($order)
        ]);
    }

    public function updateOrderStatus($id, $id_order, UpdateOrderStatus $request) {
        $user = User::find($id);
        throw_if(!$user, ItemDoesNotExit::class);
        $order = $user->orders()->find($id_order);

        throw_if(!$order, ItemDoesNotExit::class);

        $request->validated();

        $order_status = $order->order_status;

        switch ($order_status) {
            case 'đã hủy':
                return response()->json([
                    'status' => 400,
                    'message' => 'The order has been canceled and cannot be updated',
                    'data' => new OrderResource($order)
                ]);
                break;

            case 'đang giao hàng':
                return response()->json([
                    'status' => 400,
                    'message' => 'Orders and orders being delivered cannot be updated',
                    'data' => new OrderResource($order)
                ]);
                break;
            
            case 'đã hoàn thành':
                return response()->json([
                    'status' => 400,
                    'message' => 'The order has been completed so cannot update',
                    'data' => new OrderResource($order)
                ]);
                break;
            
            case 'đã chuyển hoàn':
                return response()->json([
                    'status' => 400,
                    'message' => 'The order has been completed so cannot update',
                    'data' => new OrderResource($order)
                ]);
                break;

            default:
                $order->update([
                    'order_status' => $request->order_status
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Order status updated',
                    'data' => new OrderResource($order),
                ]);
                break;
        }
    }
}

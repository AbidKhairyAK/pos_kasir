<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Payment;
use App\Model\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders         = Order::all();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payments       = Payment::all();
        $products       = Product::all();
        return view('admin.orders.create', compact('payments', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product            = Product::find($request->product_id);

        $request->merge([
            'total'         => $request->quantity*$product->price,
            'user_id'       => auth()->user()->id,
            'product_name'  => $product->name,
            'product_price' => $product->price,
        ]);

        $order              = $request->only('table_number', 'total', 'payment_id', 'user_id');

        $orderData           = Order::create($order);

        $request->merge([
            'order_id'      => $orderData->id,
        ]);

        $orderDetail        = $request->only('order_id', 'product_id', 'product_name', 'product_price', 'quantity');
        OrderDetail::create($orderDetail);
        
        return redirect('/orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order              = Order::find($id);
        $orderDetail        = OrderDetail::where('order_id', $id)->first();        
        $products           = Product::all();
        $payments           = Payment::all();
        return view('admin.orders.edit', compact('order', 'orderDetail', 'products', 'payments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product            = Product::find($request->product_id);

        $request->merge([
            'total'         => $request->quantity*$product->price,
            'quantity'      => $request->quantity,
            'user_id'       => auth()->user()->id,
            'product_name'  => $product->name,
            'product_price' => $product->price,
        ]);

        $order              = $request->only('table_number', 'total', 'payment_id', 'user_id');

        $orderData          = Order::find($id)->update($order);

        $orderDetail        = $request->only('product_id', 'product_name', 'product_price', 'quantity');        
        OrderDetail::where('order_id', $id)->update($orderDetail);
        
        return redirect('/orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::find($id)->delete();
        return redirect('/orders');
    }
}
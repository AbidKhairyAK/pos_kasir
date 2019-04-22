<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Payment;
use App\Model\Product;

class OrderController extends Controller
{
    public function index()
    {
    	$orders = Order::orderBy('created_at', 'desc')->get();

    	return view('orders.index', compact('orders'));
    }

    public function create()
    {
    	$payments = Payment::all();
    	$products = Product::all();

    	return view('orders.create', compact('payments', 'products'));
	}

	public function store(Request $request)
	{
		$request->merge([
			'user_id' => 1
		]);

		$dataOrder = $request->only('table_number','payment_id','user_id');

		$order = Order::create($dataOrder);

		$dataDetail = $request->only('product_id','quantity','note');
		$countDetail = count($dataDetail['product_id']);

		for ($i=0; $i < $countDetail; $i++) { 

			$product = Product::find($dataDetail['product_id'][$i]);
			
			$detail 			= new OrderDetail();
			$detail->order_id 	= $order->id;
			$detail->product_id = $dataDetail['product_id'][$i];
			$detail->quantity 	= $dataDetail['quantity'][$i];
			$detail->subtotal 	= $product->price * $detail->quantity;
			$detail->save();

		}
		
		$total = OrderDetail::where('order_id', $order->id)->sum('subtotal');

		Order::find($order->id)->update(['total' => $total]);

		return redirect('/orders');
	}

	public function show($id)
	{
		$order = Order::find($id);

		return view('orders.show', compact('order'));
	}
}

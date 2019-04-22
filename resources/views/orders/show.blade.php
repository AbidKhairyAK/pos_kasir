<!DOCTYPE html>
<html>
<head>
	<title>Kasir</title>
	<style type="text/css">
		table {
			width: 100%;
			border-collapse: collapse;
		}
		th, td {
			border: 1px solid #777;
			padding: 5px;
		}
	</style>
</head>
<body>
	<h1>Show Order</h1>

	<p>Table Number: {{ $order->table_number }}</p>
	<p>Payment: {{ $order->payment->name }}</p>
	<p>Total: {{ $order->total }}</p>
	<p>Created By: {{ $order->user->name }}</p>

	<hr>
	<h3>Details</h3>

	@foreach($order->orderDetail as $index => $detail)
		<p>
			{{ $index + 1 }}. 
			{{ $detail->product->name }} 
			{{ $detail->quantity }}pcs : 
			{{ $detail->subtotal }}
		</p>
	@endforeach
</body>
</html>
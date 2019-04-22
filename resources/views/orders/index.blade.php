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
	<h1>Order List</h1>

	<a href="{{ route('orders.create') }}">Create Order</a>

	<table>
		<tr>
			<th>Table Number</th>
			<th>Payment</th>
			<th>Total</th>
			<th>Created By</th>
			<th>Action</th>
		</tr>

		@foreach($orders as $order)
		<tr>
			<td>{{ $order->table_number }}</td>
			<td>{{ $order->payment->name }}</td>
			<td>{{ $order->total }}</td>
			<td>{{ $order->user->name }}</td>
			<td>
				<a href="{{ route('orders.show', $order->id) }}">Detail</a> 
				<a href="#">Edit</a>
				<a href="#">Delete</a>
			</td>
		</tr>
		@endforeach

	</table>
</body>
</html>
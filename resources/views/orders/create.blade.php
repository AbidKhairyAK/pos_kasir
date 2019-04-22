<!DOCTYPE html>
<html>
<head>
	<title>Kasir</title>
</head>
<body>

	<div id="app">
		<form method="post" action="{{ route('orders.store') }}">
			@csrf

			<h3>Create Order</h3>

			<p>
				Table Number: 
				<input type="number" name="table_number">
			</p>

			<p>
				Payment: 
				<select name="payment_id">
					@foreach($payments as $payment)
					<option value="{{ $payment->id }}">{{ $payment->name }}</option>
					@endforeach
				</select>
			</p>

			<hr>

			<h3>Create Detail</h3>

			<p v-for="order in order_count" :key="order">
				@{{ order }}. 
				<select name="product_id[]">
					<option>- Product Name -</option>
					@foreach($products as $product)
					<option value="{{ $product->id }}">{{ $product->name }}</option>
					@endforeach
				</select>
				<input type="number" name="quantity[]" placeholder="quantity" value="1">
				<input type="text" name="note[]" placeholder="note">
				<button>delete</button>
			</p>

			<button type="button" @click="order_count++">add</button>
			
			<br><br>

			<button type="submit"><b>SUBMIT</b></button>
		</form>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
	
	<script type="text/javascript">
		new Vue({
			el: '#app',
			data: {
				order_count: 1,
			}
		});
	</script>
</body>
</html>
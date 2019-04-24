<!DOCTYPE html>
<html>
<head>
	<title>Kasir</title>
</head>
<body>

	<div id="app">
		<form method="post" action="{{ route('orders.update', $order->id) }}">
			@csrf @method('PUT')

			<h3>Edit Order</h3>

			<p>
				Table Number: 
				<input type="number" name="table_number" value="{{ $order->table_number }}">
			</p>

			<p>
				Payment: 
				<select name="payment_id">
					@foreach($payments as $payment)
						<option 
							value="{{ $payment->id }}"
							selected="{{ $order->payment_id == $payment->id }}" 
						>
							{{ $payment->name }}
						</option>
					@endforeach
				</select>
			</p>

			<hr>

			<h3>Create Detail</h3>

			<p v-for="(order, index) in orders" :key="index">

				@{{ index + 1 }}. 

				<select name="product_id[]" v-model="order.product_id">
					<option value="0">- Product Name -</option>
					@foreach($products as $product)
					<option value="{{ $product->id }}">{{ $product->name }}</option>
					@endforeach
				</select>

				<input type="number" 
					name="quantity[]" 
					placeholder="quantity" 
					v-model="order.quantity"
				>
				<input type="text" 
					name="note[]" 
					placeholder="note"
				>
				Rp <input type="number" 
					name="subtotal[]" 
					:value="subtotal(order.product_id, order.quantity, index)"
				>
				<button type="button" @click="delDetail(index)">delete</button>
			</p>

			<button type="button" @click="addDetail()">add</button>
			
			<br><br>

			<h3>total:</h3>
			Rp <input type="number" name="total" :value="total">
			
			<br><br>
			
			<button type="submit"><b>SUBMIT</b></button>
		</form>


	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
	
	<script type="text/javascript">
		new Vue({
			el: '#app',
			data: {
				orders: [
					{product_id: 0, quantity: 1, note:'', subtotal: 0},
				],
			},
			methods: {
				subtotal(id, qty, index) {
					return this.orders[index].subtotal = this.products[id] * qty;
				},
				addDetail() {
					this.orders.push( {product_id: 0, quantity: 1, subtotal: 0} );
				},
				delDetail(index) {
					if (index > 0) {
						this.orders.splice(index,1);
					}
				}
			},
			computed: {
				total() {
					return this.orders.map(order => order.subtotal).reduce((prev, next) => prev + next);
				},
				products() {
					let products = [];

					products[0] = 0;

					@foreach($products as $product)
						products[ {{$product->id}} ] = {{$product->price}}
					@endforeach

					return products;
				}
			},
			created() {
				let orders = [];

				@foreach($order->orderDetail as $key => $detail)
					orders[ {{$key}} ] = {
						product_id: {{ $detail->product_id }},
						quantity: {{ $detail->quantity }},
						note: '{{ $detail->note }}',
						subtotal: {{ $detail->subtotal }},
					};
				@endforeach

				this.orders = orders;
			}
		});
	</script>
</body>
</html>
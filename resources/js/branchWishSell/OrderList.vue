<template>
	<div class="card mb-4">
		<h5 class="card-header">Order List</h5>
		<div class="card-body">
			<div class="mb-3">
				<label for="per_page">Per Page:</label>
				<select id="per_page" v-model="perPage">
					<option :key="option" :value="option" v-for="option in perPageOptions">{{ option }}</option>
				</select>
			</div>

			<div class="mb-3">
				<label for="search">Search:</label>
				<input id="search" type="text" v-model="search" />
			</div>

			<div class="card">
				<div class="col-12">
					<h5 class="card-header">Product List</h5>
				</div>
				<div class="table-responsive text-nowrap">
					<table class="table">
						<thead>
							<tr>
								<th>Invoice ID</th>
								<th>Date</th>
								<th>Customer Name</th>
								<th>Customer Phone</th>
								<th>Grand Total</th>
							</tr>
						</thead>
						<tbody class="table-border-bottom-0">
							<tr :key="order.id" v-for="order in filteredOrders">
								{{ order }}
								<td>{{ order.invoice_id }}</td>
								<td>{{ order.date }}</td>
								<td>{{ order.customer_name }}</td>
								<td>{{ order.customer_phone }}</td>
								<td>{{ order.grand_total }}</td>
							</tr>
						</tbody>
					</table>

					<div>
						<button :disabled="currentPage === 1" @click="previousPage">Previous</button>
						<span>{{ currentPage }}</span>
						<button :disabled="currentPage === totalPages" @click="nextPage">Next</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import axios from "axios";

export default {
	data() {
		return {
			orders: [], // Store all orders
			perPage: 10, // Number of orders to show per page
			currentPage: 1, // Current page number
			search: "", // Search term for invoice ID or date
		};
	},
	computed: {
		totalPages() {
			return Math.ceil(this.filteredOrders.length / this.perPage);
		},
		filteredOrders() {
			if (this.search) {
				return this.orders.filter((order) => {
					// Filter by invoice ID or date
					return (
						order.invoice_id.includes(this.search) ||
						order.date.includes(this.search)
					);
				});
			} else {
				return this.orders;
			}
		},
		perPageOptions() {
			return [10, 20, 50]; // Available per-page options
		},
	},
	mounted() {
		this.fetchOrders();
	},
	methods: {
		fetchOrders() {
			axios
				.get("/branch/order-list")
				.then((response) => {
					this.orders = response.data;
				})
				.catch((error) => {
					console.error(error);
				});
		},
		previousPage() {
			if (this.currentPage > 1) {
				this.currentPage--;
			}
		},
		nextPage() {
			if (this.currentPage < this.totalPages) {
				this.currentPage++;
			}
		},
	},
};
</script>
<style scoped>
</style>

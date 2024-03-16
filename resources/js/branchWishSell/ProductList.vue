<template>
    <div class="card mb-4">
		<h5 class="card-header">Product List</h5>
		<div class="card-body">
			<div class="row border border-2">
				<div :key="product.id" class="col-md-6 col-lg-6" v-for="product in productList">
					<div class="card" >
						<!-- <img :src="product.image" alt="Card image cap" class="card-img-top" /> -->
						<div class="card-body">
							<h5 class="card-title">{{ product.name }}</h5>
							<!-- <p class="card-text m-0">{{ product.short_description }}</p> -->
							<p class="card-text m-0">Stock : {{ product.stock_qty }}</p>
							<p class="card-text m-0">Brand : {{ product.brand_name }}</p>
							<p class="card-text m-0">Unit : {{ product.unit_name }}</p>
							<p class="card-text m-0">Category : {{ product.category_name }}</p>
							<button @click="addToCart(product)" class="btn btn-sm btn-success">Add to Cart</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { defineComponent } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
import Pagination from 'v-pagination-3';
export default defineComponent({
	name: "ProductList",
    components: {
        Pagination
    },
	data() {
		return {
			productList: [],
		};
	},
	mounted() {
		this.fetchProductData();
	},
	watch: {},
	methods: {
		fetchProductData() {
			axios
				.get(route("branch.get-product-list")) // Replace with your API endpoint
				.then((response) => {
					this.productList = response.data.products.data;
					console.log(response.data.products);
				})
				.catch((error) => {
					console.error(error);
				});
		},
		addToCart(product) {
			this.$emit("addToCart", product);
		},
	},
});
</script>
<style scoped>
</style>

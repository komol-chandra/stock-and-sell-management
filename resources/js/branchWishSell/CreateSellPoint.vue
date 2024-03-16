<template>
    <div class="card mb-4">
        <h5 class="card-header">Create Sell Point</h5>
        <div class="card-body">
            <div class="row mt-2 mb-2">
                <div class="mb-3 col-md-6">
                    <div class="row">
                        <sell-point-product @addToCart="addToCart"></sell-point-product>
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <sell-point-cart-product :cartItems="cartItems"></sell-point-cart-product>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {defineComponent} from "vue";
import axios from "axios";
import Swal from "sweetalert2";

export default defineComponent({
    name: "CreateSellPoint",
    data() {
        return {
            cartItems: [],
        };
    },
    mounted() {
    },
    watch: {},
    methods: {
        addToCart(product) {
            const exists = this.cartItems.some((item) => item.id === product.id);

            if (!exists) {
                this.cartItems.push(product);
            } else {
                Swal.fire("Ok!", "Product already exists in the cart!", "error");
            }
        },
    },
});
</script>
<style scoped>
</style>

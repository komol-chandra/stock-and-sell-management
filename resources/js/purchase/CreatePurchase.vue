<template>
    <div class="card mb-4">
        <h5 class="card-header">Create Purchase</h5>
        <!-- Account -->
        <div class="card-body">
            <form @keydown.enter.prevent.self @submit.prevent="submitPurchase">
                <div class="row mt-2 mb-2">
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="date">
                            Date
                            <span class="text-danger">*</span>
                        </label>
                        <input autofocus class="form-control" id="date" name="date" type="date"
                               v-model="purchase.date"/>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="invoice_id">
                            Invoice No.
                            <span class="text-danger">*</span>
                        </label>
                        <input autofocus class="form-control" disabled id="invoice_id" name="invoice_id" type="text"
                               v-model="purchase.invoice_id"/>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="supplier">
                            Select Supplier
                            <span class="text-danger">*</span>
                        </label>
                        <select class="select2 form-select" id="supplier_id" name="supplier_id"
                                v-model="purchase.supplier_id">
                            <option :key="supplier.id" :value="supplier.id" v-for="supplier in suppliers">
                                {{ supplier.name }} - {{ supplier.phone }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="product_search">
                            Product Name Or SKU
                            <span class="text-danger">*</span>
                        </label>
                        <input @keyup.enter="getProduct" autofocus class="form-control" id="product_search"
                               name="product_search" type="text" v-model.trim="sku"/>
                    </div>
                </div>
                <div class="row mt-2 mb-2" v-if="purchase.products.length > 0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Branch</th>
                            <th>Quantity</th>
                            <th>Purchase Price</th>
                            <th>Sell Price</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <tr v-for="(product,index) in purchase.products">
                            <td style="width:20%;">
                                <p style="margin: 0px; padding: 0px;">#{{ index + 1 }}-{{ product.name }}</p>
                                <p style="margin: 0px; padding: 0px;">
                                    <b>Stock:</b>
                                    {{ product.stock }}
                                </p>
                                <p style="margin: 0px; padding: 0px;">
                                    <b>Unit:</b>
                                    {{ product.unit }}
                                </p>
                            </td>

                            <td>
                                <select class="select2 form-select" id="branch_id" name="branch_id" required
                                        v-model="product.branch_id">
                                    <option :key="brunch.id" :value="brunch.id" v-for="brunch in brunches">
                                        {{ brunch.name }}
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input @input="calculateTotalPrice(product)" class="form-control" min="1"
                                       name="purchase_qty" type="number" v-model.number="product.purchase_qty"/>
                            </td>
                            <td>
                                <input @input="calculateTotalPrice(product)" class="form-control" min="1"
                                       name="purchase_price" type="number" v-model.number="product.purchase_price"/>
                            </td>
                            <td>
                                <input class="form-control" min="1" name="sell_price" type="number"
                                       v-model.number="product.sell_price"/>
                            </td>
                            <td>
                                <input class="form-control" disabled name="total_price" type="number"
                                       v-model.number="product.total_price"/>
                            </td>
                            <td>
                                <button @click="removeProduct(index)" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash me-1"></i>
                                    Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row mt-2 mb-2">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="note">Note</label>
                            <textarea class="form-control" id="note" name="note" v-model="purchase.note"></textarea>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="transportation_cost">transportation Cost</label>
                            <input @input="calculateGrandTotalWithTransportCost()" class="form-control"
                                   id="transportation_cost" min="0" name="transportation_cost" type="number"
                                   v-model="purchase.transportation_cost"/>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="grand_total">Grand Total</label>
                            <input class="form-control" disabled id="grand_total" name="grand_total" type="text"
                                   v-model="purchase.grand_total"/>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <button :class="{ disabled: purchase.grand_total === 0 }" @click="savePurchaseData"
                            class="btn btn-primary me-2" type="submit">Save changes
                    </button>
                    <button class="btn btn-outline-secondary" type="reset">Cancel</button>
                </div>
            </form>
        </div>
        <!-- /Account -->
    </div>
</template>
<script>
import {defineComponent} from "vue";
import axios from "axios";
import Swal from "sweetalert2";

export default defineComponent({
    name: "CreatePurchase",
    props: {
        suppliers: {
            type: Array,
            required: true,
        },
        brunches: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            sku: "",
            baseUrl: window.location.origin,
            purchase: {
                date: "",
                invoice_id: "",
                supplier_id: "",
                transportation_cost: 0,
                grand_total: 0,
                note: "",
                products: [],
            },
        };
    },
    mounted() {
        this.generateInvoiceId(); // Generate invoice ID when the component is mounted
    },
    watch: {
        "purchase.transportation_cost": function (newCost) {
            this.calculateGrandTotal();
        },
    },
    methods: {
        showAlert(title, body, type) {
            Swal.fire(title, body, type);
        },

        getProduct() {
            let url = this.baseUrl + '/admin/get-product/' + this.sku;
            axios
                .get(url)
                .then((response) => {
                    this.purchase.products.push(response.data.data);
                    Swal.fire("Ok!", "Product Added In List!", "success");
                })
                .catch((error) => {
                    Swal.fire("Ok!", "Product Not Found!", "error");
                });
        },
        generateRandomText(length) {
            const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let randomText = "";
            for (let i = 0; i < length; i++) {
                randomText += characters.charAt(
                    Math.floor(Math.random() * characters.length)
                );
            }
            return randomText;
        },
        generateRandomNumber(length) {
            let randomNumber = "";
            for (let i = 0; i < length; i++) {
                randomNumber += Math.floor(Math.random() * 10);
            }
            return randomNumber;
        },
        generateInvoiceId() {
            const randomText = this.generateRandomText(4);
            const randomNum1 = this.generateRandomNumber(4);
            const randomNum2 = this.generateRandomNumber(4);
            const invoiceId = `${randomText}-${randomNum1}-${randomNum2}`;
            this.purchase.invoice_id = invoiceId;
        },
        calculateTotalPrice(product) {
            product.total_price = product.purchase_qty * product.purchase_price;
            this.calculateGrandTotal();
        },
        calculateGrandTotal() {
            this.purchase.grand_total = this.purchase.products.reduce(
                (total, product) => {
                    return total + product.total_price;
                },
                0
            );
            this.purchase.grand_total += this.purchase.transportation_cost;
        },
        removeProduct(index) {
            this.purchase.products.splice(index, 1);
            this.calculateGrandTotal();
        },

        savePurchaseData() {
            let permission = false;
            if (
                this.purchase.date &&
                this.purchase.invoice_id &&
                this.purchase.supplier_id &&
                this.purchase.grand_total &&
                this.purchase.products.length > 0
            ) {
                permission = true;
            }
            if (permission === false) {
                Swal.fire("Opps", "Fill Every Field", "error");
            } else {
                let url = this.baseUrl + '/admin/purchase/';
                axios
                    .post(url, this.purchase)
                    .then((response) => {
                        console.log(response.data);
                        Swal.fire("Ok", "Purchase Complete", "success").then(() => {
                            window.location.reload();
                        });
                    })
                    .catch((error) => {
                        console.log(error);
                        Swal.fire("Ok", error, "error");
                        // .then(() => {
                        // 	window.location.reload();
                        // });
                    });
            }
        },
    },
});
</script>
<style scoped>
</style>

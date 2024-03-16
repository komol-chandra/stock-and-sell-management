<template>
    <div>
        <h5>Cart Product List</h5>
        <div class="row mt-2 mb-2" v-if="cartItems.length > 0">
            <form @submit.prevent="saveCartData">
                <!-- ========== Calculation card ================== -->
                <div class="border border-2 mb-3">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sub Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <tr :key="item.id" v-for="(item,index) in cartItems">
                            <td>{{ index + 1 }}</td>
                            <td style="width:20%;">
                                <p style="margin: 0px; padding: 0px;">{{ item.name }}</p>
                            </td>
                            <td>
                                <input :value="item.purchase_qty" @change="checkQtyWishStock(item)" class="form-control"
                                       min="1" name="purchase_qty" type="number"/>
                            </td>
                            <td>
                                <p>{{ item.purchase_price }}</p>
                            </td>
                            <td>
                                <p>{{ item.purchase_sub_total }}</p>
                            </td>
                            <td>
                                <button @click="removeProduct(index)" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash me-1"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="mb-3 col-md-6"></div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="grand_total">Grand Total</label>
                            <input class="form-control" disabled id="grand_total" name="grand_total" type="number"
                                   v-model="sellPoint.grand_total"/>
                        </div>
                    </div>
                </div>
                <!-- ========== Calculation card ================== -->
                <div class="border border-2">
                    <div class="row m-3">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="date">
                                Date
                                <span class="text-danger">*</span>
                            </label>
                            <input autofocus class="form-control" id="date" name="date" type="date"
                                   v-model="sellPoint.date"/>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="invoice_id">
                                Invoice No.
                                <span class="text-danger">*</span>
                            </label>
                            <input autofocus class="form-control" disabled id="invoice_id" name="invoice_id" type="text"
                                   v-model="sellPoint.invoice_id"/>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label" for="note">Note</label>
                            <textarea class="form-control" id="note" name="note" v-model="sellPoint.note"></textarea>
                        </div>

                        <!-- ================= User Create Button ================ -->
                            <div class="col-12 d-flex border border-2">
                                <div class="mb-3 col-md-6 ">
<!--                                    <button type="button" class="btn btn-primary mt-4 " @click="isAddNewUser=true">-->
<!--                                        Add New User-->
<!--                                    </button>-->
                                </div>
                                <!-- ================= Select User  ================ -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="userSelect">Select user</label>
                                    <select v-model="selectedUserInfo" class="form-select" id="userSelect" >
                                        <option v-for="user in users" :key="user.id" :value="user">{{ user.name }}</option>
                                    </select>
                                </div>
                            </div>
                        <!-- ================= Create new User Section ================ -->
                        <div class="col-12 border border-2 mt-4" v-if="isAddNewUser">
                            <div class="row">
                                <form @submit.prevent="saveNewUser">
                                    <div class="row m-3">

                                        <div class="mb-3 col-md-12" v-if="newUser.errors">
                                            <p class="text-danger" v-for="error in newUser.errors">{{
                                                    error[0]
                                                }}</p>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label" for="name">Customer Name</label>
                                            <input autofocus class="form-control" id="name" name="name" type="text"
                                                   v-model="newUser.name"/>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label" for="phone">Customer Phone</label>
                                            <input autofocus class="form-control" id="phone" name="phone"
                                                   type="text"
                                                   v-model="newUser.phone"/>
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label class="form-label" for="email">Customer email</label>
                                            <input autofocus class="form-control" id="email" name="email"
                                                   type="email"
                                                   v-model="newUser.email"/>
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label class="form-label" for="address">address</label>
                                            <textarea class="form-control" id="address" name="address"
                                                      v-model="newUser.address"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row mt-2 float-end mb-4">
                                <div class="col-12">
                                    <button class="btn btn-primary me-2" type="submit"
                                            :disabled="!newUser.name || !newUser.phone || ! newUser.email || ! newUser.address"
                                            @click="saveNewUser">Save changes
                                    </button>
                                    <button class="btn btn-outline-secondary" @click="isAddNewUser=false">Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- ================= Display User Information ================ -->
                        <div v-if="sellPoint.customer_id">
                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="customer_name">Customer Name</label>
                                <input autofocus class="form-control" id="customer_name" disabled name="customer_name" type="text" v-model="sellPoint.customer_name"/>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="customer_phone">Customer Phone</label>
                                <input autofocus class="form-control" id="customer_phone" disabled name="customer_phone" type="text" v-model="sellPoint.customer_phone"/>
                            </div>
                        </div>
                        <!-- ================= Display User Information end ================ -->
                    </div>
                </div>
                <div class="mt-4 ">
                    <button :class="{ disabled: sellPoint.grand_total === 0 }" class="btn btn-primary me-2"
                            type="submit">Save changes
                    </button>
                    <button class="btn btn-outline-secondary" type="reset">Cancel</button>
                </div>
            </form>
        </div>
        <!-- ========================= add user modal ============================== -->
    </div>
</template>
<script>
import {defineComponent} from "vue";
import Swal from "sweetalert2";

const {Modal} = bootstrap
export default defineComponent({
    name: "CartProductList",
    props: {
        cartItems: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            baseUrl: window.location.origin,
            isAddNewUser:false,
            isModalShow: false,
            sellPoint: {
                selectedUserId: null,
                date: "",
                invoice_id: "",
                note: "",
                grand_total: 0,
                customer_name: "",
                customer_phone: "",
                customer_id: "",
                products: this.cartItems,
            },
            selectedUserInfo:null,
            newUser: {
                name: "",
                phone: "",
                email: "",
                address: "",
                errorText: "",
                errors: []
            },
            users: [],
            isUserFormFill: false,
        };
    },
    mounted() {
        this.generateInvoiceId();
        this.calculateGrandTotal();
        this.getUserList();
    },
    watch: {
        selectedUserInfo: {
            handler(newValue, oldValue) {
                if (newValue) {
                    this.sellPoint.customer_name = newValue.name;
                    this.sellPoint.customer_phone = newValue.phone;
                    this.sellPoint.customer_id = newValue.id;
                }
            },
            immediate: true,
        },
    },
    computed: {
       //
    },
    methods: {
        onUserSelectChange(user) {
            // This method will be called when the user selection changes
            // You can access the selected user information using this.selectedUser
            console.log('Selected User:', this.selectedUser);
            // If selectedUserInfo is not null, set values in sellPoint
            if (this.selectedUserInfo) {
                this.sellPoint.customer_name = this.selectedUserInfo.name;
                this.sellPoint.customer_phone = this.selectedUserInfo.phone;
                this.sellPoint.customer_id = this.selectedUserInfo.id;
                // You may need to set other values based on your data structure
            }

            // You can perform additional actions based on the selected user
        },
        selectedUser(user){
            this.sellPoint.customer_name = user.name;
            this.sellPoint.customer_phone = user.phone;
            this.sellPoint.customer_id = user.id;
        },
        closeModal() {
            this.resetUser();
            this.isModalShow = false;
        },
        openModal() {
            this.isModalShow = true;
        },
        resetUser() {
            this.newUser.name = "";
            this.newUser.phone = "";
            this.newUser.email = "";
            this.newUser.address = "";
        },
        saveNewUser() {
            let url = this.baseUrl + '/branch/users';
            axios
                .post(url, this.newUser)
                .then((response) => {
                    this.isAddNewUser=false;
                    this.getUserList();
                    Swal.fire("Ok", "User Created", "success");
                })
                .catch((error) => {
                    this.newUser.errorText = error.response.data.message;
                    this.newUser.errors = error.response.data.errors;
                    // this.resetUser();
                    setTimeout(function () {
                    }, 3000);

                    // Handle error response
                    // Swal.fire("Ok", error, "error");
                    // .then(() => {
                    // 	window.location.reload();
                    // });
                });
        },

        getUserList() {
            let url = this.baseUrl + '/branch/users';
            axios
                .get(url) // Replace '/api/users' with your actual API endpoint
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    console.error('Error fetching users:', error);
                    Swal.fire('Error', 'Failed to fetch users', 'error');
                });
        },
        saveCartData() {
            let permission = false;
            if (
                this.sellPoint.date &&
                this.sellPoint.invoice_id &&
                this.sellPoint.note &&
                this.sellPoint.grand_total &&
                this.sellPoint.customer_name &&
                this.sellPoint.customer_phone &&
                this.sellPoint.products.length > 0
            ) {
                permission = true;
            }
            if (permission === false) {
                Swal.fire("Opps", "Fill Every Field", "error");
            } else {
                let url = this.baseUrl + '/branch/sell-point';

                axios
                    .post(url, this.sellPoint)
                    .then((response) => {
                        // Handle success response
                        console.log(response.data);
                        Swal.fire("Ok", "Order Complete", "success").then(() => {
                            window.location.reload();
                        });
                        // Reset the form or perform any other actions
                    })
                    .catch((error) => {
                        console.log(error);
                        // Handle error response
                        Swal.fire("Ok", error, "error");
                        // .then(() => {
                        // 	window.location.reload();
                        // });
                    });
            }
        },
        generateInvoiceId() {
            const randomText = this.$generateRandomText(4);
            const randomNum1 = this.$generateRandomNumber(4);
            const randomNum2 = this.$generateRandomNumber(4);
            const invoiceId = `${randomText}-${randomNum1}-${randomNum2}`;
            this.sellPoint.invoice_id = invoiceId;
        },
        calculateTotalPrice(item) {
            return item.purchase_qty * item.purchase_price;
        },
        calculateGrandTotal() {
            let total = 0;
            this.cartItems.forEach((item) => {
                const subTotal = item.purchase_qty * item.purchase_price;
                total += subTotal;
            });
            this.sellPoint.grand_total = total;
        },
        checkQtyWishStock(item) {
            let qty = parseInt(event.target.value);
            let selectedStock = null;

            item.branch_stock_info.some((element) => {
                let available_qty = element.purchase_qty - element.sell_qty;
                if (available_qty >= qty) {
                    selectedStock = element;
                    return true;
                }
            });

            if (selectedStock) {
                item.purchase_qty = qty;
                item.purchase_price = selectedStock.sell_price;
                item.purchase_sub_total = item.purchase_qty * item.purchase_price;
                item.purchase_branch_id = selectedStock.branch_id;
                item.purchase_stock_id = selectedStock.id;
            } else {
                Swal.fire("No suitable stock found!", "", "error");
            }
            this.calculateGrandTotal();
        },
        removeProduct(index) {
            this.cartItems.splice(index, 1);
            this.calculateGrandTotal();
        },
    },
});
</script>
<style scoped>
</style>

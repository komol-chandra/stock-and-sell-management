import "./bootstrap";
import { createApp } from "vue";
import CreatePurchase from "./purchase/CreatePurchase.vue";
import CreateSellPoint from "./branchWishSell/CreateSellPoint.vue";
import SellPointProductList from "./branchWishSell/ProductList.vue";
import SellPointCartProductList from "./branchWishSell/CartProductList.vue";
import BranchOrderList from "./branchWishSell/OrderList.vue";
import CustomModal from "./utilty/CustomModal.vue";
import VueSweetalert2 from "vue-sweetalert2";

// If you don't need the styles, do not connect
import "sweetalert2/dist/sweetalert2.min.css";

const app = createApp({});
app.use(VueSweetalert2);
app.component("create-purchase", CreatePurchase);
app.component("create-sell-point", CreateSellPoint);
app.component("sell-point-product", SellPointProductList);
app.component("sell-point-cart-product", SellPointCartProductList);
app.component("branch-order-list", BranchOrderList);
app.component("custom-modal", CustomModal);

// Define global functions
app.config.globalProperties.$generateRandomText = function (length) {
    const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    let randomText = "";
    for (let i = 0; i < length; i++) {
        randomText += characters.charAt(
            Math.floor(Math.random() * characters.length)
        );
    }
    return randomText;
};

app.config.globalProperties.$generateRandomNumber = function (length) {
    let randomNumber = "";
    for (let i = 0; i < length; i++) {
        randomNumber += Math.floor(Math.random() * 10);
    }
    return randomNumber;
};

app.mount("#app");

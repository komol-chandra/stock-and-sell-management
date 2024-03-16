<template>
    <div class="modal" v-if="isVisible">
        <!-- Modal content goes here -->
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <!-- Your modal content here -->
            <slot></slot>
        </div>
    </div>
</template>
<script>
export default {
    name: "CustomModal",
    data() {
        return {
            isVisible: false,
        };
    },
    methods: {
        openModal() {
            this.isVisible = true;
        },
        closeModal() {
            this.isVisible = false;
        },
    },
}
</script>
<style scoped>

</style>

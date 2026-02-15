<template>
    <transition name="fade">
        <div v-if="visible" class="toast">
            {{ message }}
        </div>
    </transition>
</template>

<script>
export default {
    name: 'Toast',
    props: {
        message: {
            type: String,
            required: true
        },
        duration: {
            type: Number,
            default: 3000
        }
    },
    data() {
        return {
            visible: false
        };
    },
    methods: {
        show() {
            this.visible = true;
            setTimeout(() => {
                this.visible = false;
            }, this.duration);
        }
    }
};
</script>

<style scoped>
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #4BB543;
    color: white;
    padding: 10px 16px;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    font-size: 14px;
    z-index: 9999;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

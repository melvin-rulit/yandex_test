<template>
    <div>
        <Sidebar @changeTab="changeTab" class="sidebar" />
        <TopBlock class="top-block" />

        <div class="main-content">
            <div v-if="activeTab === 'reviews'">
                <Reviews />
            </div>
            <div v-if="activeTab === 'settings'">
                <Settings />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Sidebar from './Sidebar.vue';
import TopBlock from './TopBlock.vue';
import Reviews from '../Pages/Reviews/Index.vue';
import Settings from '../Pages/Settings/Index.vue';

const activeTab = ref('reviews');
const changeTab = (tab) => {
    activeTab.value = tab;
};
</script>

<style scoped>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 300px;
    height: 100vh;
    background-color: #F6F8FA;
    z-index: 2000;
}
.top-block {
    position: fixed;
    top: 0;
    left: 300px;
    right: 0;
    height: 75px;
    background-color: #fff;
    z-index: 1000;
    border-bottom: 1px solid #DCE4EA;
    display: flex;
    align-items: center;
    padding: 0 20px;
}
.main-content {
    margin-left: 300px;
    margin-top: 75px;
    padding: 20px;
}
</style>

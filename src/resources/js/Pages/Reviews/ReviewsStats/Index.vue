<template>
    <div class="container">
        <div
            class="reviews-container"
            :style="{ top: topOffset + 'px' }"
            ref="reviewsContainer"
        >
            <div class="reviews-header">
                <div class="rating-number">{{ companyRating.toFixed(1) }}</div>
                <span
                    v-for="n in 5"
                    :key="n"
                    class="star"
                    :class="{ filled: n <= Math.round(companyRating) }"
                >★</span>
            </div>
            <div class="divider"></div>
            <div class="reviews-list">
                <p>
                    Всего отзывов: <span class="total_reviews">{{ totalReviews }}</span>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

defineProps({
    totalReviews: { type: Number, required: true },
    companyRating: { type: Number, required: true }
});

const topOffset = ref(27);
const reviewsContainer = ref(null);

const handleScroll = () => {
    const scrollY = window.scrollY;
    const maxOffset = 50;
    topOffset.value = 30 + Math.min(scrollY, maxOffset);
};

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<style scoped>
.container {
    display: flex;
    gap: 20px;
}
.reviews-container {
    width: 290px;
    height: 155px;
    position: absolute;
    border-radius: 12px;
    border: 1px solid #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    background-color: #fff;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: top 0.2s ease;
    z-index: 10;
}
.reviews-header {
    display: flex;
    align-items: center;
    gap: 10px;
}
.rating-number {
    font-size: 36px;
    font-weight: bold;
    color: #363740;
}
.star {
    font-size: 50px;
    color: #ccc;
}
.star.filled {
    color: #f5b300;
}
.divider {
    height: 2px;
    background-color: #e0e0e0;
    margin: 10px 0;
    border-radius: 1px;
}
.reviews-list p {
    font-size: 14px;
    color: #363740;
    margin: 0;
    font-weight: bold;
}
.total_reviews {
    font-weight: bold;
}
</style>

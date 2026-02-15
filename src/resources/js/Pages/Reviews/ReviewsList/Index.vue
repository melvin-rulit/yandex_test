<template>
    <div class="review-block">
        <div v-if="error" class="error-message text-center text-red-500 font-semibold py-4">
            {{ error }}
        </div>

        <div v-if="hasReviews && !loading && !error">
            <div class="yandex-badge">
                <img :src="Vector" alt="Vector" class="badge-icon mr-2" />
                <span>Яндекс Карты</span>
            </div>
            <div class="review-content">
                <div
                    v-for="(review, index) in reviews"
                    :key="index"
                    class="review-item"
                    v-if="hasReviews">
                    <div class="review-card">
                        <div class="review-text-block">
                            <div class="review-header">
                                <div class="top-content-block">
                                    <span class="top_content">{{ formatDate(review.date) }}</span>
                                    <span class="branch-label">Филиал 1</span>
                                    <img :src="Vector" alt="Vector" class="badge-icon" />
                                </div>

                                <div class="stars">
                                    <span
                                        v-for="n in 5"
                                        :key="n"
                                        class="star"
                                        :class="{ filled: n <= review.rating }">
                                        ★
                                    </span>
                                </div>
                            </div>

                            <div class="review-author-row">
                                <strong class="author-name">{{ review.author }}</strong>
                                <span class="fake-phone">{{ fakePhone }}</span>
                            </div>
                            <p class="review-text">
                                {{ review.review_text }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!hasReviews && !loading && !error" class="no-reviews">
            Отзывов пока нет
        </div>
    </div>
</template>

<script>
import Spinner from '../../../Components/Spiner.vue';
import Vector from '@/../images/Vector.png';

export default {
    name: 'ReviewsList',
    components: { Spinner },
    props: {
        hasReviews: {
            type: Boolean,
            default: false,
        },
        reviews: {
            type: Array,
            required: true,
        },
        loading: {
            type: Boolean,
            default: false,
        },
        error: {
            type: String,
            default: null,
        },
    },
    data() {
        return {
            Vector,
            fakePhone: '+7 (999) 111‑22‑33',
        };
    },
    methods: {
        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('ru-RU', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
            });
        },
    },
};
</script>

<style scoped>
.review-block {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.review-content {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.review-item {
    width: 100%;
}
.review-card {
    padding: 16px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.20);
    border: 1px solid #ddd;
}
.review-card p {
    font-size: 14px;
    color: #363740;
}
.review-card strong {
    color: #333;
}
.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.review-author-row {
    display: flex;
    align-items: center;
}
.author-name {
    font-size: 14px;
    color: #333;
}

.fake-phone {
    margin-left: 10px;
    font-size: 13px;
    color: #888;
    white-space: nowrap;
}
.top-content-block {
    display: flex;
    align-items: center;
    gap: 6px;
}
.top_content {
    font-size: 14px;
    color: #555;
}
.stars {
    display: flex;
    gap: 3px;
}
.star {
    font-size: 25px;
    color: #ccc;
}
.star.filled {
    color: #f5b300;
}
.review-text-block {
    background-color: #F6F8FA;
    padding: 5px;
    border-radius: 6px;
}
.yandex-badge {
    display: inline-flex;
    align-items: center;
    font-family: 'Mulish', sans-serif;
    font-weight: 500;
    font-style: normal;
    font-size: 12px;
    line-height: 100%;
    color: #363740;
    border: 1px solid #DCE4EA;
    border-radius: 8px;
    padding: 2px 6px;
    width: max-content;
}
.badge-icon {
    width: 16px;
    height: 16px;
}
.no-reviews {
    padding: 16px;
    background: #f9f9f9;
    border-radius: 8px;
    font-weight: 500;
    color: #555;
}
.error-message {
    width: 100%;
    padding: 16px;
    background-color: #ffe5e5;
    color: #d8000c;
    font-weight: 500;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 16px;
}
</style>

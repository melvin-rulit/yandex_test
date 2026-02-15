<template>
    <Spinner v-if="loading" />
    <div class="main-content-container">
        <div class="content">
            <ReviewsList
                :hasReviews="hasReviews"
                :reviews="reviews"
                :loading="loading"
                :error="error"
            />
            <ReviewsStats
                v-if="hasReviews"
                :companyRating="companyRating"
                :totalReviews="totalReviews"
                class="company-stats"
            />
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import ReviewsList from './ReviewsList/Index.vue';
import ReviewsStats from './ReviewsStats/Index.vue';
import Spinner from "@/Components/Spiner.vue";

export default {
    name: 'Reviews/Index',
    components: {Spinner,ReviewsList,ReviewsStats},
    data() {
        return {
            reviews: [],
            companyRating: 0,
            totalReviews: 0,
            loading: false,
            error: null,
        };
    },
    computed: {
        hasReviews() {
            return this.reviews.length > 0;
        },
    },
    methods: {
        async fetchReviews() {
            this.loading = true;
            try {
                const { data } = await axios.get('/reviews');

                if (data.error) {
                    this.error = data.error;
                    this.reviews = [];
                    this.companyRating = 0;
                    this.totalReviews = 0;
                } else {
                    this.reviews = data.reviews || [];
                    this.companyRating = data.summary?.company_rating || 0;
                    this.totalReviews = data.summary?.total_reviews || 0;
                }
            } catch (err) {
                this.reviews = [];
                this.companyRating = 0;
                this.totalReviews = 0;
            }finally {
                this.loading = false;
            }
        }
    },
    mounted() {
        this.fetchReviews();
    }
};
</script>

<style scoped>
.main-content-container {
    display: flex;
    flex-direction: column;
    padding: 20px;
}
.content {
    display: flex;
    gap: 20px;
    width: 100%;
}
.company-stats {
    position: sticky;
    top: 20px;
    align-self: flex-start;
}
</style>

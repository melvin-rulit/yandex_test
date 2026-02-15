<template>
    <div class="p-6 max-w-4xl">
        <h1 class="text-md mb-6">Подключить Яндекс</h1>
        <Toast ref="toast" :message="toastMessage" />
        <div>
            <p class="yandex-link-instruction mb-2">
                <span class="instruction-text">Укажите ссылку на Яндекс, пример:</span>
                <span class="example-url">
                    https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/
                </span>
            </p>

            <div class="flex flex-col space-y-2">
                <TextInput
                    v-model="url"
                    placeholder="Введите ссылку на Яндекс"
                    autofocus/>
                <p v-if="error" class="text-red-500 text-sm mt-2">
                    {{ error }}
                </p>
                <button
                    type="button"
                    @click="saveUrl"
                    :disabled="loading"
                    class="bg-blue-300 text-white rounded hover:bg-blue-400 disabled:opacity-50 flex items-center justify-center"
                    style="width: 128px; height: 25px; border-radius: 6px;">
                    Сохранить
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import TextInput from "@/Components/TextInput.vue";
import Toast from "@/Components/Toast.vue";

export default {
    name: 'YandexSettings',
    components: {Toast, TextInput },
    data() {
        return {
            url: '',
            loading: false,
            error: null,
            toastMessage: '',
            showToast: false,
        };
    },
    watch: {
        url(newValue) {
            this.$emit('update:modelValue', newValue);
        }
    },
    methods: {
        async fetchSettings() {
            this.loading = true;
            this.error = null;

            try {
                const { data } = await axios.get('/yandex/settings');
                const orgUrl = data.org_url ?? '';
                this.url = orgUrl;
                this.$emit('update:modelValue', orgUrl);
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
        async saveUrl() {
            if (!this.url) {
                this.error = 'Поле не может быть пустым';
                return;
            }
            this.error = null;
            this.loading = true;

            try {
                const { data } = await axios.post('/yandex/settings', { org_url: this.url });
                this.url = data.org_url;
                this.toastMessage = data.message
                this.$refs.toast.show(true);
                this.$emit('update:modelValue', this.url);

            }catch (e) {
                if (e.response && e.response.status === 422) {
                    const errors = e.response.data.errors ?? {};
                    if (errors.org_url) {
                        this.error = errors.org_url[0];
                    }
                } else if (e.response && e.response.data?.error) {
                    this.error = e.response.data.error;
                }
            }finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.fetchSettings();
    }
};
</script>

<style scoped>
.yandex-link-instruction {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    line-height: 20px;
}
.instruction-text {
    font-family: 'Mulish', sans-serif;
    font-weight: 600;
    font-size: 12px;
    line-height: 20px;
    letter-spacing: 0.2px;
    color: #6C757D;
}
.example-url {
    font-family: 'Mulish', sans-serif;
    font-weight: 400;
    font-size: 12px;
    line-height: 100%;
    text-decoration: underline;
    letter-spacing: 0px;
    vertical-align: middle;
}
.loader {
    border: 2px solid #f3f3f3;
    border-top: 2px solid #fff;
    border-radius: 50%;
    width: 14px;
    height: 14px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

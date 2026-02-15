<template>
    <div class="flex flex-col">
        <input
            ref="input"
            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-100 px-2 py-1"
            :placeholder="placeholder"
            :value="modelValue"
            @input="onInput"
        />
    </div>
</template>

<script>
export default {
    name: 'TextInput',

    props: {
        modelValue: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            default: '',
        },
        autofocus: {
            type: Boolean,
            default: false,
        },
    },

    emits: ['update:modelValue'],

    mounted() {
        if (this.autofocus && this.$refs.input) {
            this.$refs.input.focus();
        }
    },

    methods: {
        onInput(event) {
            this.$emit('update:modelValue', event.target.value);
        },

        focus() {
            this.$refs.input?.focus();
        },
    },
};
</script>

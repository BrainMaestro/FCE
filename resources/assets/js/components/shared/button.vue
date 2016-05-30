<template>
    <button class="button is-medium" :class="{'is-primary': isActive}" @click="loadPage">
        <slot></slot>
    </button>
</template>

<script>
    import { http } from 'vue';

    export default {
        props: {
            value: Number,
            current: Number,
            href: String,
        },

        data() {
            return {
                isActive: this.value && this.value == this.current,
            }
        },

        methods: {
            loadPage() {
                if (this.href && !this.isActive) {
                    // HACK: Will be removed once we are able to preserve other non-page parameters.
                    this.href += '&include=semester,school';
                    http.get(this.href).then((res) => this.$dispatch('page-changed', res));
                }
            }
        }
    }
</script>

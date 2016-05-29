<template>
    <span class="tag" :class="style[item].color">
        <span class="icon is-small">
            <i class="fa" :class="style[item].icon"></i>
        </span>

        <span>{{ item.split('.').join(' ') | capitalize }}</span>
    </span>
</template>

<script>
    export default {
        props: {
            item: String
        },

        data() {
            return {
                style: {
                    locked: { color: 'is-dark', icon: 'fa-lock' },
                    open: { color: 'is-info', icon: 'fa-unlock' },
                    done: { color: 'is-success', icon: 'fa-check-circle' },
                    'in.progress': { color: 'is-warning', icon: 'fa-spinner' },
                    current : { color: 'is-success', icon: 'fa-check-circle' },
                }
            };
        }
    };
</script>

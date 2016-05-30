<template>
    <hr>
    <div class="has-text-centered">
        <bulma-button :href="pagination.links.previous">
            <i class="fa fa-chevron-left"></i>
        </bulma-button>

        <bulma-button v-for="a in pageNumbers" :value="a.page"
                      :current="pagination.current_page" :href="a.href">
            {{ a.page }}
        </bulma-button>

        <bulma-button :href="pagination.links.next">
            <i class="fa fa-chevron-right"></i>
        </bulma-button>
    </div>
</template>

<script>
    import BulmaButton from './button.vue';

    export default {
        props: {
            pagination: Object,
        },

        components: { BulmaButton },

        computed: {
            pageNumbers() {
                let pages = [];
                for (let i = 1; i <= this.pagination.total_pages; i++) {
                    const link = this.pagination.links.next || this.pagination.links.previous;
                    pages.push({ page: i, href: link.replace(/page=[0-9]+/, `page=${i}`) });
                }

                return pages;
            }
        },
    }
</script>

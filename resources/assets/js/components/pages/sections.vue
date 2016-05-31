<template>
    <search :model="'section'" :on-search="refreshData" :columns="columns" :default="default"></search>
    <bulma-table :columns="columns" :rows="sections"></bulma-table>
</template>

<script>
    import sectionStore from '../../stores/section';
    import { section as columns } from '../../utils/table-columns';

    import BulmaTable from '../shared/table.vue';
    import Search from '../shared/search.vue';

    export default {
        components: { BulmaTable, Search },

        data() {
            return {
                columns,
                sections: [],
                default: sectionStore.getAllSections
            }
        },

        created() {
            sectionStore.getAllSections(this.refreshData);
        },

        methods: {
            refreshData(res) {
                this.sections = res;
            }
        }
    }
</script>

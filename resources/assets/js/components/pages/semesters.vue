<template>
    <search :model="'semester'" :on-search="refreshData" :columns="columns" :default="default"></search>
    <bulma-table :columns="columns" :rows="semesters"></bulma-table>
</template>

<script>
    import semesterStore from '../../stores/semester';
    import { semester as columns } from '../../utils/table-columns';

    import BulmaTable from '../shared/table.vue';
    import Search from '../shared/search.vue';

    export default {
        components: { BulmaTable, Search },

        data() {
            return {
                columns,
                semesters: [],
                default: semesterStore.getAllSemesters
            }
        },

        created() {
            semesterStore.getAllSemesters(this.refreshData);
        },

        methods: {
            refreshData(res) {
                this.semesters = res;
            }
        }
    }
</script>

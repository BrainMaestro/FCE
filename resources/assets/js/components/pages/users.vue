<template>
    <search :model="'user'" :on-search="refreshData" :columns="columns" :default="default"></search>
    <bulma-table :columns="columns" :rows="users"></bulma-table>
</template>

<script>
    import userStore from '../../stores/user';
    import { user as columns } from '../../utils/table-columns';

    import BulmaTable from '../shared/table.vue';
    import Search from '../shared/search.vue';

    export default {
        components: { BulmaTable, Search },

        data() {
            return {
                columns,
                users: [],
                default: userStore.getAllUsers
            }
        },

        created() {
            userStore.getAllUsers(this.refreshData);
        },

        methods: {
            refreshData(res) {
                this.users = res;
            }
        }
    }
</script>

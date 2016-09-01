<template>
    <search :model="'section'" :on-search="refreshData" :columns="columns" :default="default"></search>
    <div class="tabs is-right is-small">
      <ul>
        <li v-link="{ path: '/add-section', activeClass: 'is-active'}" class="is-active"><a>
            <span class="icon is-small"><i class="fa fa-plus"></i></span>
            <span>Add a section</span>
        </a></li>
      </ul>
    </div>
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
        /* I don't know if you wanted ready() here so I'll create mine */
        created() {
            sectionStore.getAllSections(this.refreshData);
        },

        ready() {
            sectionStore.getAllSections(this.refreshData);
        },

        methods: {
            refreshData(res) {
                this.sections = res;
            }
        }
    }
</script>

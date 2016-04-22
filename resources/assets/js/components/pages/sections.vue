<template>
    <bulma-table :columns="columns" :rows="sections">
        <span></span>
    </bulma-table>
</template>

<script>
    import sectionStore from '../../stores/section';
    import { section as columns } from '../../utils/table-columns';

    import BulmaTable from '../shared/table.vue';

    export default {
        components: { BulmaTable },

        data() {
            return {
                columns,
                sections: []
            }
        },

        created() {
            sectionStore.getAllSections((res) => {
                this.sections = res.data.map(this.formatSection);
            });
        },

        methods: {
            // Format the sections properly for display.
            formatSection(section) {
                return Object.keys(this.columns).map((key) => {
                    const value = section[key];
                    let item = {};

                    switch (key) {
                        case 'semester':
                            item[key] = `${value.data.season} ${value.data.year}`;
                            break;

                        case 'school':
                            item[key] = value.data.school;
                            break;

                        case 'users':
                            item[key] = value.data.map(user => user.name);
                            break;

                        default:
                            item[key] = value;
                    }

                    return item;
                });
            }
        }
    }
</script>

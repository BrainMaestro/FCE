<template>
    <table class="table is-striped">
        <thead>
        <tr>
            <th v-for="column in columns">{{ column }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="row in formattedRows" :style="{ backgroundColor : row.active && '#97cd76' }">
            <td v-for="pair in row">
                <span v-for="(key, item) in pair">
                    <!--If item is an array or object, display the individual elements as tags-->
                    <span v-if="typeof item == 'object'">
                        <span class="tag is-dark" v-for="element in item">
                            {{ element }}
                        </span>
                    </span>

                    <span v-else>
                        <status v-if="key == 'status' || key == 'current_semester'" :item="item"></status>
                        <span v-else>{{ item }}</span>
                    </span>
                </span>
            </td>
        </tr>
        </tbody>
    </table>

    <pagination :pagination="rows.meta.pagination"></pagination>
</template>

<script>
    import Status from './status.vue';
    import Pagination from './pagination.vue';

    export default {
        props: {
            columns: Object,
            rows: Object,
        },

        components: { Status, Pagination },

        computed: {
            formattedRows() {
                return this.rows.data.map((row) => {
                    const formattedRow = Object.keys(this.columns).map((key) => {
                        const value = row[key];
                        let item = {};

                        switch (key) {
                            case 'semester':
                                item[key] = `${value.data.season} ${value.data.year}`;
                                break;

                            case 'school':
                                item[key] = value.data.school;
                                break;

                            case 'users':
                            case 'questionSets':
                                item[key] = value.data.map(val => val.name);
                                break;

                            case 'schools':
                                item[key] = value.data.map(val => val.school);
                                break;

                            case 'roles':
                                item[key] = value.data.map(val => val.display_name);
                                break;

                            default:
                                item[key] = value;
                        }

                        return item;
                    });

                    if (row.current_semester) {
                        formattedRow.active = true;
                    }

                    return formattedRow;
                });
            }
        },

        events: {
            'page-changed': function(res) {
                this.$set('rows', res);
            }
        }
    };
</script>

<style>
    .tag {
        margin-bottom: 0.25em;
        display: block;
        float: left;
        clear: both;
    }

    tr:hover {
        background-color: inherit;
    }
</style>

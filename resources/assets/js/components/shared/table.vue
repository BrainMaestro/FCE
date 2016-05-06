<template>
    <table class="table is-striped">
        <thead>
        <tr>
            <th v-for="column in columns">{{ column }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="row in formatedRows">
            <td v-for="pair in row">
                <span v-for="(key, item) in pair">
                    <!--If item is an array or object, display the individual elements as tags-->
                    <span v-if="typeof item == 'object'">
                        <span class="tag is-dark" v-for="element in item">
                            {{ element }}
                        </span>
                    </span>

                    <span v-else>
                        <status v-if="key == 'status'" :item="item"></status>
                        <span v-else>{{ item }}</span>
                    </span>
                </span>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import Status from './status.vue';


    export default {
        props: {
            columns: Object,
            rows: Array
        },

        components: { Status },

        computed: {
            formatedRows() {
                return this.rows.map((row) => {
                    return Object.keys(this.columns).map((key) => {
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
                                item[key] = value.data.map(user => user.name);
                                break;

                            default:
                                item[key] = value;
                        }

                        return item;
                    });
                });
            }
        }
    };
</script>

<style>
    .tag {
        margin-bottom: 0.25em;
    }

    tr:hover {
        background-color: inherit;
    }
</style>

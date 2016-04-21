<template>
    <table class="table is-striped">
        <thead>
        <tr>
            <th v-for="column in columns">{{ column }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="section in sections">
            <td v-for="item in section">
                <!--If item is the users array. Need to find a better conditional-->
                <span v-if="typeof item == 'object'">
                    <span class="tag is-dark" v-for="user in item">
                        {{ user.name }}
                    </span>
                </span>

                <span v-else>
                    {{ item }}
                </span>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import sectionStore from '../stores/section';
    import { section as columns } from '../utils/table-columns'

    export default {
        data() {
            return {
                columns,
                sections: []
            }
        },

        created() {
            // A bit all over the place.
            // Formats the data properly.
            sectionStore.getAllSections((res) => {
                this.sections = res.data.map((section) => {
                    return Object.keys(this.columns).map((key) => {
                        const value = section[key];

                        switch (key) {
                            case 'semester':
                                return `${value.data.season} ${value.data.year}`;

                            case 'school':
                                return value.data.school;

                            case 'users':
                                return value.data;

                            default:
                                return value;
                        }
                    });
                });
            });
        },

        methods: {
        }
    }
</script>

<style scoped>
    .tag {
        margin-bottom: 0.25em;
    }

    tr:hover {
        background-color: inherit;
    }
</style>

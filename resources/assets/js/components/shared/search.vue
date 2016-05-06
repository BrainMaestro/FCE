<template>
    <p class="control has-addons">
        <span class="select">
            <select v-model="searchColumn">
                <option selected disabled value="">-- Column --</option>
                <option v-for="(column, columnText) in columns"
                        :value="column" :disabled="selectedColumns.includes(column)">
                    {{ columnText }}
                </option>
            </select>
        </span>
        <input class="input" type="text" placeholder="Find something exciting..." v-model="searchText">
        <a class="button" @click="addSearchPair" title="Add new pair"><i class="fa fa-plus-circle"></i></a>
        <a class="button is-info" @click="handleSearch">Search</a>
    </p>
    <div>
        <span class="tag is-dark" v-for="pair in searchString">
            {{ pair }}
            <button class="delete" @click="removeSearchPair(pair)"></button>
        </span>
    </div>
</template>

<script>
    import search from '../../stores/search';

    export default {
        props: {
            onSearch: {
                type: Function,
                required: true
            },
            model: {
                type: String,
                requried: true
            },
            columns: {
                type: Object,
                required: true
            },
            default: {
                type: Function,
                required: true
            }
        },

        data() {
            return {
                searchText: '',
                searchColumn: '',
                searchString: [],
                searchValues: {},
                selectedColumns: []
            };
        },

        methods: {
            handleSearch() {
                // No search values specified
                if (!this.searchString.length) {
                    return this.default(this.onSearch);
                }

                search(this.searchString.join(), this.searchValues, this.model, this.onSearch);
            },

            addSearchPair() {
                if (!this.searchText || !this.searchColumn) {
                    return;
                }

                this.searchString.push(`${this.searchColumn}:${this.searchText}`);
                this.selectedColumns.push(this.searchColumn);
                // Hack needed because vue-resource does string interpolation for the
                // ':' character. See https://github.com/vuejs/vue-resource/issues/164.
                this.searchValues[this.searchText] = `:${this.searchText}`;

                // Reset fields.
                this.searchText = '';
                this.searchColumn = '';
            },

            removeSearchPair(pair) {
                this.searchString = this.searchString.filter(searchPair => searchPair != pair);

                // Remove the column from the selected columns array.
                const pairColumn = pair.split(':')[0];
                this.selectedColumns = this.selectedColumns.filter(column => column != pairColumn)
            }
        }
    };
</script>

<style scoped>
    div {
        padding-bottom: 2em;
    }

    .tag {
        margin-right: 0.5em;
    }
</style>

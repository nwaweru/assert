<template>
    <div class="row">
        <div class="col">
            <br>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center"><b>Categories</b></h3>
                    <p class="text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal"><i class="fa fa-plus-circle"></i> New Category</a>
                    </p>
                    <div class="table-responsive">
                        <table id="users-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Log</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="category,key in categories">
                                    <td>{{ ++key }}</td>
                                    <td>{{ category.name }}</td>
                                    <td>{{ category.log }}</td>
                                    <td>
                                        <a href="#" class="card-link" data-toggle="modal" data-target="#showCategoryModal" v-on:click.prevent="getCategory(category.uuid)"><i class="fa fa-fw fa-eye"></i></a>
                                        <a href="#" class="card-link" data-toggle="modal" data-target="#editCategoryModal" v-on:click.prevent="getCategory(category.uuid)"><i class="fa fa-fw fa-edit"></i></a>
                                        <a href="#" class="card-link" data-toggle="modal" data-target="#deleteCategoryModal" v-on:click.prevent="getCategory(category.uuid)"><i class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <add-category-modal></add-category-modal>
            <show-category-modal></show-category-modal>
            <edit-category-modal></edit-category-modal>
            <delete-category-modal></delete-category-modal>
        </div>
    </div>
</template>

<script>
    const addCategoryModal = require('./modals/AddCategory.vue');
    const showCategoryModal = require('./modals/ShowCategory.vue');
    const editCategoryModal = require('./modals/EditCategory.vue');
    const deleteCategoryModal = require('./modals/DeleteCategory.vue');

    export default {
        components: {
            'add-category-modal': addCategoryModal,
            'show-category-modal': showCategoryModal,
            'edit-category-modal': editCategoryModal,
            'delete-category-modal': deleteCategoryModal
        },

        data: function () {
            return {
                categories: {},
                errors: {}
            };
        },

        methods: {
            async getCategories() {
                try {
                    let url = route('asset_categories.index');
                    const response = await axios.get(url);

                    this.categories = response.data.data;
                } catch (error) {
                    console.error(error);
                }
            },

            getCategory(uuid) {
                let url = route('asset_categories.show', {asset_category: uuid});

                axios.get(url).then((response) => {
                    let category = response.data.data;

                    this.$children[1].category = category;
                    this.$children[2].category = category;
                    this.$children[3].category = category;
                }).catch((error) => {
                    console.log(error);
                });
            }

        },

        mounted() {
            this.getCategories();
        }
    }
</script>

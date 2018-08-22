<template>
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel"><b>Edit Category</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent>
                        <div class="form-group">
                            <label for="name" v-bind:class="{'text-danger':errors.name}">Name</label>
                            <input type="text" class="form-control" v-bind:class="{'is-invalid':errors.name}" id="name" name="name" v-model="category.name" placeholder="e.g. Computers" v-focus>
                            <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="updateCategory">Update</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                category: {},
                errors: {}
            };
        },

        methods: {
            updateCategory() {
                let params = {
                    asset_category: this.category.uuid
                };

                let url = route('asset_categories.update', params);

                axios.patch(url, this.$data.category).then(() => {
                    this.$parent.getCategories();
                    $('#editCategoryModal').modal('toggle');
                }).catch((error) => {
                    this.errors = error.response.data.errors;
                });
            }
        }
    }
</script>

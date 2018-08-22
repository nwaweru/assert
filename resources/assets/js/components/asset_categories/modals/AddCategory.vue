<template>
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel"><b>New Category</b></h5>
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
                    <button type="button" class="btn btn-primary" v-on:click="saveCategory">Save</button>
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
            saveCategory() {
                let url = route('asset_categories.store');

                axios.post(url, this.$data.category).then(() => {
                    this.category = {};
                    this.errors = {};
                    this.$parent.getCategories();
                    $('#addCategoryModal').modal('toggle');
                }).catch((error) => {
                    if (error.response) {
                        this.errors = error.response.data.errors;
                        console.error(error.response.status);
                    } else if (error.request) {
                        console.error(error.request);
                    } else {
                        console.error('Error', error.message);
                    }
                });
            }
        }
    }
</script>

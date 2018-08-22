<template>
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Category</h5>
                    <br>
                    <div class="table-responsive">
                        <p>Are you sure you want to delete <b>{{ category.name }}</b>? <span class="text-danger">This cannot be undone.</span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" v-on:click.prevent="deleteCategory">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                category: {}
            };
        },

        methods: {
            deleteCategory() {
                let params = {
                    asset_category: this.category.uuid
                };

                let url = route('asset_categories.destroy', params);

                axios.delete(url).then(() => {
                    this.$parent.getCategories();
                    $('#deleteCategoryModal').modal('toggle');
                }).catch((error) => {
                    if (error.response) {
                        console.error('Error ' + error.response.status);
                    } else if (error.request) {
                        console.error(error.request);
                    } else {
                        console.error('Error: ' + error.message);
                    }
                });
            }
        }
    }
</script>
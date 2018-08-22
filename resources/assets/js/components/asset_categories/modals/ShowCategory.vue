<template>
    <div class="modal fade" id="showCategoryModal" tabindex="-1" role="dialog" aria-labelledby="showCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="showCategoryModalLabel">View Category</b></h5>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-right"><b>Name:</b></td>
                                <td>{{ category.name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                category: {}
            };
        }
    }
</script>
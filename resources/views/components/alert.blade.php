@if(session('alert'))
<div id="alert-component" class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show global-alert" role="alert">
    {{ session('alert')['message'] }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
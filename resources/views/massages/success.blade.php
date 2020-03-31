<!-- begin panel -->
@if(session()->has("success"))
<div class="alert alert-bordered alert-success alert-dismissible fade show text-white" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    <strong><i class="fa fa-check-circle"></i> Success!</strong> {{session()->get('success')}}
</div>
@endif

@if(session()->has("warning"))
<div class="alert alert-bordered alert-warning alert-dismissible fade show text-white" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    <strong><i class="fas fa-times-circle"></i> Warning!</strong> {{session()->get('warning')}}
</div>
@endif

<div class="reload-notification" style="position: absolute; top: 50px; right: 30px; z-index: 9999; display: inline-flex;">
    @if (session('success'))
    <div class="rounded alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between text-dark" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (session('error'))    
<div class="rounded alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-between text-dark" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
</div>
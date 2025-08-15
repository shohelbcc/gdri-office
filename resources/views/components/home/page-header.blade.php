<div id="pageHeader">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center">{{ $title ?? 'Page Title' }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title ?? 'Page Title' }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
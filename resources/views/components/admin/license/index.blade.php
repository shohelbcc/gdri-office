<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>Update License</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <form action="{{ route('admin.license.update', $license->id) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $license->name }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content">{{ $license->content }}</textarea>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('#content').summernote({height: 300});
    </script>
@endpush
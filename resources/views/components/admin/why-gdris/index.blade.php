<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>Update Why GDRI</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <form action="{{ route('admin.why-gdri.update', $whyGdri->id) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <textarea class="form-control" id="title" name="title">{{ $whyGdri->title }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ $whyGdri->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('#title').summernote({height: 100});
        $('#description').summernote({height: 300});
    </script>
@endpush
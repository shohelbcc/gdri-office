<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>Update Our Stories</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <form action="{{ route('admin.our-story.update', $ourStory->id) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ $ourStory->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('#description').summernote({height: 300});
    </script>
@endpush
<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="min-width: 600px !important">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Post</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    @csrf
                    <div class="container">
                        <div class="row">
                            
                            <div class="col-md-12 mb-3">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Post Title">
                                <small id="titleError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Excerpt</label>
                                <textarea class="form-control" id="excerpt" rows="2"
                                    placeholder="Short summary"></textarea>
                                <small id="excerptError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Content <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="content" rows="4"></textarea>
                                <small id="contentError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Blog Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="blog_category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <small id="blog_category_idError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="authors" class="form-label">Authors</label>
                                <select id="authors" name="authors[]" class="form-select" multiple
                                    placeholder="Select Authors">
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                                <small id="authorsError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select class="form-select" id="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                                <small id="statusError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Published At</label>
                                <input type="date" class="form-control" id="published_at">
                                <small id="published_atError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <select id="tags" name="tags[]" class="form-select" multiple placeholder="Select tags">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                <small id="tagsError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="featured_image">Featured Image <span class="text-danger">*</span></label>
                                <div class="d-flex justify-content-center align-items-center bg-dark mb-1">

                                    <img id="featured_imageHolder" src="{{ asset('images/default.png') }}"
                                        alt="Defauld Image" class="p-2 d-block" style="width: 150px; height: auto;">
                                </div>
                                <input id="featured_image" name="featured_image"
                                    oninput="featured_imageHolder.src=window.URL.createObjectURL(this.files[0])"
                                    type="file" class="form-control">
                                <small id="featured_imageError" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="button" onclick="Save()" id="save-btn" class="btn btn-sm btn_green">Save
                        Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        // ─── Initialize Summernote ─────────────────────────────────────────────────
        $(document).ready(function () {
            $('#excerpt').summernote({
                height: 100,
                // toolbar: [
                //     ['style', ['bold', 'italic', 'underline', 'clear']],
                //     ['para', ['ul', 'ol', 'paragraph']],
                //     ['misc', ['undo', 'redo']]
                // ]
            });
            $('#content').summernote({
                height: 150,
                // toolbar: [
                //     ['style', ['bold', 'italic', 'underline', 'clear']],
                //     ['font', ['fontsize', 'color', 'fontname']],
                //     ['para', ['ul', 'ol', 'paragraph']],
                //     ['insert', ['link', 'picture', 'video']],
                //     ['misc', ['undo', 'redo']]
                // ]
            });
        });

        // ─── Initialize Tom Select for multi-selects ─────────────────────────────
        // Note: Tom Select works out-of-the-box in Bootstrap modals without needing dropdownParent.
        new TomSelect("#tags", {
            plugins: ['remove_button'],
            create: false,
            placeholder: "Select tags"
        });

        new TomSelect("#authors", {
            plugins: ['remove_button'],
            create: false,
            placeholder: "Select authors"
        });


        // ─── Save( ) Function: Gather all fields & send via Axios ─────────────────
        async function Save() {
            try {

                let formData = new FormData();
                formData.append('title', $("#title").val());
                formData.append('excerpt', $('#excerpt').summernote('code'));
                formData.append('content', $('#content').summernote('code'));
                formData.append('blog_category_id', $('#blog_category_id').val());
                formData.append('status', $('#status').val());
                formData.append('published_at', $('#published_at').val());

                // 2a) Authors (Tom Select multi-select) → array of IDs
                let selectedAuthors = $('#authors').val() || [];
                selectedAuthors.forEach((authorId, idx) => {
                    formData.append(`authors[${idx}]`, authorId);
                });

                // 2b) Tags (Tom Select multi-select) → array of IDs
                let selectedTags = $('#tags').val() || [];
                selectedTags.forEach((tagId, idx) => {
                    formData.append(`tags[${idx}]`, tagId);
                });

                // 2c) Featured Image (File input)
                let fileInput = $('#featured_image')[0];
                if (fileInput.files.length > 0) {
                    formData.append('featured_image', fileInput.files[0]);
                }

                // 3) Send POST request
                let res = await axios.post('/admin/blog/post/store', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });

                // let res = await axios.post('/admin/blog/tag/store', formData)

                if (res.status === 200) {
                    $("#modal_close").click();
                    $('#save-form')[0].reset();
                    $('#excerpt').summernote('reset');
                    $('#content').summernote('reset');
                    $('#tags')[0].tomselect.clear();
                    $('#authors')[0].tomselect.clear();
                    $('#featured_imageHolder').attr('src', "{{ asset('images/default.png') }}");
                    // document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#titleError').text('');
                    $('#excerptError').text('');
                    $('#contentError').text('');
                    $('#blog_category_idError').text('');
                    $('#authorsError').text('');
                    $('#statusError').text('');
                    $('#published_atError').text('');
                    $('#tagsError').text('');
                    $('#featured_imageError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ? errors.title[0] : '');
                    $('#excerError').text(errors.excer ? errors.excer[0] : '');
                    $('#contentError').text(errors.content ? errors.content[0] : '');
                    $('#blog_category_idError').text(errors.blog_category_id ? errors.blog_category_id[0] : '');
                    $('#authorsError').text(errors.authors ? errors.authors[0] : '');
                    $('#statusError').text(errors.status ? errors.status[0] : '');
                    $('#published_atError').text(errors.published_at ? errors.published_at[0] : '');
                    $('#featured_imageError').text(errors.featured_image ? errors.featured_image[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush
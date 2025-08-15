<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Tag</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="container">
                        <div class="row">

                            <input type="hidden" id="updateId">
                            <input type="hidden" id="filePath">

                            <div class="col-md-12 mb-3">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="titleUpdate">
                                <small id="titleUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Excerpt</label>
                                <textarea class="form-control" id="excerptUpdate" rows="2"></textarea>
                                <small id="excerptUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Content <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="contentUpdate" rows="4"></textarea>
                                <small id="contentUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Blog Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="blog_category_idUpdate">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <small id="blog_category_idUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="authorsUpdate" class="form-label">Authors</label>
                                <select id="authorsUpdate" name="authorsUpdate[]" class="form-select" multiple>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                                <small id="authorsUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select class="form-select" id="statusUpdate">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                                <small id="statusUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Published At</label>
                                <input type="date" class="form-control" id="published_atUpdate">
                                <small id="published_atUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="tagsUpdate" class="form-label">Tags</label>
                                <select id="tagsUpdate" name="tagsUpdate[]" class="form-select" multiple>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                <small id="tagsUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="featured_image">Featured Image <span class="text-danger">*</span></label>
                                <div class="d-flex justify-content-center align-items-center bg-dark mb-1">

                                    <img id="oldFeatured_imageHolder" src="{{ asset('images/default.png') }}"
                                        alt="Defauld Image" class="p-2 d-block" style="width: 150px; height: auto;">
                                </div>
                                <input id="featured_imageUpdate" name="featured_imageUpdate"
                                    oninput="oldFeatured_imageHolder.src=window.URL.createObjectURL(this.files[0])"
                                    type="file" class="form-control">
                                <small id="featured_imageUpdateError" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="update_modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button onclick="Update()" id="update-btn" class="btn btn-sm btn_green">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>




@push('scripts')
    <script>
        // ─── Initialize Summernote ─────────────────────────────────────────────────
        $(document).ready(function () {
            $('#excerptUpdate').summernote({ height: 100 });
            $('#contentUpdate').summernote({ height: 150 });
        });

        // ─── Initialize Tom Select for multi-selects ─────────────────────────────
        // Note: Tom Select works out-of-the-box in Bootstrap modals without needing dropdownParent.
        new TomSelect("#tagsUpdate", { plugins: ['remove_button'], create: false });
        new TomSelect("#authorsUpdate", { plugins: ['remove_button'], create: false });

        async function FillUpUpdateForm(id, filePath) {
            try {
                $('#updateId').val(id);
                $('#filePath').val(filePath);
                $('#oldFeatured_imageHolder').attr('src', filePath);

                let res = await axios.post("/admin/blog/post/by-id", { id: id })
                let row = res.data.row

                $('#titleUpdate').val(row.title);
                $('#excerptUpdate').summernote('code', row.excerpt);
                $('#contentUpdate').summernote('code', row.content);
                $('#blog_category_idUpdate').val(row.blog_category_id);
                $('#statusUpdate').val(row.status);
                $('#published_atUpdate').val(row.published_at);

                let authorsSelect = document.querySelector('#authorsUpdate').tomselect;
                authorsSelect.setValue(row.authors.map(a => a.id));

                let tagsSelect = document.querySelector('#tagsUpdate').tomselect;
                tagsSelect.setValue(row.tags.map(t => t.id));

            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();
                formData.append('title', $('#titleUpdate').val());
                formData.append('excerpt', $('#excerptUpdate').val());
                formData.append('content', $('#contentUpdate').val());
                formData.append('blog_category_id', $('#blog_category_idUpdate').val());
                formData.append('status', $('#statusUpdate').val());
                formData.append('published_at', $('#published_atUpdate').val());
                formData.append('filePath', $('#filePath').val());

                let authors = $('#authorsUpdate').val();
                authors.forEach(id => formData.append('authors[]', id));

                let tags = $('#tagsUpdate').val();
                tags.forEach(id => formData.append('tags[]', id));

                let fileInput = $('#featured_imageUpdate')[0];
                if (fileInput.files.length > 0) {
                    formData.append('featured_image', fileInput.files[0]);
                }

                formData.append('updateId', $('#updateId').val())

                // 3) Send POST request
                let res = await axios.post('/admin/blog/post/update', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                // let res = await axios.post('/admin/blog/post/update', formData)

                if (res.status === 200) {
                $('#update_modal_close').click();
                $('#update_form')[0].reset();
                    successToast(res.data['message']);
                    // $('#nameUpdateError').text('');
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleUpdateError').text(errors.title ? errors.title[0] : '');
                    $('#excerptUpdateError').text(errors.excerpt ? errors.excerpt[0] : '');
                    $('#contentUpdateError').text(errors.content ? errors.content[0] : '');
                    $('#blog_category_idUpdateError').text(errors.blog_category_id ? errors.blog_category_id[0] : '');
                    $('#authorsUpdateError').text(errors.authors ? errors.authors[0] : '');
                    $('#tagsUpdateError').text(errors.tags ? errors.tags[0] : '');
                    $('#statusUpdateError').text(errors.status ? errors.status[0] : '');
                    $('#published_atUpdateError').text(errors.published_at ? errors.published_at[0] : '');
                    $('#featured_imageUpdateError').text(errors.featured_image ? errors.featured_image[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }


        }

    </script>

@endpush
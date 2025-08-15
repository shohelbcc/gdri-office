<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Publication</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Title <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Title"
                                    value="{{ old('title') }}">
                                <small id="titleError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description <span class="text-danger ml-1">*</span></label>
                                <textarea id="description" class="form-control"></textarea>
                                <small id="descriptionError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Authors <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="authors" placeholder="Authors"
                                    value="{{ old('authors') }}">
                                <small id="authorsError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Published Year <span class="text-danger ml-1">*</span></label>
                                <input type="number" class="form-control" id="publishedYear" placeholder="Published Year"
                                    value="{{ old('published_year') }}" min="1900" max="{{ date('Y') }}">
                                <small id="publishedYearError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Paper Type <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="paperType" placeholder="Paper Type"
                                    value="{{ old('paper_type') }}">
                                <small id="paperTypeError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Link <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="link" placeholder="Link"
                                    value="{{ old('link') }}">
                                <small id="linkError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project Topic <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="projectTopic">
                                    <option value="active">--- Select Project Topic ---</option>
                                    @foreach($projectTopics as $projectTopic)
                                        <option value="{{ $projectTopic->id }}">{{ $projectTopic->name }}</option>
                                    @endforeach
                                </select>
                                <small id="projectTopicError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Publication Type <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="publicationType">
                                    <option value="active">--- Select Publication Type ---</option>
                                    @foreach($publicationTypes as $publicationType)
                                        <option value="{{ $publicationType->id }}">{{ $publicationType->name }}</option>
                                    @endforeach
                                </select>
                                <small id="publicationTypeError" class="text-danger"></small>
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
        $(document).ready(function () {
            $('#description').summernote({ height: 100 });
        });

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('title', $("#title").val());

                let isEmpty = $('#description').summernote('isEmpty');
                let descriptionHtml = isEmpty ? '' : $('#description').summernote('code');
                formData.append('description', descriptionHtml);

                formData.append('authors', $("#authors").val());
                formData.append('published_year', $("#publishedYear").val());
                formData.append('paper_type', $("#paperType").val());
                formData.append('link', $("#link").val());
                formData.append('project_topic_id', $("#projectTopic").val());
                formData.append('publication_type_id', $("#publicationType").val());

                let res = await axios.post('/admin/publication/store', formData);

                if (res.status === 200) {
                    $("#create_modal").modal('hide');
                    $('#description').summernote('reset');
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#titleError').text('');
                    $('#descriptionError').text('');
                    $('#authorsError').text('');
                    $('#publishedYearError').text('');
                    $('#paperTypeError').text('');
                    $('#linkError').text('');
                    $('#projectTopicError').text('');
                    $('#publicationTypeError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ? errors.title[0] : '');
                    $('#descriptionError').text(errors.description ? errors.description[0] : '');
                    $('#authorsError').text(errors.authors ? errors.authors[0] : '');
                    $('#publishedYearError').text(errors.published_year ? errors.published_year[0] : '');
                    $('#paperTypeError').text(errors.paper_type ? errors.paper_type[0] : '');
                    $('#linkError').text(errors.link ? errors.link[0] : '');
                    $('#projectTopicError').text(errors.project_topic ? errors.project_topic_id[0] : '');
                    $('#publicationTypeError').text(errors.publication_type ? errors.publication_type_id[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush
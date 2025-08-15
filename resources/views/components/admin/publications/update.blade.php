<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Publication</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="container">
                        <div class="row">

                            <input type="hidden" id="updateId">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Title <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="titleUpdate" placeholder="Title"
                                    value="{{ old('title') }}">
                                <small id="titleUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description <span class="text-danger ml-1">*</span></label>
                                <textarea id="descriptionUpdate" class="form-control"></textarea>
                                <small id="descriptionUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Authors <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="authorsUpdate" placeholder="Authors"
                                    value="{{ old('authors') }}">
                                <small id="authorsUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Published Year <span class="text-danger ml-1">*</span></label>
                                <input type="number" class="form-control" id="publishedYearUpdate" placeholder="Published Year"
                                    value="{{ old('published_year') }}" min="1900" max="{{ date('Y') }}">
                                <small id="publishedYearUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Paper Type <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="paperTypeUpdate" placeholder="Paper Type"
                                    value="{{ old('paper_type') }}">
                                <small id="paperTypeUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Link <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="linkUpdate" placeholder="Link"
                                    value="{{ old('link') }}">
                                <small id="linkUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project Topic <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="projectTopicUpdate">
                                    <option value="active">--- Select Project Topic ---</option>
                                    @foreach($projectTopics as $projectTopic)
                                        <option value="{{ $projectTopic->id }}">{{ $projectTopic->name }}</option>
                                    @endforeach
                                </select>
                                <small id="projectTopicUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Publication Type <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="publicationTypeUpdate">
                                    <option value="active">--- Select Publication Type ---</option>
                                    @foreach($publicationTypes as $publicationType)
                                        <option value="{{ $publicationType->id }}">{{ $publicationType->name }}</option>
                                    @endforeach
                                </select>
                                <small id="publicationTypeUpdateError" class="text-danger"></small>
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

        $(document).ready(function () {
            $('#detailsUpdate').summernote({ height: 100 });
        });

        async function FillUpUpdateForm(id) {
            try {

                $('#updateId').val(id);
                let res = await axios.post("/admin/publication/by-id", { id: id })
                $('#titleUpdate').val(res.data.data.title);
                $('#descriptionUpdate').summernote('code', res.data.data.description);
                $('#authorsUpdate').val(res.data.data.authors);
                $('#publishedYearUpdate').val(res.data.data.published_year);
                $('#paperTypeUpdate').val(res.data.data.paper_type);
                $('#linkUpdate').val(res.data.data.link);
                $('#projectTopicUpdate').val(res.data.data.project_topic_id);
                $('#publicationTypeUpdate').val(res.data.data.publication_type_id);
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();
                formData.append('title', $("#titleUpdate").val());
                let isEmpty = $('#descriptionUpdate').summernote('isEmpty');
                let descriptionHtml = isEmpty ? '' : $('#descriptionUpdate').summernote('code');
                formData.append('description', descriptionHtml);
                formData.append('authors', $("#authorsUpdate").val());
                formData.append('published_year', $("#publishedYearUpdate").val());
                formData.append('paper_type', $("#paperTypeUpdate").val());
                formData.append('link', $("#linkUpdate").val());
                formData.append('project_topic_id', $("#projectTopicUpdate").val());
                formData.append('publication_type_id', $("#publicationTypeUpdate").val());
                formData.append('id', $('#updateId').val());

                let res = await axios.post('/admin/publication/update', formData);

                if (res.status === 200) {
                    $("#update_modal").modal('hide');
                    document.getElementById("update_form").reset();
                    $('#titleUpdate').val('');
                    $('#descriptionUpdate').summernote('reset');
                    $('#authorsUpdate').val('');
                    $('#publishedYearUpdate').val('');
                    $('#paperTypeUpdate').val('');
                    $('#linkUpdate').val('');
                    $('#projectTopicUpdate').val('');
                    $('#publicationTypeUpdate').val('');
                    successToast(res.data['message']);
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleUpdateError').text(errors.title ? errors.title[0] : '');
                    $('#descriptionUpdateError').text(errors.description ? errors.description[0] : '');
                    $('#authorsUpdateError').text(errors.authors ? errors.authors[0] : '');
                    $('#publishedYearUpdateError').text(errors.published_year ? errors.published_year[0] : '');
                    $('#paperTypeUpdateError').text(errors.paper_type ? errors.paper_type[0] : '');
                    $('#linkUpdateError').text(errors.link ? errors.link[0] : '');
                    $('#projectTopicUpdateError').text(errors.project_topic ? errors.project_topic_id[0] : '');
                    $('#publicationTypeUpdateError').text(errors.publication_type ? errors.publication_type_id[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }
        }

    </script>

@endpush
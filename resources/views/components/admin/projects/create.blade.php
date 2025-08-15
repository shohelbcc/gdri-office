<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Project</h6>
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
                                <label class="form-label">Details <span class="text-danger ml-1">*</span></label>
                                <textarea id="details" class="form-control"></textarea>
                                <small id="detailsError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date <span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="startDate" placeholder="Start Date"
                                    value="{{ old('start_date') }}">
                                <small id="startDateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date <span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="endDate" placeholder="End Date"
                                    value="{{ old('end_date') }}">
                                <small id="endDateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="featuredImage" class="form-label">Featured Image <span class="text-danger ml-1">*</span></label>
                                <div class="d-flex justify-content-center align-items-center bg-dark mb-1">
                                    <img id="featuredImageview" src="{{ asset('images/default.png') }}" alt="Defauld Image" class="p-2 d-block" style="width: 150px; height: auto;">
                                </div>
                                <input name="featuredImage" id="featuredImage"
                                    oninput="featuredImageview.src=window.URL.createObjectURL(this.files[0])"
                                    type="file" class="form-control">
                                <small id="featuredImageError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Study Area <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="studyArea" placeholder="Study Area"
                                    value="{{ old('study_area') }}">
                                <small id="studyAreaError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="status">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                <small id="statusError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Partner <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="partner" multiple>
                                    <option value="active">--- Select Partner ---</option>
                                    @foreach($partners as $partner)
                                        <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                    @endforeach
                                </select>
                                <small id="partnerError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Topic <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="topic" multiple>
                                    <option value="active">--- Select Topic ---</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                                <small id="topicError" class="text-danger"></small>
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
            $('#details').summernote({ height: 100 });
            new TomSelect("#partner", {
                plugins: ['remove_button'],
            });
            new TomSelect("#topic", {
                plugins: ['remove_button'],
            });
        });

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('title', $("#title").val());

                let isEmpty = $('#details').summernote('isEmpty');
                let detailsHtml = isEmpty ? '' : $('#details').summernote('code');
                formData.append('details', detailsHtml);

                formData.append('featured_image', $("#featuredImage").prop('files')[0]);
                formData.append('start_date', $("#startDate").val());
                formData.append('end_date', $("#endDate").val());
                formData.append('study_area', $("#studyArea").val());

                formData.append('status', $("#status").val());

                // Partners should be an array
                let partners = $("#partner").val() || [];
                partners.forEach(pid => formData.append('partners[]', pid));

                // Topics should be an array
                let topics = $("#topic").val() || [];
                topics.forEach(tid => formData.append('topics[]', tid));

                let res = await axios.post('/admin/project/store', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });

                if (res.status === 200) {
                    $("#create_modal").modal('hide');
                    $('#details').summernote('reset');
                    $('#featuredImageview').attr('src', '{{ asset('images/default.png') }}');
                    document.getElementById("save-form").reset();
                    // TomSelect instance reset
                    if ($('#partner')[0].tomselect) $('#partner')[0].tomselect.clear();
                    if ($('#topic')[0].tomselect) $('#topic')[0].tomselect.clear();
                    successToast(res.data['message']);
                    $('#titleError').text('');
                    $('#detailsError').text('');
                    $('#startDateError').text('');
                    $('#endDateError').text('');
                    $('#featuredImageError').text('');
                    $('#studyAreaError').text('');
                    $('#partnerError').text('');
                    $('#topicError').text('');
                    $('#statusError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ? errors.title[0] : '');
                    $('#detailsError').text(errors.details ? errors.details[0] : '');
                    $('#startDateError').text(errors.start_date ? errors.start_date[0] : '');
                    $('#endDateError').text(errors.end_date ? errors.end_date[0] : '');
                    $('#featuredImageError').text(errors.featured_image ? errors.featured_image[0] : '');
                    $('#studyAreaError').text(errors.study_area ? errors.study_area[0] : '');
                    $('#partnerError').text(errors.partners ? errors.partners[0] : '');
                    $('#topicError').text(errors.topics ? errors.topics[0] : '');
                    $('#statusError').text(errors.status ? errors.status[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush
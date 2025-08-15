<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Project</h6>
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
                                <label class="form-label">Details <span class="text-danger ml-1">*</span></label>
                                <textarea id="detailsUpdate" class="form-control"></textarea>
                                <small id="detailsUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date <span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="startDateUpdate" placeholder="Start Date"
                                    value="{{ old('start_date') }}">
                                <small id="startDateUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date <span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="endDateUpdate" placeholder="End Date"
                                    value="{{ old('end_date') }}">
                                <small id="endDateUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="featuredImage" class="form-label">Featured Image <span class="text-danger ml-1">*</span></label>
                                <div class="d-flex justify-content-center align-items-center bg-dark mb-1">
                                    <img id="featuredImageviewUpdate" src="{{ asset('images/default.png') }}" alt="Defauld Image" class="p-2 d-block" style="width: 150px; height: auto;">
                                </div>
                                <input name="featuredImageUpdate" id="featuredImageUpdate"
                                    oninput="featuredImageviewUpdate.src=window.URL.createObjectURL(this.files[0])"
                                    type="file" class="form-control">
                                <small id="featuredImageUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Study Area <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="studyAreaUpdate" placeholder="Study Area"
                                    value="{{ old('study_area') }}">
                                <small id="studyAreaUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="statusUpdate">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                <small id="statusUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Partner <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="partnerUpdate" multiple>
                                    <option value="active">--- Select Partner ---</option>
                                    @foreach($partners as $partner)
                                        <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                    @endforeach
                                </select>
                                <small id="partnerUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Topic <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="topicUpdate" multiple>
                                    <option value="active">--- Select Topic ---</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                                <small id="topicUpdateError" class="text-danger"></small>
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
            new TomSelect("#partnerUpdate", {
                plugins: ['remove_button'],
            });
            new TomSelect("#topicUpdate", {
                plugins: ['remove_button'],
            });
        });

        async function FillUpUpdateForm(id) {
            try {

                $('#updateId').val(id);
                let res = await axios.post("/admin/project/by-id", { id: id })

                if ($('#partnerUpdate')[0].tomselect) {
                    $('#partnerUpdate')[0].tomselect.setValue(res.data.data.partners ?? []);
                }
                if ($('#topicUpdate')[0].tomselect) {
                    $('#topicUpdate')[0].tomselect.setValue(res.data.data.topics ?? []);
                }
                $('#titleUpdate').val(res.data.data.title);
                $('#detailsUpdate').summernote('code', res.data.data.details);
                $('#startDateUpdate').val(res.data.data.start_date ? res.data.data.start_date.substring(0, 10) : '');
                $('#endDateUpdate').val(res.data.data.end_date ? res.data.data.end_date.substring(0, 10) : '');
                $('#studyAreaUpdate').val(res.data.data.study_area ? res.data.data.study_area : '');
                $('#featuredImageviewUpdate').attr('src', res.data.data.featured_image ? res.data.data.featured_image : '{{ asset("default.png") }}');
                $('#statusUpdate').val(res.data.data.status);
                $('#statusUpdate').trigger('change');
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();
                formData.append('title', $("#titleUpdate").val());

                // Details
                let isEmptyDetails = $('#detailsUpdate').summernote('isEmpty');
                let detailsHtml = isEmptyDetails ? '' : $('#detailsUpdate').summernote('code');
                formData.append('details', detailsHtml);

                formData.append('start_date', $("#startDateUpdate").val());
                formData.append('end_date', $("#endDateUpdate").val());
                formData.append('study_area', $("#studyAreaUpdate").val());

                // Featured Image file (check if file selected)
                let featuredImageFile = $("#featuredImageUpdate").prop('files')[0];
                if (featuredImageFile) {
                    formData.append('featured_image', featuredImageFile);
                }

                // Partners (multiple select)
                let partners = $("#partnerUpdate").val() || [];
                partners.forEach(pid => formData.append('partners[]', pid));

                // Topics (multiple select)
                let topics = $("#topicUpdate").val() || [];
                topics.forEach(tid => formData.append('topics[]', tid));

                formData.append('status', $("#statusUpdate").val());
                formData.append('id', $('#updateId').val());

                let res = await axios.post('/admin/project/update', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });

                if (res.status === 200) {
                    $("#update_modal").modal('hide');
                    document.getElementById("update_form").reset();
                    $('#descriptionUpdate').summernote('code', '');
                    $('#featuredImageviewUpdate').attr('src', '{{ asset("images/default.png") }}');
                    // TomSelect instance reset                
                    if ($('#partnerUpdate')[0].tomselect) $('#partnerUpdate')[0].tomselect.clear();
                    if ($('#topicUpdate')[0].tomselect) $('#topicUpdate')[0].tomselect.clear();
                    $('#titleUpdateError').text('');
                    $('#descriptionUpdateError').text('');
                    $('#featuredImageUpdateError').text('');
                    $('#startDateUpdateError').text('');
                    $('#endDateUpdateError').text('');
                    $('#studyAreaUpdateError').text('');
                    $('#partnerUpdateError').text('');
                    $('#topicUpdateError').text('');
                    $('#statusUpdateError').text('');
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
                    $('#featuredImageviewUpdateError').text(errors.featured_image ? errors.featured_image[0] : '');
                    $('#startDateUpdateError').text(errors.start_date ? errors.start_date[0] : '');
                    $('#endDateUpdateError').text(errors.end_date ? errors.end_date[0] : '');
                    $('#studyAreaUpdateError').text(errors.study_area ? errors.study_area[0] : '');
                    $('#partnerUpdateError').text(errors.partner_id ? errors.partner_id[0] : '');
                    $('#topicUpdateError').text(errors.topic_id ? errors.topic_id[0] : '');
                    $('#statusUpdateError').text(errors.status ? errors.status[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }
        }

    </script>

@endpush
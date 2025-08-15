<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Service</h6>
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

                            <div class="col-md-12 mb-3">
                                <label for="banner" class="form-label">Banner <span class="text-danger ml-1">*</span></label>
                                <div class="d-flex justify-content-center align-items-center bg-dark mb-1">
                                    <img id="bannerview" src="{{ asset('images/default.png') }}" alt="Defauld Image" class="p-2 d-block" style="width: 150px; height: auto;">
                                </div>
                                <input name="banner" id="banner" oninput="bannerview.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control">
                                <small id="bannerError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Status <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="status">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                <small id="statusError" class="text-danger"></small>
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

                formData.append('banner', $("#banner").prop('files')[0]);

                formData.append('status', $("#status").val());

                let res = await axios.post('/admin/services/store', formData)

                if (res.status === 200) {
                    $("#create_modal").modal('hide');
                    $('#description').summernote('reset');
                    $('#bannerview').attr('src', '{{ asset('images/default.png') }}');
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#titleError').text('');
                    $('#descriptionError').text('');
                    $('#bannerError').text('');
                    $('#statusError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ? errors.title[0] : '');
                    $('#descriptionError').text(errors.description ? errors.description[0] : '');
                    $('#bannerError').text(errors.banner ? errors.banner[0] : '');
                    $('#statusError').text(errors.status ? errors.status[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush
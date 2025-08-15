<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Impact Story</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::id() }}">

                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label>Title <span class="text-danger">*</span></label>
                            <textarea id="title"></textarea>
                            <small id="titleError" class="text-danger"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea id="description"></textarea>
                            <small id="descriptionError" class="text-danger"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Reference <span class="text-danger">*</span></label>
                            <textarea id="reference"></textarea>
                            <small id="referenceError" class="text-danger"></small>
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
            $('#title').summernote({ height: 100 });
            $('#description').summernote({ height: 200 });
            $('#reference').summernote({ height: 100 });
        });

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('title', $("#title").val());
                formData.append('description', $("#description").val());
                formData.append('reference', $("#reference").val());

                let res = await axios.post('/admin/impact-stories/store', formData)

                if (res.status === 200) {
                    $("#create_modal").modal('hide');
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#titleError').text('');
                    $('#descriptionError').text('');
                    $('#referenceError').text('');
                    await getList()
                } else {
                    errorToast(res.data.message || 'Unknown response status');
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ? errors.title?.[0] : '');
                    $('#descriptionError').text(errors.description ? errors.description?.[0] : '');
                    $('#referenceError').text(errors.reference ? errors.reference?.[0] : '');
                } else {
                    errorToast(error.response.data['message'] || `Server returned ${error.response.status}`);
                }
            }

        }
    </script>
@endpush
<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Topic</h6>
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
                                <input type="text" class="form-control" id="title" placeholder="Title" value="{{ old('title') }}">
                                <small id="titleError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Content <span class="text-danger ml-1">*</span></label>
                                <textarea id="content" class="form-control" placeholder="Content">{{ old('content') }}</textarea>
                                <small id="contentError" class="text-danger"></small>
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
        $('#content').summernote({height: 100});

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('title', $("#title").val());
                formData.append('content', $("#content").val());

                let res = await axios.post('/admin/home/accordian/store', formData)

                if (res.status === 200) {
                    $("#create_modal").modal('hide');
                    $('#content').summernote('reset');
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#titleError').text('');
                    $('#contentError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ? errors.title[0] : '');
                    $('#contentError').text(errors.content ? errors.content[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush
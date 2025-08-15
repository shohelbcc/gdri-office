<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Notice</h6>
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

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Published At <span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="published_at" placeholder="Published At"
                                    value="{{ old('published_at') }}">
                                <small id="published_atError" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="button" onclick="Save()" id="save-btn" class="btn btn-sm btn_green">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#details').summernote({ height: 100 });
        });

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('title', $("#title").val());
                formData.append('published_at', $("#published_at").val());

                let isEmpty = $('#details').summernote('isEmpty');
                let detailsHtml = isEmpty ? '' : $('#details').summernote('code');

                formData.append('details', detailsHtml);
                
                let res = await axios.post('/admin/notice/store', formData)

                if (res.status === 200) {
                    $("#modal_close").click();
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#titleError').text('');
                    $('#detailsError').text('');
                    $('#published_atError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ? errors.title[0] : '');
                    $('#detailsError').text(errors.details ? errors.details[0] : '');
                    $('#published_atError').text(errors.published_at ? errors.published_at[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush

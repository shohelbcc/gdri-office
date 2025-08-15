<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="min-width: 600px !important">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Category</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Name<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}">
                                <small id="nameError" class="text-danger"></small>
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

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('name', $("#name").val());

                let res = await axios.post('/admin/blog/category/store', formData)

                if (res.status === 200) {
                    $("#modal_close").click();
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#nameError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#nameError').text(errors.name ? errors.name[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush

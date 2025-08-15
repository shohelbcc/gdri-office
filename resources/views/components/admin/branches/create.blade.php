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
                                <label class="form-label">Name <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}">
                                <small id="nameError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Location <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="location" placeholder="Location" value="{{ old('location') }}">
                                <small id="locationError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Phone <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="phone" placeholder="Phone" value="{{ old('phone') }}">
                                <small id="phoneError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}">
                                <small id="emailError" class="text-danger"></small>
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

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('name', $("#name").val());
                formData.append('location', $("#location").val());
                formData.append('phone', $("#phone").val());
                formData.append('email', $("#email").val());

                let res = await axios.post('/admin/branch/store', formData)

                if (res.status === 200) {
                    $("#create_modal").modal('hide');
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#nameError').text('');
                    $('#locationError').text('');
                    $('#phoneError').text('');
                    $('#emailError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#nameError').text(errors.name ? errors.name[0] : '');
                    $('#locationError').text(errors.location ? errors.location[0] : '');
                    $('#phoneError').text(errors.phone ? errors.phone[0] : '');
                    $('#emailError').text(errors.email ? errors.email[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush
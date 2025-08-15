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
                                <label class="form-label">District <span class="text-danger ml-1">*</span></label>
                                <select name="names[]" id="names" class="form-select" multiple>
                                    <option value="">Select District</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->name }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                                <small id="nameError" class="text-danger"></small>
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

    new TomSelect("#names", {
        plugins: ['remove_button'],
        create: false,
    });

        async function Save() {
            try {
                let formData = new FormData();
                let names = $("#names").val() || [];
                names.forEach(name => formData.append('names[]', name));

                let res = await axios.post('/admin/district/coverage/store', formData);

                if (res.status === 200) {
                    $("#create_modal").modal('hide');
                    if ($('#names')[0].tomselect) $('#names')[0].tomselect.clear();
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#namesError').text('');
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#namesError').text(errors.names ? errors.names[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }
        }
    </script>
@endpush
<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Partner</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Certificate Number <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="certificate_number" placeholder="Certificate Number"
                                    value="{{ old('certificate_number') }}">
                                <small id="certificate_numberError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="certificate" class="form-label d-block">Upload Certificate <span class="text-danger ml-1">*</span>
                                    <div class="d-flex justify-content-center align-items-center bg-dark mb-1">
                                        <img id="certificateview" src="{{ asset('images/default.png') }}" alt="Defauld Image" class="p-2 d-block" style="width: 150px; height: auto;">
                                    </div>
                                </label>
                                
                                <input name="certificate" id="certificate" oninput="certificateview.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control">
                                <small id="certificateError" class="text-danger"></small>
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
                formData.append('certificate_number', $("#certificate_number").val());

                formData.append('certificate', $("#certificate").prop('files')[0]);

                let res = await axios.post('/admin/experience-certificates/store', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });

                if (res.status === 200) {
                    $("#create_modal").modal('hide');
                    $('#certificateview').attr('src', '{{ asset('images/default.png') }}');
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#certificate_numberError').text('');
                    $('#certificateError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#certificate_numberError').text(errors.certificate_number ? errors.certificate_number[0] : '');
                    $('#certificateError').text(errors.certificate ? errors.certificate[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush
<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Partner</h6>
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
                                <label class="form-label">Certificate Number <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="certificate_numberUpdate" placeholder="Certificate Number"
                                    value="{{ old('certificate_number') }}">
                                <small id="certificate_numberUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="certificateUpdate" class="form-label d-block">Upload Certificate <span class="text-danger ml-1">*</span>
                                    <div class="d-flex justify-content-center align-items-center bg-dark mb-1">
                                        <img id="certificateviewUpdate" src="{{ asset('images/default.png') }}" alt="Defauld Image" class="p-2 d-block" style="width: 150px; height: auto;">
                                    </div>
                                </label>
                                
                                <input name="certificateUpdate" id="certificateUpdate" oninput="certificateviewUpdate.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control">
                                <small id="certificateUpdateError" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="update_modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Update()" id="update-btn" class="btn btn-sm btn_green">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>




@push('scripts')
<script>

    async function FillUpUpdateForm(id){
        try {

            $('#updateId').val(id);
            let res = await axios.post("/admin/experience-certificates/by-id",{id:id})

            $('#certificate_numberUpdate').val(res.data['certificate_number']);
            $('#certificateviewUpdate').attr('src', res.data['pdf'] ? '/uploads/' + res.data['pdf'] : '{{ asset("images/default.png") }}');
        }catch (e) {
            errorToast(e.response.data['message']);
        }
    }

    async function Update() {
        try {
            let formData = new FormData();
            formData.append('certificate_number', $("#certificate_numberUpdate").val());

            // PDF file (check if file selected)
            let certificateFile = $("input[name='certificateUpdate']").prop('files')[0];
            if (certificateFile) {
                formData.append('certificate', certificateFile);
            }

            formData.append('id', $('#updateId').val());

            let res = await axios.post('/admin/experience-certificates/update', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });

            if (res.status === 200) {
                $("#update_modal").modal('hide');
                document.getElementById("update_form").reset();
                $('#certificateviewUpdate').attr('src', '{{ asset("images/default.png") }}');
                $('#certificate_numberUpdateError').text('');
                $('#certificateUpdateError').text('');
                successToast(res.data['message']);
                await getList();
            } else {
                errorToast(res.data['message']);
            }

        } catch (error) {
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                $('#certificate_numberUpdateError').text(errors.certificate_number ? errors.certificate_number[0] : '');
                $('#certificateUpdateError').text(errors.pdf ? errors.pdf[0] : '');
            } else {
                errorToast(error.response.data['message']);
            }
        }
     }

</script>

@endpush

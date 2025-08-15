<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Attendance</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="container">
                        <div class="row">

                            <input type="hidden" id="updateId">
                            <input type="hidden" id="filePath">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" id="nameUpdate" name="nameUpdate" class="form-control"
                                        value="{{ Auth::user()->name }}" readonly>
                                    <small id="nameUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Apply Date <span class="text-danger">*</span></label>
                                    <input type="date" id="apply_dateUpdate" name="apply_dateUpdate" class="form-control"
                                        value="" readonly required>
                                    <small id="apply_dateUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Leave Start Date <span class="text-danger">*</span></label>
                                    <input type="date" id="start_dateUpdate" name="start_dateUpdate" class="form-control" required>
                                    <small id="start_dateUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Leave End Date <span class="text-danger">*</span></label>
                                    <input type="date" id="end_dateUpdate" name="end_dateUpdate" class="form-control" required>
                                    <small id="end_dateUpdateError" class="text-danger"></small>
                                </div>

                                <div class="mb-3">
                                    <label>Leave Type <span class="text-danger">*</span></label>
                                    <select id="typeUpdate" class="form-select">
                                        <option value="">--- Select Option ---</option>
                                        <option value="casual">casual Leave</option>
                                        <option value="medical">Medical Leave</option>
                                        <option value="special">Special Leave</option>
                                    </select>
                                    <small id="typeUpdateError" class="text-danger"></small>
                                </div>

                                <div class="mb-3">
                                    <label>Leave Reason <span class="text-danger">*</span></label>
                                    <textarea id="reasonUpdate" name="reasonUpdate" class="form-control"></textarea>
                                    <small id="reasonUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="signatureUpdate">Signature <span class="text-danger">*</span></label>
                                    <div class="d-flex justify-content-center align-items-center bg-dark">
                                        <img id="oldSignatureImage" src="{{ asset('images/default.png') }}" alt="Defauld Image" class="mb-3 d-block" style="width: 150px; height: auto;">
                                    </div>
                                    <input id="signatureUpdate" oninput="oldSignatureImage.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control">
                                    <small id="signatureUpdateError" class="text-danger"></small>
                                </div>

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
            $('#reasonUpdate').summernote({ height: 100 });
        });

        async function FillUpUpdateForm(id, filePath) {
            try {

                $('#updateId').val(id);
                $('#filePath').val(filePath);
                document.getElementById('oldSignatureImage').src = filePath;

                let res = await axios.post("/leave-application/by-id", { id: id })
                let row = res.data.row;

                $('#nameUpdate').val(row.user.name);
                $('#apply_dateUpdate').val(row.apply_date);
                $('#start_dateUpdate').val(row.start_date);
                $('#end_dateUpdate').val(row.end_date);
                $('#typeUpdate').val(row.type);
                $('#reasonUpdate').summernote('code', res.data.row.reason);

            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {

                let signature = document.getElementById('signatureUpdate').files[0];
                let formData = new FormData();
                formData.append('name', $("#nameUpdate").val());
                formData.append('apply_date', $("#apply_dateUpdate").val());
                formData.append('start_date', $("#start_dateUpdate").val());
                formData.append('end_date', $("#end_dateUpdate").val());
                formData.append('type', $("#typeUpdate").val());

                if (signature) {
                    formData.append('signature', signature);
                }

                // Reason
                let isEmptyreasonUpdate = $('#reasonUpdate').summernote('isEmpty');
                let reasonUpdateHtml = isEmptyreasonUpdate ? '' : $('#reasonUpdate').summernote('code');
                formData.append('reason', reasonUpdateHtml);

                formData.append('updateId', $('#updateId').val())

                let res = await axios.post('/leave-application/update', formData)

                if (res.status === 200) {
                    $("#update_modal_close").click();
                    document.getElementById("update_form").reset();
                    $('.reasonUpdate').summernote('code', '');
                    successToast(res.data['message']);
                    $('#apply_dateUpdateError').text('');
                    $('#start_dateUpdateError').text('');
                    $('#end_dateUpdateError').text('');
                    $('#typeUpdateError').text('');
                    $('#reasonUpdateError').text('');
                    $('#signatureUpdateError').text('');
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#apply_dateUpdateError').text(errors.apply_date ? errors.apply_date[0] : '');
                    $('#start_dateUpdateError').text(errors.start_date ? errors.start_date[0] : '');
                    $('#end_dateUpdateError').text(errors.end_date ? errors.end_date[0] : '');
                    $('#typeUpdateError').text(errors.type ? errors.type[0] : '');
                    $('#reasonUpdateError').text(errors.reason ? errors.reason[0] : '');
                    $('#signatureUpdateError').text(errors.signature ? errors.signature[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }


        }

    </script>

@endpush
<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Leave Application</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::id() }}">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ Auth::user()->name }}" readonly>
                            <small id="nameError" class="text-danger"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Apply Date <span class="text-danger">*</span></label>
                            <input type="date" id="apply_date" name="apply_date" class="form-control"
                                value="{{ now()->format('Y-m-d') }}" readonly required>
                            <small id="apply_dateError" class="text-danger"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Leave Start Date <span class="text-danger">*</span></label>
                            <input type="date" id="start_date" name="start_date" class="form-control" required>
                            <small id="start_dateError" class="text-danger"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Leave End Date <span class="text-danger">*</span></label>
                            <input type="date" id="end_date" name="end_date" class="form-control" required>
                            <small id="end_dateError" class="text-danger"></small>
                        </div>

                        <div class="mb-3">
                            <label>Leave Type <span class="text-danger">*</span></label>
                            <select id="type" name="type" class="form-select">
                                <option value="">--- Select Option ---</option>
                                <option value="casual">casual Leave</option>
                                <option value="medical">Medical Leave</option>
                                <option value="special">Special Leave</option>
                            </select>
                            <small id="typeError" class="text-danger"></small>
                        </div>

                        <div class="mb-3">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea id="reason" name="reason" class="form-control"></textarea>
                            <small id="reasonError" class="text-danger"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="signature">Signature <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-center align-items-center bg-dark">
                                <img id="signatureImage" src="{{ asset('images/default.png') }}" alt="Defauld Image" class="mb-3 d-block" style="width: 150px; height: auto;">
                            </div>
                            <input id="signature" name="signature" oninput="signatureImage.src=window.URL.createObjectURL(this.files[0])"
                                type="file" class="form-control">
                            <small id="signatureError" class="text-danger"></small>
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
            $('#reason').summernote({ height: 100 });
        });

        async function Save() {
            try {

                let signature = document.getElementById('signature').files[0];
                let formData = new FormData();
                formData.append('user_id', $("#user_id").val());
                formData.append('apply_date', $("#apply_date").val());
                formData.append('start_date', $("#start_date").val());
                formData.append('end_date', $("#end_date").val());
                formData.append('type', $("#type").val());
                formData.append('signature', signature);

                let isEmpty = $('#reason').summernote('isEmpty');
                let reasonHtml = isEmpty ? '' : $('#reason').summernote('code');

                formData.append('reason', reasonHtml);

                const config = {
                    headers: {
                        'content-Type': 'multipart/form-data'
                    }
                }

                let res = await axios.post('/leave-application/store', formData, config)

                if (res.status === 200) {
                    $("#modal_close").click();
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#reasonError').summernote('code', '');
                    $('#user_idError').text('');
                    $('#apply_dateError').text('');
                    $('#start_dateError').text('');
                    $('#end_dateError').text('');
                    $('#typeError').text('');
                    $('#signatureError').text('');
                    $('#reasonError').text('');
                    await getList()
                } else {
                    errorToast(res.data.message || 'Unknown response status');
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#user_idError').text(errors.user_id ? errors.user_id?.[0] : '');
                    $('#apply_dateError').text(errors.apply_date ? errors.apply_date?.[0] : '');
                    $('#start_dateError').text(errors.start_date ? errors.start_date?.[0] : '');
                    $('#end_dateError').text(errors.end_date ? errors.end_date?.[0] : '');
                    $('#typeError').text(errors.type ? errors.type?.[0] : '');
                    $('#signatureError').text(errors.signature ? errors.signature?.[0] : '');
                    $('#reasonError').text(errors.reason ? errors.reason?.[0] : '');
                } else {
                    errorToast(error.response.data['message'] || `Server returned ${error.response.status}`);
                }
            }

        }
    </script>
@endpush
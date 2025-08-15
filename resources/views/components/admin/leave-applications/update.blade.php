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

                            <div class="row">

                                <div class="col-md-12 mb-3" style="width: 400px !important">
                                    <label>Leave Application Status <span class="text-danger">*</span></label>
                                    <select id="adminLeaveApplicationStatus" class="form-select">
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                    <small id="adminLeaveApplicationStatusError" class="text-danger"></small>
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

        async function FillUpUpdateForm(id) {
            try {

                $('#updateId').val(id);
                let res = await axios.post("/leave-application/by-id", { id: id })
                let row = res.data.row;

                $('#adminLeaveApplicationStatus').val(row.status);
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();
                formData.append('status', $("#adminLeaveApplicationStatus").val());

                formData.append('updateId', $('#updateId').val())

                let res = await axios.post('/admin/leave-application/update', formData)

                if (res.status === 200) {
                    $("#update_modal_close").click();
                    document.getElementById("update_form").reset();
                    successToast(res.data['message']);
                    $('#adminLeaveApplicationStatusError').text('');
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#adminLeaveApplicationStatusError').text(errors.status ? errors.status[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }


        }

    </script>

@endpush
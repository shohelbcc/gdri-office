<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Task</h6>
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
                                <label class="form-label">Task Title<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="titleUpdate" placeholder="Task Title"
                                    value="{{ old('titleUpdate') }}" readonly>
                                <small id="titleUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Status<span class="text-danger ml-1">*</span></label>
                                <select id="statusUpdate" class="form-select" required>
                                    <option value="Not Started">Not Started</option>
                                    <option value="Started">Started</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="On Held">On Held</option>
                                    <option value="Completed">Completed</option>
                                </select>
                                <small id="statusUpdateError" class="text-danger"></small>
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
                let res = await axios.post("/employee/task/by-id", { id: id })
                let row = res.data.row

                $('#titleUpdate').val(row.title);
                $('#statusUpdate').val(row.status);
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();

                formData.append('title', $("#titleUpdate").val());
                formData.append('status', $("#statusUpdate").val());

                formData.append('updateId', $('#updateId').val())

                let res = await axios.post('/employee/task/update', formData)

                if (res.status === 200) {
                    $("#update_modal_close").click();
                    document.getElementById("update_form").reset();
                    successToast(res.data['message']);
                    $('#titleUpdateError').text('');
                    $('#statusUpdateError').text('');
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleUpdateError').text(errors.title?.[0] || '');
                    $('#statusUpdateError').text(errors.status?.[0] || '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }


        }

    </script>

@endpush
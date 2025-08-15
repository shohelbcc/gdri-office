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
                                <label for="assigned_toUpdate" class="form-label">Assign To <span
                                        class="text-danger">*</span></label>
                                <select id="assigned_toUpdate" name="assigned_toUpdate[]" class="form-select select2"
                                    multiple="multiple" required>
                                    <option value="">--- Select Users ---</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <small id="assigned_toUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Task Title<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="titleUpdate" placeholder="Task Title"
                                    value="{{ old('titleUpdate') }}">
                                <small id="titleUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description<span class="text-danger ml-1">*</span></label>
                                <textarea id="descriptionUpdate" class="form-control"></textarea>
                                <small id="descriptionUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Assigned Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="assigned_dateUpdate"
                                    placeholder="Assigned Date" value="{{ old('assigned_dateUpdate') }}" readonly>
                                <small id="assigned_dateUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Completed Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="completed_dateUpdate"
                                    placeholder="Completed Date" value="{{ old('completed_dateUpdate') }}">
                                <small id="completed_dateUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Project Name<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="projectUpdate" placeholder="Project Name"
                                    value="{{ old('projectUpdate') }}">
                                <small id="projectUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Priority<span class="text-danger ml-1">*</span></label>
                                <select id="priorityUpdate" class="form-select" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Critical">Critical</option>
                                </select>
                                <small id="priorityUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status<span class="text-danger ml-1">*</span></label>
                                <select id="statusUpdate" class="form-select" required>
                                    <option value="Not Started">Not Started</option>
                                    <option value="Started">Started</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="On Held">On Held</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Received">Received</option>
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

        $(document).ready(function () {
            // Summer Note
            $('#descriptionUpdate').summernote({ height: 100 });

            // Initialize Select2
            $('#assigned_toUpdate').select2({
                dropdownParent: $('#update_modal'), // Ensures dropdown doesn't get clipped
                width: '100%',
                placeholder: 'Select Users',
                allowClear: true
            });
        });

        async function FillUpUpdateForm(id) {
            try {

                $('#updateId').val(id);
                let res = await axios.post("/admin/task/by-id", { id: id })
                let row = res.data.row

                $('#assigned_toUpdate').val(row.assignees.map(u => u.id)).trigger('change');
                $('#titleUpdate').val(row.title);
                $('#descriptionUpdate').summernote('code', row.description);
                $('#assigned_dateUpdate').val(row.assigned_date);
                $('#completed_dateUpdate').val(row.completed_date ?? '');
                $('#projectUpdate').val(row.project);
                $('#priorityUpdate').val(row.priority);
                $('#statusUpdate').val(row.status);
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();
                let assignedUsers = $('#assigned_toUpdate').val();
                assignedUsers.forEach(userId => formData.append('assigned_to[]', userId));

                formData.append('title', $("#titleUpdate").val());
                formData.append('description', $('#descriptionUpdate').summernote('code'));
                formData.append('assigned_date', $("#assigned_dateUpdate").val());
                formData.append('completed_date', $("#completed_dateUpdate").val());
                formData.append('project', $("#projectUpdate").val());
                formData.append('priority', $("#priorityUpdate").val());
                formData.append('status', $("#statusUpdate").val());

                formData.append('updateId', $('#updateId').val())

                let res = await axios.post('/admin/task/update', formData)

                if (res.status === 200) {
                    $("#update_modal_close").click();
                    document.getElementById("update_form").reset();
                    // $('#assigned_toUpdate').val(null).trigger('change');
                    $('#descriptionUpdate').summernote('code', '');
                    successToast(res.data['message']);
                    $('#assigned_toUpdateError').text('');
                    $('#titleUpdateError').text('');
                    $('#descriptionUpdateError').text('');
                    // $('#assigned_dateUpdateError').text('');
                    $('#completed_dateUpdateError').text('');
                    $('#projectUpdateError').text('');
                    $('#priorityUpdateError').text('');
                    $('#statusUpdateError').text('');
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#assigned_toUpdateError').text(errors.assigned_to?.[0] || '');
                    $('#titleUpdateError').text(errors.title?.[0] || '');
                    $('#descriptionUpdateError').text(errors.description?.[0] || '');
                    // $('#assigned_dateUpdateError').text(errors.assigned_date?.[0] || '');
                    $('#completed_dateUpdateError').text(errors.completed_date?.[0] || '');
                    $('#projectUpdateError').text(errors.project?.[0] || '');
                    $('#priorityUpdateError').text(errors.priority?.[0] || '');
                    $('#statusUpdateError').text(errors.status?.[0] || '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }


        }

    </script>

@endpush
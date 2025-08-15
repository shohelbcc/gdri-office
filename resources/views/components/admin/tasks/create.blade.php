<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Assign New Task</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="assigned_to" class="form-label">Assign To <span
                                        class="text-danger">*</span></label>
                                <select id="assigned_to" name="assigned_to[]" class="form-select select2"
                                    multiple="multiple" required>
                                    <option value="">--- Select Users ---</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <small id="assigned_toError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Task Title<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Task Title"
                                    value="{{ old('title') }}">
                                <small id="titleError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description<span class="text-danger ml-1">*</span></label>
                                <textarea id="description" class="form-control"></textarea>
                                <small id="descriptionError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Assigned Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="assigned_date" placeholder="Assigned Date"
                                    value="{{ old('assigned_date') }}">
                                <small id="assigned_dateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Completed Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="completed_date" placeholder="Completed Date"
                                    value="{{ old('completed_date') }}">
                                <small id="completed_dateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project Name<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="project" placeholder="Project Name"
                                    value="{{ old('project') }}">
                                <small id="projectError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Priority<span class="text-danger ml-1">*</span></label>
                                <select id="priority" class="form-select" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Critical">Critical</option>
                                </select>
                                <small id="priorityError" class="text-danger"></small>
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

        $(document).ready(function () {
            // Summer Note
            $('#description').summernote({ height: 100 });

            new TomSelect("#assigned_to", {
                plugins: ['remove_button'],
                create: false,
            });
        });

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('title', $("#title").val());

                let isEmpty = $('#description').summernote('isEmpty');
                let descriptionHtml = isEmpty ? '' : $('#description').summernote('code');

                formData.append('description', descriptionHtml);

                formData.append('assigned_date', $("#assigned_date").val());
                formData.append('completed_date', $("#completed_date").val());

                formData.append('priority', $("#priority").val());
                formData.append('project', $("#project").val());

                // Append each selected user ID
                let assignedToValues = $("#assigned_to").val();
                assignedToValues.forEach(userId => {
                    formData.append('assigned_to[]', userId);
                });


                let res = await axios.post('/admin/task/store', formData)

                if (res.status === 200) {
                    $("#modal_close").click();
                    document.getElementById("save-form").reset();
                    $('#assigned_to').val(null).trigger('change');
                    $('#description').summernote('code', '');
                    successToast(res.data['message']);
                    $('#titleError').text('');
                    $('#descriptionError').text('');
                    $('#assigned_dateError').text('');
                    $('#completed_dateError').text('');
                    $('#priorityError').text('');
                    $('#projectError').text('');
                    $('#assigned_toError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ?? '');
                    $('#descriptionError').text(errors.description ?? '');
                    $('#assigned_dateError').text(errors.assigned_date ?? '');
                    $('#completed_dateError').text(errors.completed_date ?? '');
                    $('#priorityError').text(errors.priority ?? '');
                    $('#projectError').text(errors.project ?? '');
                    $('#assigned_toError').text(errors.assigned_to ?? '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush

@push('styles')

    <style>
        /* Make Select2 inputs look like Bootstrap's */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            padding: 0.375rem !important;
            height: auto !important;
            min-height: 38px;
            background-color: #fff;
            font-size: 0.875rem;
        }

        /* Improve tag appearance */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd;
            border: none;
            color: white;
            padding: 0.25em 0.5em;
            margin-top: 0.25rem;
            font-size: 0.75rem;
        }

        /* Make dropdown full width */
        .select2-container {
            width: 100% !important;
        }
    </style>


@endpush
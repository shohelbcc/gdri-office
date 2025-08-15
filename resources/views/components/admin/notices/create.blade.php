<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Notice</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Title <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Title"
                                    value="{{ old('title') }}">
                                <small id="titleError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Details <span class="text-danger ml-1">*</span></label>
                                <textarea id="details" class="form-control"></textarea>
                                <small id="detailsError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Published At <span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="published_at" placeholder="Published At"
                                    value="{{ old('published_at') }}">
                                <small id="published_atError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Notice To <span class="text-danger ml-1">*</span></label>
                                <select class="form-control" id="user_ids" name="user_ids[]" multiple>
                                    <option value="">--- Select Users ---</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <small id="user_idsError" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="button" onclick="Save()" id="save-btn" class="btn btn-sm btn_green">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            // Summer Note
            $('#details').summernote({ height: 100 });

            new TomSelect("#user_ids", {
                plugins: ['remove_button'],
                create: false,
            });
        });

        async function Save() {
            try {
                let formData = new FormData();
                formData.append('title', $("#title").val());
                formData.append('published_at', $("#published_at").val());

                let isEmpty = $('#details').summernote('isEmpty');
                let detailsHtml = isEmpty ? '' : $('#details').summernote('code');
                formData.append('details', detailsHtml);

                // Add selected user IDs
                let selectedUsers = $("#user_ids").val();
                if (selectedUsers && selectedUsers.length > 0) {
                    selectedUsers.forEach(function(userId) {
                        formData.append('user_ids[]', userId);
                    });
                }
                
                let res = await axios.post('/admin/notice/store', formData);

                if (res.status === 200) {
                    $("#modal_close").click();
                    document.getElementById("save-form").reset();
                    $('#details').summernote('reset');
                    // TomSelect instance reset
                    if ($('#user_ids')[0].tomselect) $('#user_ids')[0].tomselect.clear();
                    successToast(res.data['message']);
                    
                    // Clear all error messages
                    $('#titleError').text('');
                    $('#detailsError').text('');
                    $('#published_atError').text('');
                    $('#user_idsError').text('');
                    
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleError').text(errors.title ? errors.title[0] : '');
                    $('#detailsError').text(errors.details ? errors.details[0] : '');
                    $('#published_atError').text(errors.published_at ? errors.published_at[0] : '');
                    $('#user_idsError').text(errors.user_ids ? errors.user_ids[0] : '');
                } else if (error.response) {
                    errorToast(error.response.data['message'] || 'An error occurred');
                } else {
                    errorToast('Network error occurred');
                }
            }
        }
    </script>
@endpush

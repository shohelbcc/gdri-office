<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Notice</h6>
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
                                <label class="form-label">Title<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="titleUpdate" placeholder="Title">
                                <small id="titleUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Details<span class="text-danger ml-1">*</span></label>
                                <textarea id="detailsUpdate" class="form-control"></textarea>
                                <small id="detailsUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Published At<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="published_atUpdate" placeholder="Published At">
                                <small id="published_atUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Notice To <span class="text-danger ml-1">*</span></label>
                                <select class="form-control" id="user_idsUpdate" name="user_ids[]" multiple>
                                    <option value="">--- Select Users ---</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <small id="user_idsUpdateError" class="text-danger"></small>
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

        $(document).ready(function () {
            $('#detailsUpdate').summernote({ height: 100 });

            new TomSelect("#user_idsUpdate", {
                plugins: ['remove_button'],
                create: false,
            });
        });

    async function FillUpUpdateForm(id){
        try {
            $('#updateId').val(id);
            let res = await axios.post("/admin/notice/by-id", {id: id});
            let mrow = res.data.row;
            let publishedAt = mrow.published_at ? mrow.published_at.substring(0, 10) : null;

            $('#titleUpdate').val(mrow.title);
            $('#published_atUpdate').val(publishedAt);
            $('#detailsUpdate').summernote('code', mrow.details);
            
            // Clear previous user selections and set new ones
            let userSelect = document.getElementById('user_idsUpdate').tomselect;
            userSelect.clear();
            
            // If there are associated users, select them
            if (mrow.users && mrow.users.length > 0) {
                mrow.users.forEach(function(user) {
                    userSelect.addItem(user.id);
                });
            }

            // Clear error messages
            $('#titleUpdateError').text('');
            $('#detailsUpdateError').text('');
            $('#published_atUpdateError').text('');
            $('#user_idsUpdateError').text('');
            
        } catch (e) {
            errorToast(e.response?.data?.message || 'Error loading notice data');
        }
    }

    async function Update() {
        try {
            let formData = new FormData();
            formData.append('title', $("#titleUpdate").val());
            formData.append('published_at', $("#published_atUpdate").val());

            // Details
            let isEmptyDetailsUpdate = $('#detailsUpdate').summernote('isEmpty');
            let detailsUpdateHtml = isEmptyDetailsUpdate ? '' : $('#detailsUpdate').summernote('code');
            formData.append('details', detailsUpdateHtml);

            // Add selected user IDs
            let selectedUsers = $("#user_idsUpdate").val();
            if (selectedUsers && selectedUsers.length > 0) {
                selectedUsers.forEach(function(userId) {
                    formData.append('user_ids[]', userId);
                });
            }

            formData.append('updateId', $('#updateId').val());

            let res = await axios.post('/admin/notice/update', formData);

            if (res.status === 200) {
                $('#update_modal').modal('hide');
                document.getElementById("update_form").reset();
                $('#detailsUpdate').summernote('reset');
                successToast(res.data['message']);
                
                // Clear all error messages
                $('#titleUpdateError').text('');
                $('#detailsUpdateError').text('');
                $('#published_atUpdateError').text('');
                $('#user_idsUpdateError').text('');
                
                await getList();
            } else {
                errorToast(res.data['message']);
            }

        } catch (error) {
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                $('#titleUpdateError').text(errors.title ? errors.title[0] : '');
                $('#detailsUpdateError').text(errors.details ? errors.details[0] : '');
                $('#published_atUpdateError').text(errors.published_at ? errors.published_at[0] : '');
                $('#user_idsUpdateError').text(errors.user_ids ? errors.user_ids[0] : '');
            } else if (error.response) {
                errorToast(error.response.data['message'] || 'An error occurred');
            } else {
                errorToast('Network error occurred');
            }
        }
    }

</script>

@endpush

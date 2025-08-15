<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Branch</h6>
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
                                <label class="form-label">Title <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="titleUpdate" placeholder="Title" value="{{ old('title') }}">
                                <small id="titleUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Content <span class="text-danger ml-1">*</span></label>
                                <textarea id="contentUpdate" class="form-control" placeholder="Content">{{ old('content') }}</textarea>
                                <small id="contentUpdateError" class="text-danger"></small>
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
    $('#contentUpdate').summernote({height: 100});

    async function FillUpUpdateForm(id){
        try {

            $('#updateId').val(id);
            let res = await axios.post("/admin/home/accordian/by-id",{id:id})

            $('#titleUpdate').val(res.data.data.title);
            $('#contentUpdate').summernote('code', res.data.data.content);
        }catch (e) {
            errorToast(e.response.data['message']);
        }
    }

    async function Update() {
        try {
            let formData = new FormData();
            formData.append('title', $("#titleUpdate").val());
            // Content
            let isEmptyContentUpdate = $('#contentUpdate').summernote('isEmpty');
            let contentUpdateHtml = isEmptyContentUpdate ? '' : $('#contentUpdate').summernote('code');
            formData.append('content', contentUpdateHtml);

            formData.append('id', $('#updateId').val());

            let res = await axios.post('/admin/home/accordian/update', formData);

            if (res.status === 200) {
                $("#update_modal").modal('hide');
                $('#contentUpdate').summernote('reset');
                document.getElementById("update_form").reset();
                $('#titleUpdateError').text('');
                $('#contentUpdateError').text('');
                successToast(res.data['message']);
                await getList();
            } else {
                errorToast(res.data['message']);
            }

        } catch (error) {
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                $('#titleUpdateError').text(errors.title ? errors.title[0] : '');
                $('#contentUpdateError').text(errors.content ? errors.content[0] : '');
            } else {
                errorToast(error.response.data['message']);
            }
        }
     }

</script>

@endpush

<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Type</h6>
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
                                <label class="form-label">Name <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="nameUpdate" placeholder="Name" value="{{ old('name') }}">
                                <small id="nameUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description <span class="text-danger ml-1">*</span></label>
                                <textarea id="descriptionUpdate" class="form-control"></textarea>
                                <small id="descriptionUpdateError" class="text-danger"></small>
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
            $('#descriptionUpdate').summernote({ height: 100 });
        });

    async function FillUpUpdateForm(id){
        try {

            $('#updateId').val(id);
            let res = await axios.post("/admin/publication/type/by-id",{id:id})

            $('#nameUpdate').val(res.data.data.name);
            $('#descriptionUpdate').summernote('code', res.data.data.description);
        }catch (e) {
            errorToast(e.response.data['message']);
        }
    }

    async function Update() {
        try {
            let formData = new FormData();
            formData.append('name', $("#nameUpdate").val());

            // Description
            let isEmptyDescription = $('#descriptionUpdate').summernote('isEmpty');
            let descriptionHtml = isEmptyDescription ? '' : $('#descriptionUpdate').summernote('code');
            formData.append('description', descriptionHtml);
            formData.append('id', $('#updateId').val());

            let res = await axios.post('/admin/publication/type/update', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });

            if (res.status === 200) {
                $("#update_modal").modal('hide');
                document.getElementById("update_form").reset();
                $('#descriptionUpdate').summernote('code', '');
                $('#nameUpdateError').text('');
                successToast(res.data['message']);
                await getList();
            } else {
                errorToast(res.data['message']);
            }

        } catch (error) {
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                $('#nameUpdateError').text(errors.name ? errors.name[0] : '');
                $('#descriptionUpdateError').text(errors.description ? errors.description[0] : '');
            } else {
                errorToast(error.response.data['message']);
            }
        }
     }

</script>

@endpush

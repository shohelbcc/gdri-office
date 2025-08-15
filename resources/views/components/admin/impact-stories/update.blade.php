<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Impact Story</h6>
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

                                <div class="col-md-12 mb-3">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <textarea id="titleUpdate"></textarea>
                                    <small id="titleUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea id="descriptionUpdate"></textarea>
                                    <small id="descriptionUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Reference <span class="text-danger">*</span></label>
                                    <textarea id="referenceUpdate"></textarea>
                                    <small id="referenceUpdateError" class="text-danger"></small>
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
        $('#titleUpdate').summernote({ height: 100 });
        $('#descriptionUpdate').summernote({ height: 200 });
        $('#referenceUpdate').summernote({ height: 100 });

        async function FillUpUpdateForm(id) {
            try {

                $('#updateId').val(id);
                let res = await axios.post("/admin/impact-stories/by-id", { id: id })
                let row = res.data.row;

                $('#titleUpdate').summernote('code', row.title);
                $('#descriptionUpdate').summernote('code', row.description);
                $('#referenceUpdate').summernote('code', row.reference);
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();
                formData.append('title', $("#titleUpdate").val());
                formData.append('description', $("#descriptionUpdate").val());
                formData.append('reference', $("#referenceUpdate").val());

                formData.append('updateId', $('#updateId').val())

                let res = await axios.post('/admin/impact-stories/update', formData)

                if (res.status === 200) {
                    $("#update_modal").modal('hide');
                    document.getElementById("update_form").reset();
                    successToast(res.data['message']);
                    $('#titleUpdateError').text('');
                    $('#descriptionUpdateError').text('');
                    $('#referenceUpdateError').text('');
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#titleUpdateError').text(errors.title ? errors.title[0] : '');
                    $('#descriptionUpdateError').text(errors.description ? errors.description[0] : '');
                    $('#referenceUpdateError').text(errors.reference ? errors.reference[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }


        }

    </script>

@endpush
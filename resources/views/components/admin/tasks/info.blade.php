<div class="modal fade" id="info_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">User Info</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">

                        <input type="hidden" id="infoId">

                        <div class="col-md-6 mb-3">
                            <div class="col-inner">
                                <label class="form-label">Name</label>
                                <hr class="m-0">
                                <input type="text" class="form-control info" id="nameInfo" disabled>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="col-inner">.
                                <label class="form-label">Email</label>
                                <hr class="m-0">
                                <input type="email" class="form-control info" id="emailInfo" disabled>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="col-inner">
                                <label class="form-label">Phone</label>
                                <hr class="m-0">
                                <input type="text" class="form-control info" id="phoneInfo" disabled>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="update_modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>




@push('scripts')
    <script>

        async function FillUpInfoForm(id) {
            try {

                $('#infoId').val(id);
                let res = await axios.post("/admin/user/by-id", { id: id })

                $('#nameInfo').val(res.data.row.name);
                $('#emailInfo').val(res.data.row.email);
                $('#phoneInfo').val(res.data.row.phone);
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

    </script>

@endpush
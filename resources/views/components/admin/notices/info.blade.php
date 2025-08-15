<div class="modal fade" id="info_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Notice Details</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">

                        <input type="hidden" id="infoId">

                        <div class="col-md-12 mb-3">
                            <div class="col-inner">
                                <label class="form-label">Title</label>
                                <hr class="m-0">
                                <input type="text" class="form-control info" id="nameInfo" disabled>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="col-inner">.
                                <label class="form-label">Details</label>
                                <hr class="m-0">
                                <textarea class="form-control info" id="detailsInfo" disabled></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="col-inner">
                                <label class="form-label">Published At</label>
                                <hr class="m-0">
                                <input type="text" class="form-control info" id="publishedAtInfo" disabled>
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
                let res = await axios.post("/admin/notice/by-id", { id: id })
                let publishedAtInfo = res.data.row.published_at ? res.data.row.published_at.substring(0, 10) : '';

                $('#nameInfo').val(res.data.row.title);
                $('#detailsInfo').summernote('code', res.data.row.details);
                $('#publishedAtInfo').val(publishedAtInfo);
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }




        

    // async function FillUpUpdateForm(id){
    //     try {

    //         $('#updateId').val(id);
    //         let res = await axios.post("/admin/notice/by-id",{id:id})
    //         let mrow = res.data.row

    //         $('#titleUpdate').val(mrow.title);
    //         $('#published_atUpdate').val(mrow.published_at ? mrow.published_at.substring(0, 10) : '');
    //         $('#detailsUpdate').summernote('code', mrow.details);
    //     }catch (e) {
    //         errorToast(e.response.data['message']);
    //     }
    // }

    </script>

@endpush
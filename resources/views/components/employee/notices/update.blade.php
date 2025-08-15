<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Marke As Read</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="container">
                        <div class="row text-center">

                            <h3 class=" mt-3 text-warning">Are you sure!</h3>
                            <p class="mb-3">Once change, you can't change next.</p>
                            <input type="hidden" id="updateId">

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="update_modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal"
                        aria-label="Close">No</button>
                    <button onclick="Update()" id="update-btn" class="btn btn-sm btn_green">Yes</button>
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
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();

                formData.append('notice_id', $('#updateId').val())

                let res = await axios.post('/employee/notice/mark-as-read', formData)

                if (res.status === 200) {
                    // Close modal reliably
                    $('#update_modal').modal('hide');
                    document.getElementById("update_form").reset();
                    successToast(res.data['message']);
                    await getList();
                    await updateUnreadNoticeBadge();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                } else {
                    errorToast(error.response.data['message']);
                }
            }
        }

    </script>

@endpush
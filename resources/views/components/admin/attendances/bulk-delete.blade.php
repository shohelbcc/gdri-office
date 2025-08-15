<div class="modal fade" id="bulk_delete_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body px-5 text-center">
                <h3 class=" mt-3 text-warning">Are you sure!</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input type="hidden" id="bulkDeleteId" />
            </div>
            <div class="modal-footer justify-content-end">
                <div class="d-flex justify-content-end">
                    <button type="button" id="bulk_delete_modal_close" class="btn btn-sm btn-dark" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="bulkDelete()" type="button" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>

        async function bulkDelete() {
            try {
                let ids = $('#bulkDeleteId').val(); // Fixed to use the correct variable name

                let idsArray = $('#bulkDeleteId').val().split(','); // Fixed to use the correct variable name

                document.getElementById('bulk_delete_modal_close').click(); // Updated to match the correct modal close ID

                let res = await axios.post('/admin/attendance/bulk-delete', { ids: idsArray }); // Fixed to use the correct variable

                if (res.data['status'] === "success") {
                    successToast(res.data['message'])
                    await getList()
                } else {
                    errorToast(res.data['message'])
                }
            } catch (error) {
                errorToast(error.response.data['message']);
            }
        }

    </script>
@endpush
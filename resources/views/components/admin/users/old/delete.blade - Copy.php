<div class="modal fade" id="delete_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body px-5 text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input type="hidden" id="deleteId"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete_modal_close" class="btn bg-gradient-success mx-2" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

    async  function  itemDelete(){
        try {
            let id = $('#deleteId').val();

            document.getElementById('delete_modal_close').click();

            let res = await axios.post("/batch-delete",{id:id})

            if(res.data['status']==="success"){
                successToast(res.data['message'])
                await getList()
            } else{
                errorToast(res.data['message'])
            }
        }catch (error) {
            errorToast(error.response.data['message']);
        }
    }
</script>
@endpush


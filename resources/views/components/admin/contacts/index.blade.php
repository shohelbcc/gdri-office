<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>Update Contacts</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <form action="{{ route('admin.contact.update', $contact->id) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $contact->address }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ $contact->phone }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $contact->email }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="text" class="form-control" name="website" value="{{ $contact->website }}">
                        </div>

                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
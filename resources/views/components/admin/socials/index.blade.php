<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>Update Social Medias</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <form action="{{ route('admin.social.media.update', $social->id) }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="row">

                        <div class="mb-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input class="form-control" id="facebook" name="facebook" value="{{ $social->facebook }}">
                        </div>

                        <div class="mb-3">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input class="form-control" id="twitter" name="twitter" value="{{ $social->twitter }}">
                        </div>

                        <div class="mb-3">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input class="form-control" id="instagram" name="instagram" value="{{ $social->instagram }}">
                        </div>

                        <div class="mb-3">
                            <label for="linkedin" class="form-label">Linked In</label>
                            <input class="form-control" id="linkedin" name="linkedin" value="{{ $social->linkedin }}">
                        </div>

                        <div class="mb-3">
                            <label for="youtube" class="form-label">YouTube</label>
                            <input class="form-control" id="youtube" name="youtube" value="{{ $social->youtube }}">
                        </div>

                    </div>

                    <button type="submit" class="btn btn-sm btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
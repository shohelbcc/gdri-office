<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Permissions</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <form action="{{ route('admin.assign.permission.store', $role->id) }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="row g-3">
                        @foreach ($permissions as $permission)
                            <div class="col-6 col-md-3 col-xl-2">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="permissions[]"
                                        id="permission{{ $permission->id }}"
                                        value="{{ $permission->id }}"
                                        {{-- directly see if the role “has” this permission --}}
                                        {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="permission{{ $permission->id }}">
                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr class="bg-secondary" />

                    <div class="mt-3">
                        <button type="submit" class="btn btn-sm btn-primary">
                            Assign Permission(s)
                        </button>
                        <a href="{{ route('admin.role.index') }}" class="btn btn-sm btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
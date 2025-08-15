s<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Roles</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <form action="{{ route('admin.assign.role.store', $user->id) }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="row g-3">
                        @foreach ($roles as $role)
                            <div class="col-6 col-md-3 col-xl-2">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="roles[]"
                                        id="role{{ $role->id }}"
                                        value="{{ $role->id }}"
                                        {{-- directly see if the role “has” this role --}}
                                        {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="role{{ $role->id }}">
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr class="bg-secondary" />

                    <div class="mt-3">
                        <button type="submit" class="btn btn-sm btn-primary">
                            Assign Role(s)
                        </button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
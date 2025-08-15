<form action="{{ route('admin.profile.update') }}" method="post">
    @csrf
    @method('POST')
    <div class="card border-primary shadow" style="border: 1px solid #007bff;">
        <div class="card-header bg-primary text-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Personal Information</h5>
            <button type="submit" class="btn btn-sm btn-light">Save Changes</button>
        </div>

        <input type="hidden" name="id" value="{{ $user->id }}">

        <div class="card-body">
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input  
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $user->name) }}" 
                    class="form-control @error('name') is-invalid @enderror" 
                    required
                >
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input  
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $user->email) }}" 
                    class="form-control @error('email') is-invalid @enderror" 
                    required
                >
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone <span class="text-danger">*</span></label>
                <input  
                    type="text" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone', $user->phone) }}" 
                    class="form-control @error('phone') is-invalid @enderror" 
                    required
                >
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <input  
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="Leave blank to keep current password"
                    >
                    <div class="input-group-append">
                        <button 
                            class="btn btn-outline-secondary" 
                            type="button" 
                            id="togglePassword"
                        >
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pwdInput    = document.getElementById('password');
        const toggleBtn   = document.getElementById('togglePassword');
        const icon        = toggleBtn.querySelector('i');

        toggleBtn.addEventListener('click', function () {
            const isHidden = pwdInput.type === 'password';
            pwdInput.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });
</script>
@endpush

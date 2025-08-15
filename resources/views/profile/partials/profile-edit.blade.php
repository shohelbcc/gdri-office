@extends('layouts.app-admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.user.profile.update', $user->profile->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><span class="text-primary">{{ $user->name }}'s</span> Profile</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                @if ($user->profile->photo)
                                    <img id="oldPhoto" src="{{ asset($user->profile->photo) }}" alt="User Photo"
                                        class="mb-3 d-block" style="width: 80px; height: auto;">

                                @else
                                    <img id="oldPhoto" src="{{ asset('images/avater.jpg') }}" alt="Avatar" class="mb-3 d-block"
                                        style="width: 80px; height: auto;">
                                @endif
                                <label for="photo">Photo</label>
                                <input name="photo" oninput="oldPhoto.src=window.URL.createObjectURL(this.files[0])"
                                    type="file" class="form-control">
                                @error('photo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="division">Division <span class="text-danger">*</span></label>
                                <select name="division" id="division" class="form-select" required>
                                    <option value="">--- Select Division ---</option>
                                    @foreach ($divisions as $item)
                                        <option value="{{$item->id}}" {{ $user->profile->division == $item->id ? ' selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('division')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="district">District <span class="text-danger">*</span></label>
                                <select name="district" id="district" class="form-select" required></select>
                                @error('district')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="thana">Thana <span class="text-danger">*</span></label>
                                <select name="thana" id="thana" class="form-select" required></select>
                                @error('thana')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code"
                                    value="{{ old('postal_code', $user->profile->postal_code) }}" class="form-control"
                                    >
                                @error('postal_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="address">Address <span class="text-danger">*</span></label>
                                <input type="text" id="address" name="address"
                                    value="{{ old('address', $user->profile->address) }}" class="form-control" required>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="designation">Designation <span class="text-danger">*</span></label>
                                <input type="text" id="designation" name="designation"
                                    value="{{ old('designation', $user->profile->designation) }}" class="form-control"
                                    required>
                                @error('designation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" id="dob" name="dob" value="{{ old('dob', $user->profile->dob) }}"
                                    class="form-control" required>
                                @error('dob')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="work_office">Work Office <span class="text-danger">*</span></label>
                                <input type="text" id="work_office" name="work_office"
                                    value="{{ old('work_office', $user->profile->work_office) }}" class="form-control"
                                    required>
                                @error('work_office')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="employee_status">Employee Status <span class="text-danger">*</span></label>
                                <input type="text" id="employee_status" name="employee_status"
                                    value="{{ old('employee_status', $user->profile->employee_status) }}"
                                    class="form-control" required>
                                @error('employee_status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="links">Links</label>
                                <input type="text" id="links" name="links"
                                    value="{{ old('links', $user->profile->links) }}" class="form-control">
                                @error('links')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="biography">Biography</label>
                                {{-- <textarea id="biography" name="biography" class="form-control">{!!  $user->profile->biography !!}</textarea> --}}
                                <textarea id="biography" name="biography" class="form-control">{{ old('biography', $user->profile->biography) }}</textarea>
                                @error('biography')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#biography').summernote({height: 100});

        $(document).ready(function () {
            // 1) your raw JSON
            const divisions = @json($divisions);
            const allDistricts = @json($districts);

            // 2) the “current” IDs from the profile
            const currentDivision = {{ $user->profile->division ?? 'null' }};
            const currentDistrict = {{ $user->profile->district ?? 'null' }};
            const currentThana = {{ $user->profile->thana ?? 'null' }};

            // Division change ⇒ populate districts
            $('#division').on('change', function () {
                const divisionId = +$(this).val();
                const districtList = divisions.find(division => division.id === divisionId)?.districts || [];

                $('#district').empty()
                    .append('<option value="">--- Select District ---</option>');

                districtList.forEach(district => {
                    $('#district').append(
                        `<option value="${district.id}"${district.id === currentDistrict ? ' selected' : ''}>${district.name}</option>`
                    );
                });

                // if we have a saved district, trigger its change to load thanas
                if (currentDistrict) {
                    $('#district').val(currentDistrict).trigger('change');
                }
            });

            // District change ⇒ populate thanas
            $('#district').on('change', function () {
                const districtId = +$(this).val();
                // look up in allDistricts (you passed down from the controller)
                const thanaList = allDistricts
                    .find(district => district.id === districtId)?.thanas || [];

                $('#thana').empty()
                    .append('<option value="">--- Select Thana ---</option>');

                thanaList.forEach(thana => {
                    $('#thana').append(
                        `<option value="${thana.id}"${thana.id === currentThana ? ' selected' : ''}>${thana.name}</option>`
                    );
                });
            });

            // FINALLY: kick it all off by selecting the division
            if (currentDivision) {
                $('#division').val(currentDivision).trigger('change');
            }
        });
    </script>
@endpush
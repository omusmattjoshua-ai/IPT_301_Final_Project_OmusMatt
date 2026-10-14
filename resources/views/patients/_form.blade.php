<div class="row">
    <div class="col-md-6 mb-3">
        <label for="first_name" class="form-label">First name</label>
        <input id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name ?? '') }}" class="form-control @error('first_name') is-invalid @enderror" required>
        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="last_name" class="form-label">Last name</label>
        <input id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name ?? '') }}" class="form-control @error('last_name') is-invalid @enderror" required>
        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="birth_date" class="form-label">Date of birth</label>
        <input id="birth_date" type="date" name="birth_date" max="{{ now()->subDay()->toDateString() }}" value="{{ old('birth_date', isset($patient) ? $patient->birth_date->format('Y-m-d') : '') }}" class="form-control @error('birth_date') is-invalid @enderror" required>
        @error('birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="gender" class="form-label">Gender</label>
        <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
            <option value="">Choose...</option>
            @foreach (['Female', 'Male', 'Non-binary', 'Prefer not to say'] as $gender)
                <option value="{{ $gender }}" @selected(old('gender', $patient->gender ?? '') === $gender)>{{ $gender }}</option>
            @endforeach
        </select>
        @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="contact_number" class="form-label">Contact number</label>
        <input id="contact_number" name="contact_number" value="{{ old('contact_number', $patient->contact_number ?? '') }}" class="form-control @error('contact_number') is-invalid @enderror" required>
        @error('contact_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">Email (optional)</label>
        <input id="email" type="email" name="email" value="{{ old('email', $patient->email ?? '') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $patient->address ?? '') }}</textarea>
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

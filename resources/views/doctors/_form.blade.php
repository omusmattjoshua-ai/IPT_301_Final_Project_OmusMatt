<div class="mb-3">
    <label for="name" class="form-label">Full name</label>
    <input id="name" name="name" value="{{ old('name', $doctor->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="specialization" class="form-label">Specialization</label>
    <input id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization ?? '') }}" class="form-control @error('specialization') is-invalid @enderror" required>
    @error('specialization')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="license_number" class="form-label">License number</label>
    <input id="license_number" name="license_number" value="{{ old('license_number', $doctor->license_number ?? '') }}" class="form-control @error('license_number') is-invalid @enderror" required>
    @error('license_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="contact_number" class="form-label">Contact number</label>
    <input id="contact_number" name="contact_number" value="{{ old('contact_number', $doctor->contact_number ?? '') }}" class="form-control @error('contact_number') is-invalid @enderror" required>
    @error('contact_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email', $doctor->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

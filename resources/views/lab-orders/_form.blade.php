<div class="mb-3">
    <label for="patient_id" class="form-label">Patient</label>
    <select id="patient_id" name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
        <option value="">Choose a patient...</option>
        @foreach ($patients as $patient)
            <option value="{{ $patient->id }}" @selected((string) old('patient_id', $labOrder->patient_id ?? '') === (string) $patient->id)>{{ $patient->last_name }}, {{ $patient->first_name }}</option>
        @endforeach
    </select>
    @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="doctor_id" class="form-label">Doctor</label>
    <select id="doctor_id" name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
        <option value="">Choose a doctor...</option>
        @foreach ($doctors as $doctor)
            <option value="{{ $doctor->id }}" @selected((string) old('doctor_id', $labOrder->doctor_id ?? '') === (string) $doctor->id)>{{ $doctor->name }} — {{ $doctor->specialization }}</option>
        @endforeach
    </select>
    @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="order_date" class="form-label">Order date</label>
        <input id="order_date" type="date" name="order_date" value="{{ old('order_date', isset($labOrder) ? $labOrder->order_date->format('Y-m-d') : now()->toDateString()) }}" class="form-control @error('order_date') is-invalid @enderror" required>
        @error('order_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', $labOrder->status ?? 'pending') === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<fieldset class="mb-3">
    <legend class="form-label">Select requested tests</legend>
    @error('lab_test_ids')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
    @error('lab_test_ids.*')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
    @php($selectedTests = array_map('intval', old('lab_test_ids', isset($labOrder) ? $labOrder->labResults->pluck('lab_test_id')->all() : [])))
    <div class="row g-2">
        @foreach ($labTests as $labTest)
            <div class="col-md-6">
                <label class="form-check border rounded p-3 ps-5 h-100">
                    <input class="form-check-input" type="checkbox" name="lab_test_ids[]" value="{{ $labTest->id }}" @checked(in_array($labTest->id, $selectedTests))>
                    <span class="form-check-label">{{ $labTest->test_name }} <span class="text-secondary">({{ $labTest->category }} — {{ number_format((float) $labTest->price, 2) }})</span></span>
                </label>
            </div>
        @endforeach
    </div>
</fieldset>
<div class="mb-3">
    <label for="remarks" class="form-label">Remarks (optional)</label>
    <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $labOrder->remarks ?? '') }}</textarea>
    @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

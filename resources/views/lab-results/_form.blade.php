<div class="mb-3">
    <label for="lab_order_id" class="form-label">Lab order</label>
    <select id="lab_order_id" name="lab_order_id" class="form-select @error('lab_order_id') is-invalid @enderror" required>
        <option value="">Choose an order...</option>
        @foreach ($labOrders as $order)
            <option value="{{ $order->id }}" @selected((string) old('lab_order_id', isset($labResult) ? $labResult->lab_order_id : ($labOrder->id ?? '')) === (string) $order->id)>#{{ $order->id }} — {{ $order->patient->first_name }} {{ $order->patient->last_name }} ({{ $order->order_date->format('M j, Y') }})</option>
        @endforeach
    </select>
    @error('lab_order_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="lab_test_id" class="form-label">Lab test</label>
    <select id="lab_test_id" name="lab_test_id" class="form-select @error('lab_test_id') is-invalid @enderror" required>
        <option value="">Choose a test...</option>
        @foreach ($labTests as $test)
            <option value="{{ $test->id }}" @selected((string) old('lab_test_id', $labResult->lab_test_id ?? '') === (string) $test->id)>{{ $test->test_name }} ({{ $test->category }})</option>
        @endforeach
    </select>
    @error('lab_test_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="result_value" class="form-label">Result value</label>
    <input id="result_value" name="result_value" value="{{ old('result_value', $labResult->result_value ?? '') }}" class="form-control @error('result_value') is-invalid @enderror" required>
    @error('result_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="result_date" class="form-label">Result date</label>
    <input id="result_date" type="date" name="result_date" value="{{ old('result_date', isset($labResult) ? $labResult->result_date->format('Y-m-d') : now()->toDateString()) }}" class="form-control @error('result_date') is-invalid @enderror" required>
    @error('result_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="remarks" class="form-label">Remarks (optional)</label>
    <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $labResult->remarks ?? '') }}</textarea>
    @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

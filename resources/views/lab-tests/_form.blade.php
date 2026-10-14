<div class="mb-3">
    <label for="test_name" class="form-label">Test name</label>
    <input id="test_name" name="test_name" value="{{ old('test_name', $labTest->test_name ?? '') }}" class="form-control @error('test_name') is-invalid @enderror" required>
    @error('test_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required>
        <option value="">Choose...</option>
        @foreach (['Hematology', 'Chemistry', 'Urinalysis', 'Serology', 'Immunology', 'Parasitology'] as $category)
            <option value="{{ $category }}" @selected(old('category', $labTest->category ?? '') === $category)>{{ $category }}</option>
        @endforeach
    </select>
    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input id="price" type="number" name="price" min="0" step="0.01" value="{{ old('price', $labTest->price ?? '') }}" class="form-control @error('price') is-invalid @enderror" required>
    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="normal_range" class="form-label">Normal range</label>
    <input id="normal_range" name="normal_range" value="{{ old('normal_range', $labTest->normal_range ?? '') }}" class="form-control @error('normal_range') is-invalid @enderror" required>
    @error('normal_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="unit" class="form-label">Unit</label>
    <input id="unit" name="unit" value="{{ old('unit', $labTest->unit ?? '') }}" class="form-control @error('unit') is-invalid @enderror" required>
    @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

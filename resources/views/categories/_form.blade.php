<div class="mb-3">
    <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $category?->name) }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Color <span class="text-danger">*</span></label>
    <input type="color" name="color" class="form-control form-control-color"
           value="{{ old('color', $category?->color ?? '#6366f1') }}">
    @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $category?->description) }}</textarea>
</div>
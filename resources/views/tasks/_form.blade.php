<div class="mb-3">
    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $task?->title) }}" required>
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $task?->description) }}</textarea>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach($statuses as $s)
            <option value="{{ $s }}" {{ old('status', $task?->status ?? 'pending') == $s ? 'selected' : '' }}>
                {{ ucfirst(str_replace('_',' ',$s)) }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
        <select name="priority" class="form-select @error('priority') is-invalid @enderror">
            @foreach($priorities as $p)
            <option value="{{ $p }}" {{ old('priority', $task?->priority ?? 'medium') == $p ? 'selected' : '' }}>
                {{ ucfirst($p) }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Category</label>
        <select name="category_id" class="form-select">
            <option value="">None</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $task?->category_id) == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Due Date</label>
        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
               value="{{ old('due_date', $task?->due_date?->format('Y-m-d')) }}">
        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
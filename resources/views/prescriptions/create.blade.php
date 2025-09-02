@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Prescription</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('prescriptions.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Prescription Images (Max 5 images) *</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                   name="images[]" multiple accept="image/*" required>
                            <small class="text-muted">Accepted formats: JPG, JPEG, PNG. Max size: 5MB per image.</small>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Additional Notes</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" name="note" rows="3" 
                                      placeholder="Any special instructions or notes...">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="delivery_address" class="form-label">Delivery Address *</label>
                            <textarea class="form-control @error('delivery_address') is-invalid @enderror" 
                                      id="delivery_address" name="delivery_address" rows="3" required 
                                      placeholder="Enter complete delivery address...">{{ old('delivery_address') }}</textarea>
                            @error('delivery_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="delivery_time" class="form-label">Preferred Delivery Time *</label>
                            <select class="form-select @error('delivery_time') is-invalid @enderror" 
                                    id="delivery_time" name="delivery_time" required>
                                <option value="">Select 2-hour time slot</option>
                                <option value="08:00-10:00" {{ old('delivery_time') == '08:00-10:00' ? 'selected' : '' }}>08:00 AM - 10:00 AM</option>
                                <option value="10:00-12:00" {{ old('delivery_time') == '10:00-12:00' ? 'selected' : '' }}>10:00 AM - 12:00 PM</option>
                                <option value="12:00-14:00" {{ old('delivery_time') == '12:00-14:00' ? 'selected' : '' }}>12:00 PM - 02:00 PM</option>
                                <option value="14:00-16:00" {{ old('delivery_time') == '14:00-16:00' ? 'selected' : '' }}>02:00 PM - 04:00 PM</option>
                                <option value="16:00-18:00" {{ old('delivery_time') == '16:00-18:00' ? 'selected' : '' }}>04:00 PM - 06:00 PM</option>
                                <option value="18:00-20:00" {{ old('delivery_time') == '18:00-20:00' ? 'selected' : '' }}>06:00 PM - 08:00 PM</option>
                            </select>
                            @error('delivery_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Upload Prescription</button>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
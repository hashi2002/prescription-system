@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Prescription #{{ $prescription->id }}</h4>
                    <span class="badge bg-{{ $prescription->status == 'pending' ? 'warning' : ($prescription->status == 'quoted' ? 'info' : ($prescription->status == 'accepted' ? 'success' : 'danger')) }} fs-6">
                        {{ ucfirst($prescription->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <!-- Patient Information (for pharmacy view) -->
                    @if(auth()->user()->isPharmacy())
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Patient Information</h6>
                                <p><strong>Name:</strong> {{ $prescription->user->name }}</p>
                                <p><strong>Email:</strong> {{ $prescription->user->email }}</p>
                                <p><strong>Contact:</strong> {{ $prescription->user->contact_no }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Delivery Details</h6>
                                <p><strong>Address:</strong> {{ $prescription->delivery_address }}</p>
                                <p><strong>Time Slot:</strong> {{ $prescription->delivery_time }}</p>
                                <p><strong>Submitted:</strong> {{ $prescription->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($prescription->note)
                        <div class="mb-4">
                            <h6>{{ auth()->user()->isPharmacy() ? 'Patient Note' : 'Your Note' }}</h6>
                            <div class="alert alert-light">
                                {{ $prescription->note }}
                            </div>
                        </div>
                    @endif

                    <!-- Prescription Images -->
                    <div class="mb-4">
                        <h6>Prescription Images ({{ $prescription->images->count() }} images)</h6>
                        @if($prescription->images->isEmpty())
                            <p class="text-muted">No images found for this prescription.</p>
                        @else
                            <div class="row">
                                @foreach($prescription->images as $index => $image)
                                    <div class="col-md-4 col-lg-3 mb-3">
                                        <div class="card">
                                            <img src="{{ Storage::url($image->image_path) }}" 
                                                 class="card-img-top prescription-image" 
                                                 alt="Prescription Image {{ $index + 1 }}"
                                                 style="height: 200px; object-fit: cover;"
                                                 onclick="showImageModal('{{ Storage::url($image->image_path) }}', {{ $index + 1 }})">
                                            <div class="card-body p-2 text-center">
                                                <small class="text-muted">Image {{ $index + 1 }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="text-center">
                        <a href="{{ auth()->user()->isPharmacy() ? route('pharmacy.dashboard') : route('user.dashboard') }}" 
                           class="btn btn-secondary me-2">Back to Dashboard</a>
                        
                        @if(auth()->user()->isPharmacy())
                            @php
                                $hasQuotation = $prescription->quotations()->where('pharmacy_id', auth()->id())->exists();
                            @endphp
                            
                            @if(!$hasQuotation)
                                <a href="{{ route('quotations.create', $prescription) }}" class="btn btn-success">
                                    Create Quotation
                                </a>
                            @else
                                @php
                                    $quotation = $prescription->quotations()->where('pharmacy_id', auth()->id())->first();
                                @endphp
                                <a href="{{ route('quotations.show', $quotation) }}" class="btn btn-info">
                                    View Quotation
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle">Prescription Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Prescription Image" style="max-height: 80vh;">
            </div>
            <div class="modal-footer">
                <button type="button" id="prevBtn" class="btn btn-secondary">Previous</button>
                <button type="button" id="nextBtn" class="btn btn-secondary">Next</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const images = @json($prescription->images->pluck('image_path'));
let currentImageIndex = 0;

function showImageModal(imagePath, imageNumber) {
    currentImageIndex = imageNumber - 1;
    updateModalImage();
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function updateModalImage() {
    if (images.length > 0) {
        const imagePath = '{{ Storage::url("") }}' + images[currentImageIndex];
        document.getElementById('modalImage').src = imagePath;
        document.getElementById('imageModalTitle').textContent = `Prescription Image ${currentImageIndex + 1} of ${images.length}`;
        
        // Update button states
        document.getElementById('prevBtn').disabled = currentImageIndex === 0;
        document.getElementById('nextBtn').disabled = currentImageIndex === images.length - 1;
    }
}

document.getElementById('prevBtn').addEventListener('click', function() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
        updateModalImage();
    }
});

document.getElementById('nextBtn').addEventListener('click', function() {
    if (currentImageIndex < images.length - 1) {
        currentImageIndex++;
        updateModalImage();
    }
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('imageModal');
    if (modal.classList.contains('show')) {
        if (e.key === 'ArrowLeft' && currentImageIndex > 0) {
            currentImageIndex--;
            updateModalImage();
        } else if (e.key === 'ArrowRight' && currentImageIndex < images.length - 1) {
            currentImageIndex++;
            updateModalImage();
        }
    }
});
</script>
@endsection
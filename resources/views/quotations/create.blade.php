@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Prescription #{{ $prescription->id }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Patient:</strong> {{ $prescription->user->name }}</p>
                    <p><strong>Email:</strong> {{ $prescription->user->email }}</p>
                    <p><strong>Delivery Address:</strong> {{ $prescription->delivery_address }}</p>
                    <p><strong>Delivery Time:</strong> {{ $prescription->delivery_time }}</p>
                    
                    @if($prescription->note)
                        <p><strong>Patient Note:</strong> {{ $prescription->note }}</p>
                    @endif

                    <h6 class="mt-3">Prescription Images:</h6>
                    <div class="row">
                        @foreach($prescription->images as $image)
                            <div class="col-6 mb-2">
                                <img src="{{ Storage::url($image->image_path) }}" 
                                     class="img-fluid rounded prescription-image" 
                                     alt="Prescription Image" 
                                     style="max-height: 150px; cursor: pointer;"
                                     onclick="showImageModal('{{ Storage::url($image->image_path) }}')">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Create Quotation</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('quotations.store', $prescription) }}" id="quotationForm">
                        @csrf

                        <div id="itemsContainer">
                            <div class="item-row mb-3 p-3 border rounded">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <label class="form-label">Drug Name</label>
                                        <input type="text" class="form-control" name="items[0][drug_name]" required>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" class="form-control quantity" name="items[0][quantity]" 
                                               min="1" step="1" required onchange="calculateTotal()">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label class="form-label">Unit Price (Rs.)</label>
                                        <input type="number" class="form-control unit-price" name="items[0][unit_price]" 
                                               min="0.01" step="0.01" required onchange="calculateTotal()">
                                    </div>
                                    <div class="col-12">
                                        <span class="total-price fw-bold">Total: Rs. 0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('items')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" onclick="addItem()">Add Item</button>
                        </div>

                        <div class="mb-3">
                            <h5>Grand Total: Rs. <span id="grandTotal">0.00</span></h5>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Send Quotation</button>
                            <a href="{{ route('pharmacy.dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prescription Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Prescription">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let itemCount = 1;

function addItem() {
    const container = document.getElementById('itemsContainer');
    const itemRow = document.createElement('div');
    itemRow.className = 'item-row mb-3 p-3 border rounded';
    
    itemRow.innerHTML = `
        <div class="row">
            <div class="col-12 mb-2">
                <label class="form-label">Drug Name</label>
                <input type="text" class="form-control" name="items[${itemCount}][drug_name]" required>
            </div>
            <div class="col-6 mb-2">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control quantity" name="items[${itemCount}][quantity]" 
                       min="1" step="1" required onchange="calculateTotal()">
            </div>
            <div class="col-6 mb-2">
                <label class="form-label">Unit Price (Rs.)</label>
                <input type="number" class="form-control unit-price" name="items[${itemCount}][unit_price]" 
                       min="0.01" step="0.01" required onchange="calculateTotal()">
            </div>
            <div class="col-12 d-flex justify-content-between">
                <span class="total-price fw-bold">Total: Rs. 0.00</span>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button>
            </div>
        </div>
    `;
    
    container.appendChild(itemRow);
    itemCount++;
}

function removeItem(button) {
    button.closest('.item-row').remove();
    calculateTotal();
}

function calculateTotal() {
    let grandTotal = 0;
    
    document.querySelectorAll('.item-row').forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
        const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
        const total = quantity * unitPrice;
        
        row.querySelector('.total-price').textContent = `Total: Rs. ${total.toFixed(2)}`;
        grandTotal += total;
    });
    
    document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
}

function showImageModal(imagePath) {
    document.getElementById('modalImage').src = imagePath;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endsection
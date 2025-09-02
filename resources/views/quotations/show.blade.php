@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Quotation for Prescription #{{ $quotation->prescription_id }}</h4>
                    <span class="badge bg-{{ $quotation->status == 'sent' ? 'info' : ($quotation->status == 'accepted' ? 'success' : 'danger') }} fs-6">
                        {{ ucfirst($quotation->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        @if(auth()->user()->isPharmacy())
                            <div class="col-md-6">
                                <h6>Patient Information</h6>
                                <p><strong>Name:</strong> {{ $quotation->prescription->user->name }}</p>
                                <p><strong>Email:</strong> {{ $quotation->prescription->user->email }}</p>
                                <p><strong>Contact:</strong> {{ $quotation->prescription->user->contact_no }}</p>
                            </div>
                        @else
                            <div class="col-md-6">
                                <h6>Pharmacy Information</h6>
                                <p><strong>Name:</strong> {{ $quotation->pharmacy->name }}</p>
                                <p><strong>Contact:</strong> {{ $quotation->pharmacy->contact_no }}</p>
                            </div>
                        @endif
                        
                        <div class="col-md-6">
                            <h6>Delivery Information</h6>
                            <p><strong>Address:</strong> {{ $quotation->prescription->delivery_address }}</p>
                            <p><strong>Time Slot:</strong> {{ $quotation->prescription->delivery_time }}</p>
                            @if($quotation->prescription->note)
                                <p><strong>Note:</strong> {{ $quotation->prescription->note }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Quotation Items -->
                    <h6>Quotation Items</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Drug Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotation->items as $item)
                                    <tr>
                                        <td>{{ $item->drug_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                                        <td>Rs. {{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <th colspan="3">Total Amount:</th>
                                    <th>Rs. {{ number_format($quotation->total_amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Actions for User -->
                    @if(auth()->user()->isUser() && $quotation->status == 'sent')
                        <div class="mt-4 text-center">
                            <h6>Respond to this quotation:</h6>
                            <form method="POST" action="{{ route('quotations.respond', $quotation) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="accept">
                                <button type="submit" class="btn btn-success me-2">Accept Quotation</button>
                            </form>
                            <form method="POST" action="{{ route('quotations.respond', $quotation) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btn btn-danger">Reject Quotation</button>
                            </form>
                        </div>
                    @endif

                    <!-- Status Information -->
                    <div class="mt-4">
                        <div class="alert alert-{{ $quotation->status == 'sent' ? 'info' : ($quotation->status == 'accepted' ? 'success' : 'warning') }}">
                            @if($quotation->status == 'sent')
                                <strong>Status:</strong> Quotation sent and waiting for patient response.
                            @elseif($quotation->status == 'accepted')
                                <strong>Status:</strong> Quotation accepted by patient. Proceed with order preparation.
                            @else
                                <strong>Status:</strong> Quotation rejected by patient.
                            @endif
                            <br>
                            <small>Created on: {{ $quotation->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ auth()->user()->isPharmacy() ? route('pharmacy.dashboard') : route('user.dashboard') }}" 
                           class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
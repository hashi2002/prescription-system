@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>My Prescriptions</h2>
                <a href="{{ route('prescriptions.create') }}" class="btn btn-success">Upload New Prescription</a>
            </div>

            @if($prescriptions->isEmpty())
                <div class="alert alert-info">
                    <h5>No prescriptions found</h5>
                    <p>You haven't uploaded any prescriptions yet. Click "Upload New Prescription" to get started.</p>
                </div>
            @else
                <div class="row">
                    @foreach($prescriptions as $prescription)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h6>Prescription #{{ $prescription->id }}</h6>
                                    <span class="badge bg-{{ $prescription->status == 'pending' ? 'warning' : ($prescription->status == 'quoted' ? 'info' : ($prescription->status == 'accepted' ? 'success' : 'danger')) }}">
                                        {{ ucfirst($prescription->status) }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p><strong>Images:</strong> {{ $prescription->images->count() }}</p>
                                    <p><strong>Delivery Address:</strong> {{ $prescription->delivery_address }}</p>
                                    <p><strong>Delivery Time:</strong> {{ $prescription->delivery_time }}</p>
                                    <p><strong>Uploaded:</strong> {{ $prescription->created_at->format('M d, Y H:i') }}</p>
                                    
                                    @if($prescription->note)
                                        <p><strong>Note:</strong> {{ $prescription->note }}</p>
                                    @endif

                                    @if($prescription->quotation)
                                        <div class="alert alert-info">
                                            <strong>Quotation Amount:</strong> Rs. {{ number_format($prescription->quotation->total_amount, 2) }}
                                            <br>
                                            <strong>Status:</strong> {{ ucfirst($prescription->quotation->status) }}
                                            
                                            @if($prescription->quotation->status == 'sent')
                                                <div class="mt-2">
                                                    <a href="{{ route('quotations.show', $prescription->quotation) }}" class="btn btn-sm btn-primary">View Details</a>
                                                    <form method="POST" action="{{ route('quotations.respond', $prescription->quotation) }}" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="accept">
                                                        <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('quotations.respond', $prescription->quotation) }}" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="reject">
                                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
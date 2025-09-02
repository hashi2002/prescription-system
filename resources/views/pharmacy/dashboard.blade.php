@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Prescription Requests</h2>

            @if($prescriptions->isEmpty())
                <div class="alert alert-info">
                    <h5>No prescriptions found</h5>
                    <p>There are no prescription requests at the moment.</p>
                </div>
            @else
                <div class="row">
                    @foreach($prescriptions as $prescription)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h6>Prescription #{{ $prescription->id }}</h6>
                                    <div>
                                        <span class="badge bg-{{ $prescription->status == 'pending' ? 'warning' : ($prescription->status == 'quoted' ? 'info' : ($prescription->status == 'accepted' ? 'success' : 'danger')) }}">
                                            {{ ucfirst($prescription->status) }}
                                        </span>
                                        @if($prescription->quotations->isNotEmpty())
                                            <span class="badge bg-secondary ms-1">
                                                Quote: {{ ucfirst($prescription->quotations->first()->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p><strong>Patient:</strong> {{ $prescription->user->name }}</p>
                                    <p><strong>Contact:</strong> {{ $prescription->user->contact_no }}</p>
                                    <p><strong>Email:</strong> {{ $prescription->user->email }}</p>
                                    <p><strong>Images:</strong> {{ $prescription->images->count() }}</p>
                                    <p><strong>Delivery Address:</strong> {{ $prescription->delivery_address }}</p>
                                    <p><strong>Delivery Time:</strong> {{ $prescription->delivery_time }}</p>
                                    <p><strong>Submitted:</strong> {{ $prescription->created_at->format('M d, Y H:i') }}</p>

                                    @if($prescription->note)
                                        <p><strong>Patient Note:</strong> {{ $prescription->note }}</p>
                                    @endif

                                    <div class="mt-3">
                                        <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-primary btn-sm">View Images</a>
                                        
                                        @if($prescription->quotations->isEmpty())
                                            <a href="{{ route('quotations.create', $prescription) }}" class="btn btn-success btn-sm">Create Quotation</a>
                                        @else
                                            <a href="{{ route('quotations.show', $prescription->quotations->first()) }}" class="btn btn-info btn-sm">View Quotation</a>
                                            <span class="text-muted ms-2">
                                                Amount: Rs. {{ number_format($prescription->quotations->first()->total_amount, 2) }}
                                            </span>
                                        @endif
                                    </div>
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
@component('mail::message')
# Quotation {{ ucfirst($action) }}ed

Dear {{ $quotation->pharmacy->name }},

The patient {{ $user->name }} has **{{ $action }}ed** your quotation.

**Prescription Details:**
- Prescription ID: #{{ $prescription->id }}
- Quotation Amount: Rs. {{ number_format($quotation->total_amount, 2) }}
- Status: {{ ucfirst($action) }}ed

@if($action === 'accept')
**Next Steps:**
Please proceed with preparing the order for delivery at the specified address and time.

**Delivery Information:**
- Address: {{ $prescription->delivery_address }}
- Time Slot: {{ $prescription->delivery_time }}
@else
**Status Update:**
The patient has declined this quotation. You may create a new quotation if needed.
@endif

@component('mail::button', ['url' => route('pharmacy.dashboard')])
View Dashboard
@endcomponent

Best regards,<br>
{{ config('app.name') }}
@endcomponent
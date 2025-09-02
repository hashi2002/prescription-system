@component('mail::message')
# New Quotation Available

Dear {{ $user->name }},

Your prescription quotation is ready!

**Prescription Details:**
- Prescription ID: #{{ $prescription->id }}
- Total Amount: Rs. {{ number_format($quotation->total_amount, 2) }}
- Pharmacy: {{ $quotation->pharmacy->name }}

**Quotation Items:**
@component('mail::table')
| Drug Name | Quantity | Unit Price | Total |
| :-------- | :------- | :--------- | :---- |
@foreach($quotation->items as $item)
| {{ $item->drug_name }} | {{ $item->quantity }} | Rs. {{ number_format($item->unit_price, 2) }} | Rs. {{ number_format($item->total_price, 2) }} |
@endforeach
| | | **Grand Total** | **Rs. {{ number_format($quotation->total_amount, 2) }}** |
@endcomponent

Please log in to your account to view the detailed quotation and accept or reject it.

@component('mail::button', ['url' => route('user.dashboard')])
View Dashboard
@endcomponent

Thank you for choosing our pharmacy service.

Best regards,<br>
{{ config('app.name') }}
@endcomponent
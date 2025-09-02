use App\Models\Prescription;
use App\Models\Quotation;
use App\Policies\PrescriptionPolicy;
use App\Policies\QuotationPolicy;

protected $policies = [
    Prescription::class => PrescriptionPolicy::class,
    Quotation::class => QuotationPolicy::class,
];
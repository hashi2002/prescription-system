<?php
namespace App\Mail;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;

    public function __construct(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    public function build()
    {
        return $this->subject('New Quotation Available - Prescription #' . $this->quotation->prescription_id)
                    ->view('emails.quotation-created')
                    ->with([
                        'quotation' => $this->quotation,
                        'prescription' => $this->quotation->prescription,
                        'user' => $this->quotation->prescription->user,
                    ]);
    }
}
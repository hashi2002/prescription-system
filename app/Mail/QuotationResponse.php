<?php
namespace App\Mail;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;
    public $action;

    public function __construct(Quotation $quotation, $action)
    {
        $this->quotation = $quotation;
        $this->action = $action;
    }

    public function build()
    {
        $subject = 'Quotation ' . ucfirst($this->action) . 'ed - Prescription #' . $this->quotation->prescription_id;
        
        return $this->subject($subject)
                    ->view('emails.quotation-response')
                    ->with([
                        'quotation' => $this->quotation,
                        'prescription' => $this->quotation->prescription,
                        'user' => $this->quotation->prescription->user,
                        'action' => $this->action,
                    ]);
    }
}
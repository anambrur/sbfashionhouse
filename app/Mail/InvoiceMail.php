<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Common\Order;
use App\Model\Common\Payment;
use App\Model\Common\Media;
use App\SM\SM;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $orderId;
    public $order;
    public $payment;
    public $isWithExtraInfo = 0;
    public $mailMessage = '';
    public $files = array();

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderId, $extra = null)
    {
        $this->orderId = $orderId;
        if ($extra != null) {
            $this->isWithExtraInfo = 1;
            $this->mailMessage = $extra->message;
        }
        $this->order = Order::with('payment', 'user', 'detail')
            ->find($orderId);
        if (count($this->order) > 0) {
            if (trim($this->order->completed_files) != '') {
                $filesArray = explode(',', $this->order->completed_files);
                $this->files = Media::whereIn('slug', $filesArray)->get();
            }

            $this->payment = Payment::find($this->order->payment_id);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $orderFormatId = SM::orderNumberFormat($this->order);

        /*  Create Subject of Mail */
        $subject = SM::get_setting_value('site_name') . " Invoice ID # " . $orderFormatId . " is ";
        if ($this->order->order_status == 1) {
            $subject .= 'Completed.';
        } else if ($this->order->order_status == 2) {
            $subject .= 'Processing.';
        } else if ($this->order->order_status == 3) {
            $subject .= 'Pending.';
        } else {
            $subject .= 'Cancelled.';
        }

        $view = $this->subject($subject)
            ->view('email.invoice');

        /* Generate PDF Invoice Stream and attached as data */
        $this->order["payment"] = Payment::find($this->order->payment_id);

        $viewPdf = view("pdf/invoice")->with('order', $this->order);
        $strem = PDF::loadHTML($viewPdf)->stream();
        $view->attachData($strem, "buckleup_" . $orderFormatId . '.pdf', [
            'mime' => 'application/pdf',
        ]);


        if (count($this->files) > 0) {
            foreach ($this->files as $file) {
                $path = config('constant.smUploadsDir');
                $file_dir = storage_path("app/" . ($file->is_private == 1 ? "private" : "public") . "/" . $path . $file->slug);
                $view->attach($file_dir);
            }
        }

        return $view;
    }
}

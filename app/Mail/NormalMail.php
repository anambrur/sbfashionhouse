<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NormalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $info;

    /**
     * Create a new message instance.
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = $this->subject($this->info->subject)
            ->view('email.normal');
        if (isset($this->info->files) && count($this->info->files) > 0) {
            foreach ($this->info->files as $file) {
                $path = config('constant.smUploadsDir');
                $file_dir = storage_path("app/" . ($file->is_private == 1 ? "private" : "public") . "/" . $path . $file->slug);
                $view->attach($file_dir);
            }
        }

        return $view;
    }
}

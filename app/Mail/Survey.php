<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Survey extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Elements de contact
     * @var array
     */
    public $surveyData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $surveyData)
    {
        $this->surveyData = $surveyData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('benoo@noreply.com')
            ->view('emails.survey');
    }
}

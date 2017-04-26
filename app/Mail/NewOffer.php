<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
class NewOffer extends Mailable
{
    use Queueable, SerializesModels;

    public $offreapplication;
    public $offre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($offreapplication, $offre)
    {
        $this->offreapplication = new \stdClass();
        $this->offre = new \stdClass();
        $this->offreapplication = $offreapplication;
        $this->offre = $offre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::find($this->offre->user_id);
        $mecano = User::find($this->offreapplication->user_id);
        return $this->view('newofferapplicationmail')->with(['offreapplication' => $this->offreapplication, 'offre' => $this->offre, 'user' => $user, 'mecano' => $mecano,]);
    }
}

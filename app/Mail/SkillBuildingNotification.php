<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SkillBuildingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $obj_details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->obj_details = $obj;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Linking Session")
                ->view('mail.coaching.skill_building_notification');
    }
}

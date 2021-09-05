<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  /**
   * The sender email
   *
   * @var string
   */
  public $email;

  /**
   * The sender name
   *
   * @var string
   */
  public $name;

  /**
   * The subject
   *
   * @var string
   */
  public $subject;

  /**
   * The message content
   *
   * @var string
   */
  public $message;

  /**
   * Create a new message instance.
   *
   * @param string $email The sender email
   * @param string $name The sender name
   * @param string $subject The subject
   * @param string $message The message content
   *
   * @return void
   */
  public function __construct(string $email, string $name, string $subject, string $message)
  {
    $this->email = $email;
    $this->name = $name;
    $this->subject = $subject;
    $this->message = $message;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this
      ->from($this->email, $this->name)
      ->replyTo('john@johndoe.com', 'John Doe')
      ->subject(config('app.name') . ' Contact: ' . $this->subject)
      ->markdown('emails.contact', [
        'name' => $this->name,
        'message' => $this->message,
      ]);
  }
}

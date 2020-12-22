<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Contacto extends Notification
{
    use Queueable;
    protected $usuario;
    protected $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $usuario, Request $request)
    {
        $this->usuario = $usuario;
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        try {
            $fecha = date('d/m/Y h:i:s a');

            return (new MailMessage)
                ->error()
                ->from($this->usuario->email, "Contacto {$this->request->username}")
                ->subject("Contacto {$this->request->username}")
                ->greeting("¡Hola!, {$this->usuario->people->getConcatNameAttribute()}")
                ->line("Hoy $fecha, la persona {$this->request->username} envió un mensaje con la siguiente información,")
                ->line($this->request->message)
                ->line("Número de teléfono de contacto: {$this->request->phone}.")
                ->line("Correo electrónico de contacto: {$this->request->email}.");
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

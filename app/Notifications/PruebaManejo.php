<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use App\Models\Sistema\TestDrive;
use App\Models\Sistema\Transport;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PruebaManejo extends Notification
{
    use Queueable;
    protected $usuario;
    protected $test;
    protected $vehiculo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $usuario, TestDrive $test, Transport $vehiculo)
    {
        $this->usuario = $usuario;
        $this->test = $test;
        $this->vehiculo = $vehiculo;
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
        $url = "https://control.motores502.com/";
        $fecha = date('d/m/Y h:i:s a');

        return (new MailMessage)
            ->error()
            ->from($this->usuario->email, "Solicitud de Prueba de Manejo No. {$this->test->id}")
            ->subject("Solicitud de Prueba de Manejo No. {$this->test->id}")
            ->greeting("¡Hola!, {$this->usuario->people->getConcatNameAttribute()}")
            ->line("Hoy $fecha, el prospecto con código {$this->test->prospect->code_prospect},")
            ->line("solicitó una prueba de manejo con el código de vehículo {$this->vehiculo->code}.")
            ->action('Ingresar al Sistema MRM para ver más información', $url)
            ->line('Recuerda que la información la puedes encontrar en el menú MRM - Test Drive.')
            ->line('Nota: si tu usuario no cuenta con permisos para acceder a esta sección por favor comunicarse con el administrador del sistema.')
            ->line('¡Buen día!');
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

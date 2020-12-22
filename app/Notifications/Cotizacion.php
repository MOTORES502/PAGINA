<?php

namespace App\Notifications;

use App\Models\Empresa\Quote;
use App\Models\Sistema\Transport;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Cotizacion extends Notification
{
    use Queueable;
    protected $usuario;
    protected $cotizacion;
    protected $vehiculo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $usuario, Quote $cotizacion, Transport $vehiculo)
    {
        $this->usuario = $usuario;
        $this->cotizacion = $cotizacion;
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
        try {
            $fecha = date('d/m/Y h:i:s a');

            return (new MailMessage)
                ->error()
                ->from($this->usuario->email, "Solicitud de Cotización No. {$this->cotizacion->id}")
                ->subject("Solicitud de Cotización No. {$this->cotizacion->id}")
                ->greeting("¡Hola!, {$this->usuario->people->getConcatNameAttribute()}")
                ->line("Hoy $fecha, el prospecto con código {$this->cotizacion->prospect->code_prospect},")
                ->line("necesita una cotización del vehículo {$this->vehiculo->code}.")
                ->action('Ingresar al Sistema MRM para ver más información', $url)
                ->line('Recuerda que la información la puedes encontrar en el menú MRM - Cotizaciones Solicitadas.')
                ->line('Nota: si tu usuario no cuenta con permisos para acceder a esta sección por favor comunicarse con el administrador del sistema.')
                ->line('¡Buen día!');
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

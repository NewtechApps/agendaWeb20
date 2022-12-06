<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AgendaDelete extends Notification implements ShouldQueue
{
    use Queueable;
    public $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
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

        $aux = $this->event;
        return (new MailMessage)
            ->subject("Agenda Excluída!")
            ->line('Identificamos que foi excluída uma de suas agendas.')
            ->line('Descrição: '.$aux->title)
            ->line('Tipo: '.$aux->descricao)
            ->line('Período: '.Carbon::parse($aux->start)->format('d/m/Y').'-'.Carbon::parse($aux->end)->format('d/m/Y') )
            ->action('Acompanhe sua agenda!', url( env('APP_URL') ));
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

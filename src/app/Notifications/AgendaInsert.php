<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AgendaInsert extends Notification implements ShouldQueue
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
        $trabalho = DB::table('trabalho')->where('id_trabalho', '=', $aux['tipo_trabalho'])->first(); 
        $arrDatas = explode(',', trim( $aux['datas'] ));

        return (new MailMessage)
                    ->subject("Nova Agenda incluída para você!")
                    ->line('Identificamos que foi incluída uma agenda para você em nosso sistema.')
                    ->line('Descrição: '.$aux['title'])
                    ->line('Tipo: '.$trabalho->descricao)
                    ->line('Período: '.reset($arrDatas).'-'.end($arrDatas) )
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

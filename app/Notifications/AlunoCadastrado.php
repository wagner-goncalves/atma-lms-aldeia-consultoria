<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class AlunoCadastrado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $empresa, $curso)
    {
        $this->user = $user;
        $this->empresa = $empresa;
        $this->curso = $curso;
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
        return (new MailMessage)
            ->subject('Cadastrado na plataforma Aldeia Consultoria')
            ->greeting(sprintf("Olá, %s!", $this->user->name)) 
            ->line(sprintf('Você foi cadastrado no curso %s pela %s.', $this->curso->nome, $this->empresa->nome))
            ->line('Para acessar a plataforma, clique no link abaixo.')
            ->action('Acessar curso', route('primeiro.acesso', ["id" => Hash::make($this->user->id)]))
            ->line('Em seu primeiro acesso, Utilize seu E-MAIL e os SEIS PRIMEIROS DÍGITOS do seu CPF para acessar a plataforma.');
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

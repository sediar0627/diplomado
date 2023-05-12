<?php

namespace App\Mail;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class InvitacionProyecto extends Mailable
{
    use Queueable, SerializesModels;

    protected Proyecto $proyecto;
    protected User $usuarioAInvitar;
    protected MailMessage $mensaje;

    /**
     * Create a new message instance.
     */
    public function __construct(Proyecto $proyecto, User $usuarioAInvitar)
    {
        $this->proyecto = $proyecto;
        $this->usuarioAInvitar = $usuarioAInvitar;

        $cotenidoLink = json_encode([
            'proyecto_id' => $proyecto->id,
            'usuario_id' => $usuarioAInvitar->id,
        ]);

        $link = route('proyectos.aceptar_invitacion', ['token' => encrypt($cotenidoLink)]);

        $this->mensaje = (new MailMessage())
            ->greeting('Señor(a) '.strtoupper($usuarioAInvitar->name).'.')
            ->line("Ha sido invitado a participar en el proyecto {$proyecto->nombre}.")
            ->action('Aceptar invitacion', $link)
            ->salutation('Gracias por usar nuestra aplicación.');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitacion Proyecto '.$this->proyecto->nombre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: $this->mensaje->render(),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

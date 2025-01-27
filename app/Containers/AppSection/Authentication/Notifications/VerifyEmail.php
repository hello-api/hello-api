<?php

namespace App\Containers\AppSection\Authentication\Notifications;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Notifications\Notification as ParentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

final class VerifyEmail extends ParentNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $verificationUrl,
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Verify Email Address')
            ->line('Please click the below button to verify your email address.')
            ->action('Verify Email Address', $this->createUrl($notifiable))
            ->line('If you did not create an account, no further action is required.');
    }

    // TODO: This method might not have been tested properly. Please review it.
    private function createUrl(User $notifiable): string
    {
        $user_id = config('apiato.hash-id') ? $notifiable->getHashedKey() : $notifiable->getKey();
        $hash = sha1($notifiable->getEmailForVerification());

        return $this->verificationUrl . '?url=' . URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes((int) config('appSection-authentication.email_verification_link_expiration_time_in_minute')),
            compact('user_id', 'hash'),
        );
    }
}

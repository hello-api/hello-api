<?php

namespace App\Containers\AppSection\Authentication\Notifications;

use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Notifications\Notification as ParentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends ParentNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private string $verification_url,
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(UserModel $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Verify Email Address')
            ->line('Please click the below button to verify your email address.')
            ->action('Verify Email Address', $this->createUrl($notifiable))
            ->line('If you did not create an account, no further action is required.');
    }

    private function createUrl(UserModel $notifiable): string
    {
        $id = config('apiato.hash-id') ? $notifiable->getHashedKey() : $notifiable->getKey();
        $hash = sha1($notifiable->getEmailForVerification());

        return $this->verification_url . '?url=' . URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('appSection-authentication.email_verification_link_expiration_time_in_minute')),
            [
                'id' => $id,
                'hash' => $hash,
            ]
        );
    }
}

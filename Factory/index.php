<?php

// Notification Interface
interface Notification
{
    public function send(string $recipient, string $message): string;
}

// Concrete Implementations
class EmailNotification implements Notification
{
    public function send(string $recipient, string $message): string
    {
        // Simulate sending an email
        return "Email sent to $recipient: $message";
    }
}

class SMSNotification implements Notification
{
    public function send(string $recipient, string $message): string
    {
        // Simulate sending an SMS
        return "SMS sent to $recipient: $message";
    }
}

class PushNotification implements Notification
{
    public function send(string $recipient, string $message): string
    {
        // Simulate sending a push notification
        return "Push notification sent to $recipient: $message";
    }
}

// Factory Class
class NotificationFactory
{
    public static function create(string $type): Notification
    {
        return match ($type) {
            'email' => new EmailNotification(),
            'sms' => new SMSNotification(),
            'push' => new PushNotification(),
            default => throw new \InvalidArgumentException("Unknown notification type: $type"),
        };
    }
}

// Usage Example
try {
    $notificationType = 'email'; // Change to 'email', 'sms', or 'push'
    $notification = NotificationFactory::create($notificationType);
    var_dump($notification);
    $result = $notification->send('user@example.com', 'This is a test message.');
    echo $result . PHP_EOL;
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

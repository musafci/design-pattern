<?php

namespace App\Bridge;

// Implementor Interface
interface NotificationSender
{
    public function send(string $message): string;
}

// Concrete Implementor: Email Notification
class EmailSender implements NotificationSender
{
    public function send(string $message): string
    {
        return "Email sent: $message";
    }
}

// Concrete Implementor: SMS Notification
class SmsSender implements NotificationSender
{
    public function send(string $message): string
    {
        return "SMS sent: $message";
    }
}

// Abstraction
abstract class Notification
{
    protected NotificationSender $sender;

    public function __construct(NotificationSender $sender)
    {
        $this->sender = $sender;
    }

    abstract public function notify(string $message): string;
}

// Refined Abstraction: User Notification
class UserNotification extends Notification
{
    public function notify(string $message): string
    {
        return $this->sender->send("User Notification: $message");
    }
}

// Refined Abstraction: System Alert
class SystemAlert extends Notification
{
    public function notify(string $message): string
    {
        return $this->sender->send("System Alert: $message");
    }
}

// Client Code
function clientCode(Notification $notification, string $message)
{
    echo $notification->notify($message) . PHP_EOL;
}

// Usage Example
$emailSender = new EmailSender();
$smsSender = new SmsSender();

$userNotification = new UserNotification($emailSender);
$systemAlert = new SystemAlert($smsSender);

echo "Sending User Notification via Email:\n";
clientCode($userNotification, "Welcome to our service!");

echo "\nSending System Alert via SMS:\n";
clientCode($systemAlert, "Server is down!");

<?php

// Component Interface
interface Notifier
{
    public function send(string $message): string;
}

// Concrete Component
class BasicNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "Sending notification: {$message}";
    }
}

// Abstract Decorator
abstract class NotifierDecorator implements Notifier
{
    protected Notifier $notifier;

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function send(string $message): string
    {
        return $this->notifier->send($message);
    }
}

// Concrete Decorators
class SMSNotifier extends NotifierDecorator
{
    public function send(string $message): string
    {
        return parent::send($message) . " via SMS";
    }
}

class EmailNotifier extends NotifierDecorator
{
    public function send(string $message): string
    {
        return parent::send($message) . " via Email";
    }
}

class PushNotifier extends NotifierDecorator
{
    public function send(string $message): string
    {
        return parent::send($message) . " via Push Notification";
    }
}

// Client Code
function clientCode(Notifier $notifier, string $message)
{
    echo $notifier->send($message) . PHP_EOL;
}

// Usage Example
$basicNotifier = new BasicNotifier();

$emailNotifier = new EmailNotifier($basicNotifier);
$smsNotifier = new SMSNotifier($emailNotifier);
$pushNotifier = new PushNotifier($smsNotifier);

echo "Single Channel:\n";
clientCode($emailNotifier, "Welcome to our service!");

echo "\nMultiple Channels:\n";
clientCode($pushNotifier, "Your account has been updated.");

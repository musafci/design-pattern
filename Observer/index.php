<?php

// Observer Interface
interface Observer
{
    public function update(string $message): void;
}

// Concrete Observer: Email Subscriber
class EmailSubscriber implements Observer
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function update(string $message): void
    {
        echo "Email to {$this->email}: $message\n";
    }
}

// Concrete Observer: SMS Subscriber
class SmsSubscriber implements Observer
{
    private string $phone;

    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

    public function update(string $message): void
    {
        echo "SMS to {$this->phone}: $message\n";
    }
}

// Subject Interface
interface Subject
{
    public function attach(Observer $observer): void;

    public function detach(Observer $observer): void;

    public function notify(string $message): void;
}

// Concrete Subject: Blog Publisher
class BlogPublisher implements Subject
{
    private array $observers = [];

    public function attach(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void
    {
        $this->observers = array_filter($this->observers, fn($obs) => $obs !== $observer);
    }

    public function notify(string $message): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($message);
        }
    }

    public function publishNewPost(string $title): void
    {
        echo "Blog Published: $title\n";
        $this->notify("New blog post published: $title");
    }
}

// Client Code
$emailSubscriber1 = new EmailSubscriber("user1@example.com");
$emailSubscriber2 = new EmailSubscriber("user2@example.com");
$smsSubscriber = new SmsSubscriber("+1234567890");

$blogPublisher = new BlogPublisher();
$blogPublisher->attach($emailSubscriber1);
$blogPublisher->attach($emailSubscriber2);
$blogPublisher->attach($smsSubscriber);

// Publish a new blog post
$blogPublisher->publishNewPost("Observer Design Pattern in PHP");

// Detach a subscriber and publish another post
$blogPublisher->detach($emailSubscriber1);
$blogPublisher->publishNewPost("Understanding Laravel Observers");

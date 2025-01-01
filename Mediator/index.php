<?php

/**
 * Imagine a chatroom system where multiple users send messages. The chatroom acts as the mediator, facilitating communication between users.
*/

// Mediator Interface
interface ChatroomMediator
{
    public function showMessage(User $user, string $message): void;
}

// Concrete Mediator
class Chatroom implements ChatroomMediator
{
    public function showMessage(User $user, string $message): void
    {
        $time = date('H:i');
        echo "[{$time}] {$user->getName()}: {$message}" . PHP_EOL;
    }
}

// Colleague Class
class User
{
    private string $name;
    private ChatroomMediator $chatroom;

    public function __construct(string $name, ChatroomMediator $chatroom)
    {
        $this->name = $name;
        $this->chatroom = $chatroom;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function sendMessage(string $message): void
    {
        $this->chatroom->showMessage($this, $message);
    }
}

// Client Code
$chatroom = new Chatroom();

$user1 = new User("Alice", $chatroom);
$user2 = new User("Bob", $chatroom);

$user1->sendMessage("Hi Bob!");
$user2->sendMessage("Hello Alice!");

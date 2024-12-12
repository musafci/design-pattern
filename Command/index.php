<?php
/**
 * Imagine a text editor application where you can perform operations like adding text, removing text, and undoing actions.
 * The Command pattern helps implement these features by encapsulating each operation as a command object.
 */

// Command Interface
interface Command
{
    public function execute(): void;
    public function undo(): void;
}

// Receiver: Text Editor
class TextEditor
{
    private string $content = '';

    public function write(string $text): void
    {
        $this->content .= $text;
    }

    public function delete(int $length): void
    {
        $this->content = substr($this->content, 0, -$length);
    }

    public function getContent(): string
    {
        return $this->content;
    }
}

// Concrete Command: Write Command
class WriteCommand implements Command
{
    private TextEditor $editor;
    private string $text;

    public function __construct(TextEditor $editor, string $text)
    {
        $this->editor = $editor;
        $this->text = $text;
    }

    public function execute(): void
    {
        $this->editor->write($this->text);
    }

    public function undo(): void
    {
        $this->editor->delete(strlen($this->text));
    }
}

// Invoker: Command Manager
class CommandManager
{
    private array $history = [];

    public function executeCommand(Command $command): void
    {
        $command->execute();
        $this->history[] = $command;
    }

    public function undoLastCommand(): void
    {
        if (!empty($this->history)) {
            $lastCommand = array_pop($this->history);
            $lastCommand->undo();
        }
    }
}

// Client Code
$editor = new TextEditor();
$manager = new CommandManager();

// Write some text
$writeHello = new WriteCommand($editor, "Hello ");
$writeWorld = new WriteCommand($editor, "World!");

$manager->executeCommand($writeHello);
$manager->executeCommand($writeWorld);

echo "After writing: " . $editor->getContent() . PHP_EOL;

// Undo the last operation
$manager->undoLastCommand();
echo "After undo: " . $editor->getContent() . PHP_EOL;

// Undo again
$manager->undoLastCommand();
echo "After second undo: " . $editor->getContent() . PHP_EOL;

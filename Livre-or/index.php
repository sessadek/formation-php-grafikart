<?php 

phpinfo();
// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
require_once 'class/Message.php';
require_once 'class/GuestBook.php';
$errors = null;
$success = false;
$filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'books';
$book = new GuestBook($filename);
if(isset($_POST['username'], $_POST['message'])) {

    $message = new Message($_POST['username'], $_POST['message']);
    if(!$message->isValid()) {
        $errors = $message->getErrors();
    } else {
        
        $book->addMessage($message);
        $success = true;
        $_POST = [];
    }
    
}

$messages = $book->getMessages();

require 'header.php';
?>
    <h1>Livre d'or</h1>
    <?php if(!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($errors as $error) : ?>
                    <li><?= $error; ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
    <form action="/index.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">username</label>
            <input type="text" name="username" class="form-control" id="username" value="<?= (isset($_POST['username']) ? $_POST['username'] : '');?>" aria-describedby="usernameHelp">
        </div>
        <div class="mb-3">
            <label for="message">Comments</label>
            <textarea class="form-control" placeholder="message" name="message" id="message" style="height: 100px" aria-describedby="MessageHelp"><?= (isset($_POST['message']) ? $_POST['message'] : '');?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php if(!empty($messages)) : ?>
        <h2>VOs Messages</h2>
        <?php foreach($messages as $message) : ?>
            <?= $message->toHTML(); ?>
        <?php endforeach ?>
    <?php endif?>
<?php require 'footer.php'; ?>
use GuestBook;

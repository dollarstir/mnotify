<?php
require_once 'send.php';

$keyEr = $messageEr = $numbersEr = $senderEr = '';
$isError = false;
$key = $message = $numbers = $sender = '';
$response = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['send'] == 'send') {

        if (empty($_POST['key'])) {
            $keyEr = 'This field is required';
        } else {
            $key = $_POST['key'];
        }
        if (empty($_POST['message'])) {
            $messageEr = 'This field is required';
        } else {
            $message = $_POST['message'];
        }
        if (empty($_POST['numbers'])) {
            $numbersEr = 'This field is required';
        } else {
            $numbers = $_POST['numbers'];
        }
        if (empty($_POST['sender'])) {
            $senderEr = 'This field is required';
        } else {
            $sender = $_POST['sender'];
        }
        if (!empty($key) && !empty($message) && !empty($numbers) && !empty($sender)) {
            $send = new send();
            $send->key = $key;
            $send->message = $message;
            $send->numbers = $numbers;
            $send->sender = $sender;
            $isError = true;
            $response = $send->sendMessage();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title>Simple Bulk SMS API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="mNotify" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/style.css" />
</head>

<body>

<div class="container container-background">
    <div class="col-md-10 offset-1">
        <h2>A Simple Bulk SMS App using the MNotify SMS API</h2>
    </div>
    <hr>
    <div class="col-md-10 offset-1">
        <?php
        if (!empty($response)) {
            ?>
            <div class="alert alert-info">
                <?php echo $response ?>
            </div>
            <?php
        }
        ?>
        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="key">API Key</label>
                <input type="text" class="form-control" name="key" id="key" placeholder="Enter your API key" value="<?php if (!$isError) { echo htmlspecialchars($key); } else { echo ''; } ?>">
                <span style="color: #FF0000"><?php if (!empty($keyEr)) echo $keyEr ?></span>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Type your message"><?php if (!$isError) { echo htmlspecialchars($message); } else { echo ''; } ?></textarea>
                <span style="color: #FF0000"><?php if (!empty($messageEr)) echo $messageEr ?></span>
            </div>
            <div class="form-group">
                <label for="numbers">Phone Number(s)</label>
                <textarea class="form-control" id="numbers" name="numbers" rows="5" placeholder="Enter phone numbers separated by commas"><?php if (!$isError) { echo htmlspecialchars($numbers); } else { echo ''; } ?></textarea>
                <span style="color: #FF0000"><?php if (!empty($numbersEr)) echo $numbersEr ?></span>
            </div>
            <div class="form-group">
                <label for="sender">Sender Id</label>
                <input type="text" class="form-control" id="sender" name="sender" placeholder="Enter sender id" value="<?php if (!$isError) { echo htmlspecialchars($sender); } else { echo ''; } ?>" maxlength="11">
                <span style="color: #FF0000"><?php if (!empty($senderEr)) echo $senderEr ?></span>
            </div>
            <button type="submit" class="btn btn-dark" name="send" value="send">Send Message</button>
        </form>
    </div>
    <hr>
    <div class="col-md-10 offset-1">
        &copy; <?php echo date('Y') ?>  <a href="http://mnotify.com" target="_blank">mNotify Company Limited</a>
    </div>
</div>

</body>

</html>

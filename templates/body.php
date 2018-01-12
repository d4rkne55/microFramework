<?php $this->baseTemplate = 'index.php' ?>

<p>You are successfully running this micro framework!</p>
<br>
<?php if ($this->info) { ?>
    <h2>Some info:</h2>
    <p>
        The current relative URI:<br>
        <code><?= $this->uri ?></code>
    </p>
    <p>
        The called method:<br>
        <code><?= $this->method ?></code>
    </p>
    <p>A dump of the URL parameters passed to the method:</p>
    <pre><?php print_r($this->query); ?></pre>
<?php } ?>
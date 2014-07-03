<?php

// Load dependencies
require "../src/config.php";

?>
<html>
<head>
    <title>openMovie</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>

<h1>openMovie</h1>

<p>This is a simple application which queries the DBPedia and IMDB SPARQL endpoints for film information. You can also
    run your own custom queries against the endpoints.</p>

<ul>
    <li><a href="/">Home</a></li>
    <li><a href="query.php">Query Form</a></li>
</ul>

<form action="" method="POST">
    <label for="title">Movie Title</label>
    <input name="query" type="text"/>
    <input type="submit"/>
</form>

<?php

if (isset($_POST['query'])) {
    echo $container['IMDB']->query($_POST['query']);
    echo $container['DBPedia']->query($_POST['query']);
}

?>

</body>
</html>
<?php

// Load dependencies
require "../src/config.php";

// Stupid PHP :(
if (get_magic_quotes_gpc() and isset($_REQUEST['query'])) {
    $_REQUEST['query'] = stripslashes($_REQUEST['query']);
}
?>
<html>
<head>
    <title>openMovie</title>
</head>
<body>
<h1>openMovie</h1>

<p>Browse your favourite movies</p>

<ul>
    <li><a href = "/">Home</a></li>
    <li><a href = "query.php">Query Form</a></li>
</ul>

<div style="margin: 0.5em">
    <p>A useful reference of SPARQL endpoints with performance data can be found <a target = "_blank" href = "http://sparqles.okfn.org/performance">here</a></p>

    <?php
    print form_tag();
    print label_tag('endpoint');

    ?>
    <select name = "endpoint">
        <option value = "http://dbpedia.org/sparql">DBPPedia</option>
        <option value = "http://data.linkedmdb.org/sparql">IMDB</option>
    </select>
    <br/>
    <?php
    print text_area_tag('query', "SELECT * WHERE {\n  ?s ?p ?o\n}\nLIMIT 10", array('rows' => 10, 'cols' => 80)).'<br />';
    print check_box_tag('text') . label_tag('text', 'Plain text results').'<br />';
    print reset_tag() . submit_tag();
    print form_end_tag();


if (isset($_REQUEST['endpoint']) and isset($_REQUEST['query'])) {
    $sparql = new EasyRdf_Sparql_Client($_REQUEST['endpoint']);
    try {
        $results = $sparql->query($_REQUEST['query']);
        if (isset($_REQUEST['text'])) {
            print "<pre>".htmlspecialchars($results->dump('text'))."</pre>";
        } else {
            print $results->dump('html');
        }
    } catch (Exception $e) {
        print "<div class='error'>".$e->getMessage()."</div>\n";
    }
}

    print "<code>";
    foreach(EasyRdf_Namespace::namespaces() as $prefix => $uri) {
        print "PREFIX $prefix: &lt;".htmlspecialchars($uri)."&gt;<br />\n";
    }
    print "</code>";

    ?>
</div>


?>

</body>
</html>
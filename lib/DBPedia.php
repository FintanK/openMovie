<?php

EasyRdf_Namespace::set('category', 'http://dbpedia.org/resource/Category:');
EasyRdf_Namespace::set('dbpedia', 'http://dbpedia.org/resource/');
EasyRdf_Namespace::set('dbo', 'http://dbpedia.org/ontology/');
EasyRdf_Namespace::set('dbp', 'http://dbpedia.org/property/');

class DBPedia implements AbstractSPARQLEndpoint {

    // Our endpoint URL
    private $sparql = '';

    public function __construct() {
        $this->sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
    }

    public function query($query) {
        $limit = 3;
        $page = 0;

        if(isset($query)) {
            $output = '';
            $result = $this->sparql->query('SELECT DISTINCT *
            WHERE {
                ?film_title rdf:type <http://dbpedia.org/ontology/Film> .
                ?film_title dbpprop:name ?label . FILTER langMatches(lang(?label), "en")
                ?film_title rdfs:comment ?comment . FILTER(LANGMATCHES(LANG(?comment), "en")) .
                FILTER (REGEX(STR(?film_title), "'.$query.'", "i")) .
            } LIMIT '.$limit.' OFFSET '.$page.''
            );

            $output .= '<h3>DBPedia Results</h3>';

            foreach ($result as $row) {
                $output .= $row->label .'<br/>
                <p>'.$row->comment.'</p>
                <hr/>';
            }

            $output .=  '<p>Results: '. $result->numRows() .', Query Limit: '. $limit .'</p>';

        }
        return $output;
    }

} 
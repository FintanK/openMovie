<?php

class IMDB implements AbstractSPARQLEndpoint {

    private $sparql = '';

    public function __construct() {
        $this->sparql = new EasyRdf_Sparql_Client('http://data.linkedmdb.org/sparql');
    }

    public function query($query) {
        $limit = 3;
        $page = 0;

        if(isset($query)) {
            $output = '';
            $result = $this->sparql->query('SELECT  ?movieName WHERE {

                  ?woody  <http://data.linkedmdb.org/resource/movie/director_name> "Woody Allen".

                  ?actor <http://data.linkedmdb.org/resource/movie/title> "The Matrix".

                  ?movie  <http://data.linkedmdb.org/resource/movie/director> ?woody;
                          <http://data.linkedmdb.org/resource/movie/actor> ?actor;
                          <http://purl.org/dc/terms/title> ?movieName.
                } LIMIT '.$limit.' OFFSET '.$page.''
            );

            $output .= '<h3>IMDB Results</h3>';

            foreach ($result as $row) {
                $output .= $row->title .'<br/>';
            }

            $output .=  '<p>Results: '. $result->numRows() .', Query Limit: '. $limit .'</p>';

        }
        return $output;
    }

} 
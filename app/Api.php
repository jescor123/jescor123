<?php

namespace App;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;


use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    public function getNews($source)
    {

        try {

              $client = new GuzzleHttpClient();
              //with the code below, we can get news from multiple sources 
              $apiRequest = $client->request('GET', 'https://newsapi.org/v1/articles?source='.$source.'&sortBy=top&apiKey=f829b5d6d9af45d2ae92ebc31a7cd48e' );

              $content = json_decode($apiRequest->getBody()->getContents(), true);

             return $content['articles'];

            } catch (RequestException $e) {
              //For handling exception
              echo Psr7\str($e->getRequest());
              if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
              }
         }
    }

    


    public function getAllSources()
    {

        try {

                $client = new GuzzleHttpClient();

                $apiRequest = $client->request('GET', 'https://newsapi.org/v1/sources?language=en' );

                $content = json_decode($apiRequest->getBody()->getContents(), true);

             return $content['sources'];

            } catch (RequestException $e) {
              //For handling exception
               echo Psr7\str($e->getRequest());
               if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
          }
    }

     



}

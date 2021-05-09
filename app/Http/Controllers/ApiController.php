<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api;
use DB;
use Share;
use Facebook\Facebook;

class ApiController extends Controller
{
    

    public function newsapi(Request $request)
    {
         
        //clean all news from the database
        $this->cleanNews();

        // search news from API
        if (($_SERVER["REQUEST_METHOD"] == "POST")){
           $source = $_POST['source'];
           $split_input = explode(':', $source);
           $source = trim($split_input[0]); //trim() removes white spaces
           $data['source_name'] = $split_input[1];
        }

        if (empty($source)) {
            //Let us make `CNN` our default news source 
            $source = 'cnn';
            $data['source_name'] = 'CNN';
            $data['source_id'] = $source;
        }

        $api = new Api;
        $data['news'] = $api->getNews($source); // Passed  source id to our api model, to fetch news by the selected source
        $data['news_sources'] = $this->allSources(); //retrieve all news sources
        
        $dateSize = count($data['news']);

        for($i=0; $i < $dateSize; $i++){
            $author = $data['news'][$i]['author'];
            $title = $data['news'][$i]['title'];
            $description = $data['news'][$i]['description'];
            $url = $data['news'][$i]['url'];
            $urlToImage = $data['news'][$i]['urlToImage'];
  
            $this->saveNew($title, $description, $author, $url, $urlToImage, 0, 'nothing');
        }     
    
        return view('welcome', $data);

    }



    public function allSources()
    {
      $api = new Api;
      $allSources = $api->getAllSources(); //retrieve all news sources

      return $allSources;      
    }




    public function saveNew($title, $description, $author, $url, $urlToImage, $rating, $comment){

        DB::table('news')->insert(['title' => $title, 'description' => $description,
			    'author' => $author,'url' => $url,'urlToImage' => $urlToImage,
				'rating' => $rating, 'comment' => $comment]);	
       
    }



    public function updateNew(Request $request){

        //DD($request->all());*/
        $rate = $request->get('rate');
        $comment = $request->get('comment');
        $id_title = $request->get('id');

        DB::update("update news set rating = ".$rate.", comment = '".$comment."' where title = '".$id_title."'");
	    
        echo '<html><center>The new has been rated and commented successfully</center></html>';

    }



    public function cleanNews(){

         DB::update("delete from news");
    
    }



    public function shareNewOnFacebook(Request $request){

        $fb = new Facebook([
            'app_id' => '3588092614634723',
            'app_secret' => '301f1b1340fcc7793a72af085ead8d72',
            'default_graph_version' => 'v2.2',
        ]);
  
         //FB post content
        $message = "New shared from Nachrichten Web App";
        $title = $request->get('title');
        $link = $request->get('url');
        $description = $request->get('description');
        $picture = $request->get('urlToImage');
        
        $linkData = array(
          'message' => $message,
          'name' => $title,
          'link' => $link,
          'description' => $description,
          'picture'=>$picture,
        );

        //$pageAccessToken ='EAAyZCWem3bOMBAH9lOlTdLsE7QZAWZCfYNoroKyoIL9jY16xGFr6Q7nNrdFs8HBTZBLHZCuZAvviB0XTMXlF1NQf08d4wcFI4zKWgq7qhP26qnIZCyT7p1kre8KureQ8mib3kZAjyZBlLpFS9O9ZAPpETmKDiRvpIf5XoZD';
        $pageAccessToken = '3588092614634723|f_LdjpOpcgHBpd5RipVbbwG678A';

        try {
           $response = $fb->post('https://www.facebook.com/jescor/', $linkData, $pageAccessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
           echo 'Graph returned an error: '.$e->getMessage();
           exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
           echo 'Facebook SDK returned an error: '.$e->getMessage();
           exit;
        }
    
        $graphNode = $response->getGraphNode();

        echo '<html><center>The new has been posted on Facebook</center></html>';

    }



    public function sendNewToFacebook(){

        Share::page('http://blog.jorenvanhocht.be', 'There is an advance')->facebook();
        echo 'New sent to FB';
   
    }



}

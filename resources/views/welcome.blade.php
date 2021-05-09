<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>News Application with Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/share.js') }}"></script>

    </head>
    <body>
    <div id="appendDivNews">
        <nav class="navbar fixed-top navbar-light bg-faded" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="#">News Around the World</a>
        </nav>

            {{ csrf_field() }}
<section id="content" class="section-dropdown">
<p class="select-header"> Select a news source: </p>
<label class="select"> 
    <select name="news_sources" id="news_sources">
    <option value="{{@$source_id}} : {{@$source_name}}">{{$source_name}}</option>
    @foreach ($news_sources as $news_source)
      <option value="{{$news_source['id']}} : {{$news_source['name'] }}">{{$news_source['name']}}</option>
    @endforeach
    </select>
</label>

 </section> 
<p> News Source : {{$source_name}}</p>
    <section class="news">
    @foreach($news as $selected_news)
    <article>
        <img src="{{$selected_news['urlToImage']}}" alt="" style="width:1000px;height:600px;"/>
        <div class="text">
            <h1>{{$selected_news['title']}}</h1>
            <p style="font-size: 14px">{{$selected_news['description']}} <a href="{{$selected_news['url']}}" target="_blank"><small>read more...</small></a> </p>
            <div style="padding-top: 5px;font-size: 12px">Author: {{$selected_news['author'] or "Unknown" }}</div>
            @if($selected_news['publishedAt'] != null)
             <div style="padding-top: 5px;">Date Published: {{ Carbon\Carbon::parse($selected_news['publishedAt'])->format('l jS \\of F Y ') }}</div>
             @else
             <div style="padding-top: 5px;">Date Published: Unknown</div>

             @endif

           <!-- <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="" data-size="xs" disabled=""><br><br> -->
 
           <h3 class="product-title">Ratting and comments</h3>
           <form action="{{ route('news.update') }}" method="POST">
           {{ csrf_field() }}
              <div class="rating">
                <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="3" data-size="xs">
                <input type="hidden" name="id" required="" value="{{$selected_news['title']}}">
                <br/>
                <div class="form-group">
                     <label for="exampleFormControlTextarea1">Comments here</label>
                     <textarea class="form-control" id="exampleFormControlTextarea3" rows="3" name="comment">Write something here</textarea>
                </div>                
                <button class="btn btn-success">Submit Review</button>
              </div>
            </form>

            <form action="{{ route('news.shareOnFacebook') }}" method="POST">
            {{ csrf_field() }}
              <div>
                <input type="hidden" name="title" required="" value="{{$selected_news['title']}}">
                <input type="hidden" name="url" required="" value="{{$selected_news['url']}}">
                <input type="hidden" name="description" required="" value="{{$selected_news['description']}}">
                <input type="hidden" name="urlToImage" required="" value="{{$selected_news['urlToImage']}}">               
                <button class="btn btn-success">Share on Facebook</button>
              </div>
            </form>

        </div>
    </article>
    <br><br><br>
    @endforeach
</section>
</div>

         </body>
    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
         $("#input-id").rating();
    </script>

</html>
Step 10:
<!DOCTYPE html>
<html>
  <head>
    <title>stream_json.php</title>
    
    <!-- Libraries -->
    <script src="libs/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    
    <!-- Styling -->
    <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/poster_tile.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/modal.css" type="text/css" media="screen" title="no title" charset="utf-8">
    
    <!-- JavaScript -->
    <script src="js/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/modal.js" type="text/javascript" charset="utf-8"></script>
  </head>
  <body>
    <!-- NavBar -->
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">stream_json.php</a>
          <ul class="nav">
            <li id="home-nav-tab" class="active"><a href="#">Home</a></li>
            <li id="watching-nav-tab"><a href="#">Currently Watching</a></li>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- Modal -->
    <div class="modal hide fade" id="movie-modal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="modal-title-header"></h3>
      </div>
      <div class="modal-body">
        <img src="" id="modal-poster" class="img-polaroid" />
        
        <h4 id="modal-movie-title"></h4>
        <div id="movie-description"></div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-primary">Watch</a>
      </div>
    </div>
    
    <div id="poster-list" class="container">
      <?php
        function populate_posters($json) {
          foreach ($json->video as $index=>$video) {
            if (($index % 4) == 0) {
              echo "<div class=\"row-fluid\">";
            }
            
            echo "<div class=\"span3 poster-tile\" onclick=\"modal.open('" . $video->title . "', 'http://localhost:4881/getPoster/" . $video->id . "', '" . substr(json_encode($video->description->text), 1, -1) . "');\">";

            echo "<img src=\"http://localhost:4881/getPoster/" . $video->id . "\" class=\"img-polaroid\" onerror=\"image.error(this);\" />";
            echo "<b>" . $video->title . "</b>";
            
            echo"</div>";
            
            if ($index > 0) {
              if ((($index + 1) % 4) == 0) {
                echo"</div>";
              } else if ($index == (count($json->video) - 1)) {
                echo"</div>";
              }
            }
          }
        }
        
        function get_video_list() {
          $url = "http://localhost:4881/list";
        	$opts = array("http" =>
            array(
              "method"  => "GET",
              "timeout" => 60
            )
          );

          $context  = stream_context_create($opts);
          $result = file_get_contents($url, false, $context, -1, 40000);

          return json_decode($result);
        }
        
        $videos = get_video_list();
        populate_posters($videos);
      ?>
      
      <hr>
      <footer>
        <a href="http://nathanpc.github.com/stream.json/">stream.json</a> and <a href="http://nathanpc.github.com/stream_json.php/">stream_json.php</a> were written by <a href="http://about.me/nathanpc">Nathan Campos</a> and licensed under <a href="www.gnu.org/copyleft/gpl.html">GPLv3</a>.
      </footer>
    </div>
  </body>
</html>
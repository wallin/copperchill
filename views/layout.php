<html>
<head>
  <script src="assets/javascripts/jquery-1.7.2.min.js"></script>
  <script src="assets/javascripts/highcharts.js"></script>
  <script src="assets/javascripts/app.js"></script>
  <link href="assets/stylesheets/style.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
  <div id="fb-root"></div>
  <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
  <script type="text/javascript">
    FB.init({
      appId  : '<?=$cfg['fb_app']?>',
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true  // parse XFBML
    });
    var handleFBStatus = function (response) {
      window.location.reload();
    };
    FB.Event.subscribe('auth.login', handleFBStatus);
    FB.Event.subscribe('auth.logout', handleFBStatus);
    $(function() {
      $('#fb_logout').click(function(e) {
        FB.logout();
        e.preventDefault();
        return false;
      });
      $('#fb_login').click(function(e) {
        FB.login();
        e.preventDefault();
        return false;
      });
    });
  </script>
  <h1>Copper Chill</h1>
  <?php if($d['user']): ?>
  <script type="text/javascript">
    window.userKey = '<?php echo $d['user']->secret; ?>';
  </script>
  <span class="account-info">
    Logged in as:
    <em><?php echo $d['user']->name; ?></em>
    <a id="fb_logout" class="facebook-logout button">logout</a>
  </span>
  <?php endif; ?>


  <?php yield(); ?>
</body>
</html>

<html>
<head>
  <script src="assets/javascripts/jquery-1.7.2.min.js"></script>
  <script src="assets/javascripts/highcharts.js"></script>
  <script src="assets/javascripts/app.js"></script>
  <link href="assets/stylesheets/style.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
  <h1>Copper Chill</h1>
  <?php if($d['user']): ?>
  <script type="text/javascript">
    window.userKey = '<?php echo $d['user']->secret; ?>';
  </script>
  <span class="account-info">
    Logged in as:
    <em><?php echo $d['user']->name; ?></em>
    <a class="facebook-logout button" href="<?php echo $d['logoutUrl']; ?>">logout</a>
  </span>
  <?php endif; ?>


  <?php yield(); ?>
</body>
</html>

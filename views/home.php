<?php if($d['user']): ?>
<a href="<?php echo $d['logoutUrl']; ?>">logout</a>
<?php else: ?>
<a href="<?php echo $d['loginUrl']; ?>">login</a>
<?php endif; ?>
<?php if($d['user']->id): ?>
<div id="chart">
</div>
<script type="text/javascript">
  window.userKey = '<?php echo $d['user']->secret; ?>';
</script>
<?php endif; ?>

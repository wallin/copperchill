<?php if($d['user']->id): ?>
<div id="chart">
</div>
<script type="text/javascript">
  window.userKey = '<?php echo $d['user']->secret; ?>';
</script>
<?php endif; ?>

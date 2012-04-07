
<?php if($d['user']): ?>
<div id="chart">
</div>
<script type="text/javascript">
  window.userKey = '<?php echo $d['user']->secret; ?>';
</script>
<?php endif; ?>

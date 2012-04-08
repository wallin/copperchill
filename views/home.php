<?php if($d['user']->id): ?>
<div id="chart">
</div>
<?php else: ?>
<a class="facebook-login" href="<?php echo $d['loginUrl']; ?>">login</a>
<?php endif; ?>

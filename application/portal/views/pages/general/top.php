<h2>Top Page</h2>

<?php
// プロジェクト管理ツール
if (
	user_group('admin') ||
	user_group('manager') ||
	user_group('employee')
):
?>
<h3>業務改善</h3>
<div class="box" id="contents">
<ul>
<li><a href="/redmine/projects/improvement/issues/new">依頼する</a></li>
<li><?php echo anchor('improvement/index', '改善提案のヒント');?></li>
</ul>
</div>
<?php endif;?>

<?php
// ほげほげ
if (
	user_group('admin') ||
	user_group('manager') ||
	user_group('employee')
):
?>
<h3>ほげふが</h3>
<div class="box" id="contents">
<ul>
<li><a href="/">ほげほげほげ</a></li>
<li><a href="/">ふがふがふが</a></li>
<li><a href="/">ほげほげほげ</a></li>
<li><a href="/">ふがふがふが</a></li>
</ul>
</div>
<?php endif;?>


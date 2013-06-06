<h2>Top Page</h2>

<?php
// プロジェクト管理ツール
if (
	user_group('admin') ||
	user_group('manager') ||
	user_group('employee')
):
?>
<h3>プロジェクト管理ツール</h3>
<div class="box" id="contents">
<ul>
<li><a href="/redmine/">プロジェクト管理ツールトップ</a></li>
</ul>
</div>
<?php endif;?>



<?php
// 業務改善
if (
	user_group('admin') ||
	user_group('manager') ||
	user_group('employee')
):
?>
<h3>業務改善</h3>
<div class="box" id="contents">
<ul>
<li><?php echo anchor('improvement/index', '業務改善トップ');?></li>
</ul>
</div>
<?php endif;?>

<h2>Top Page</h2>

<h3>ツールリスト</h3>
<div class="box" id="contents">
<ul>
<?php if (user_group('admin') || user_group('manager')):?>
<li><a href="/tools/mansion_search.html">マン検ツール</a></li>
<li><a href="/addup/index.html">日次集計ツール</a></li>
<li><a href="/addup_monthly/index.html">月次集計ツール</a></li>
<?php endif;?>
</ul>
</div>

<?php if(logged_in()):?>
<ul id="navigation">
<li><?php echo anchor('', 'Top Page'); ?></li>
<?php if (user_group('admin')) echo '<li>'.anchor('delete_user', 'Delete User').'</li>';?>
<?php if (user_group('admin')) echo '<li>'.anchor('regist_user', 'Regist User').'</li>';?>
<li><?php echo anchor('logout', 'Logout'); ?></li>
</ul>
<?php endif;?>

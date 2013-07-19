<ul id="navigation">
<li><?php echo anchor('', 'Top Page'); ?></li>
<?php if(logged_in()):?>
<?php if (user_group('admin')) echo '<li>'.anchor('delete_user', 'Delete User').'</li>';?>
<?php if (user_group('admin')) echo '<li>'.anchor('regist_user', 'Regist User').'</li>';?>
<li><?php echo anchor('logout', 'Logout'); ?></li>
<?php else:?>
<li><?php echo anchor('login', 'Login'); ?></li>
<?php endif;?>
</ul>

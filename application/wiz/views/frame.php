<?php
$this->load->view($this->config->item('auth_views_root') . 'parts/header');
$data = (isset($data)) ? $data : array();
$this->load->view($this->config->item('auth_views_root') . 'pages/'.$page, $data);
$this->load->view($this->config->item('auth_views_root') . 'parts/footer');

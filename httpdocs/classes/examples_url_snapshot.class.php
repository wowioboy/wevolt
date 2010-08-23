<?

$snap_url=new url_snapshot($data['url']);
$snap_url->set_file_name($data['id']);
$snap_url->set_screen_resolution(1280,1024);
$snap_url->set_pic_width("200");
$snap_url->shot_url();

?>
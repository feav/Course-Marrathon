<?php
ob_start();
include( WPEVENTMARATHON_DIR.'template/html/single.php' );
$sidebar_content = ob_get_clean();

ob_start();
include( WPEVENTMARATHON_DIR.'template/html/pages/distance-admin-inscription.php' );

$content = ob_get_clean();

echo str_replace('{{CONTENT_ARS_PLUGIN}}
',$content,$sidebar_content);

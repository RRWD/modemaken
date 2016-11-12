<?php

require_once( CHILD_DIR . '/lib/cpt.php' );
require_once( CHILD_DIR . '/lib/general.php' );


/** Load includes for admin */
if ( is_admin() ) {
	require_once( CHILD_DIR . '/lib/admin.php' );
}

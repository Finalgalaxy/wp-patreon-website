<?php

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// don't load page if not deme mode.
// demo mode just for developers.
// default: not defined.
if ( ! defined( 'WT_DEMO_MODE' ) ) {
	die( '-1' );
}

// Get frame.
yp_frame_output();

?>
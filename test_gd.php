<?php
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "GD Library is installed!";
    print_r(gd_info());
} else {
    echo "GD Library is NOT installed!";
}
?> 
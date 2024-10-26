<?php
function is_active($uri) {
    return (strpos($_SERVER['REQUEST_URI'], $uri) !== false) ? 'active' : '';
}

?>

<?php

function console_log(string $message): void
    {
        echo '<script>console.log(' . json_encode($message) . ');</script>';
    }

?>
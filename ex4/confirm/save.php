<?php

saveData($_GET['data']);

// redirect to dashboard.php passing message about success or failure

header('Location: dashboard.php?message=' . 'success');

function saveData(string $data) {
    // log to server console (for debugging)
    error_log('Saving data: ' . $data);

    // actual saving is not important in this context
}
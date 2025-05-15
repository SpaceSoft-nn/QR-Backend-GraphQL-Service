<?php
// app/Modules/Notification/Config/notification.php

return [
    'blocking_time' => env('BLOCKING_TIME', 1),
    'max_count_attempt_confirm' => env('MAX_COUNT_ATTEMPT_CONFIRM', 5),
    'confirmation_time' => env('CONFIRMATION_TIME', 5),
];

<?php
function formatDateTime($mongoDate) {
    if ($mongoDate instanceof MongoDB\BSON\UTCDateTime) {
        return $mongoDate->toDateTime()->format('d M Y H:i');
    }
    return '-';
} 
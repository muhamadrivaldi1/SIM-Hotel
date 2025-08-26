<?php

if (!function_exists('getRoomGradient')) {
    function getRoomGradient($status) {
        switch($status) {
            case 'Available':
                return 'linear-gradient(45deg, #28a745, #20c997)';
            case 'Occupied':
                return 'linear-gradient(45deg, #dc3545, #e83e8c)';
            case 'Maintenance':
                return 'linear-gradient(45deg, #fd7e14, #ffc107)';
            case 'Out of Order':
                return 'linear-gradient(45deg, #6c757d, #495057)';
            case 'Dirty':
                return 'linear-gradient(45deg, #795548, #5d4037)';
            case 'Reserved':
                return 'linear-gradient(45deg, #6f42c1, #e83e8c)';
            default:
                return 'linear-gradient(45deg, #3498db, #2980b9)';
        }
    }
}

if (!function_exists('getStatusColor')) {
    function getStatusColor($status) {
        switch($status) {
            case 'Available':
                return '#28a745';
            case 'Occupied':
                return '#dc3545';
            case 'Maintenance':
                return '#fd7e14';
            case 'Out of Order':
                return '#6c757d';
            case 'Dirty':
                return '#795548';
            case 'Reserved':
                return '#6f42c1';
            default:
                return '#28a745';
        }
    }
}

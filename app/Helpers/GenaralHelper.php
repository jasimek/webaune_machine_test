<?php

if (!function_exists('response_api')) {
    function response_api($data, $status_code = 200, $message = null, $description = null)
    {

        if ($status_code == 200) {
            $status = true;
        } else {
            $status = false;
        }

        $response_data = ['status' => $status, 'status_code' => $status_code, 'message' => $message, 'description' => $description, 'data' => $data];

        return response()->json($response_data, $status_code);
    }
}


if (!function_exists('get_weekdays')) {
    function get_weekdays()
    {
        return [
            ['name' => 'Monday', 'value' => 'monday'],
            ['name' => 'Tuesday', 'value' => 'tuesday'],
            ['name' => 'Wednesday', 'value' => 'wednesday'],
            ['name' => 'Thursday', 'value' => 'thursday'],
            ['name' => 'Friday', 'value' => 'friday'],
            ['name' => 'Saturday', 'value' => 'saturday'],
            ['name' => 'Sunday', 'value' => 'sunday'],
        ];
    }
}

if (!function_exists('get_quarters')) {
    function get_quarters($date, $day)
    {
        $weekMap = [
            'Sunday' => 'Sun',
            'Monday' => 'Mon',
            'Tuesday' => 'Tue',
            'Wednesday' => 'Wed',
            'Thursday' => 'Thu',
            'Friday' => 'Fri',
            'Saturday' => 'Sat',
        ];

        return $weekMap[$day] . ' ' . $date . ' ' . '05:30:00 GMT+0530 (India Standard Time)';
    }
}

if (!function_exists('get_action_status')) {
    function get_action_status()
    {
        return [
            ['id' => 1, 'value' => 'new', 'name' => 'New'],
            ['id' => 2, 'value' => 'completed', 'name' => 'Completed'],
            ['id' => 3, 'value' => 'in_progress', 'name' => 'In progress'],
            ['id' => 4, 'value' => 'rejected', 'name' => 'Rejected'],
        ];
    }
}

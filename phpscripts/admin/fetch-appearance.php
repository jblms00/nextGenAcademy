<?php

function get_system_appearance($con)
{
    $fetch_appearance_query = "SELECT id, file_name, appearance_type, datetime_added FROM system_appearance";
    $fetch_appearance_result = mysqli_query($con, $fetch_appearance_query);

    if ($fetch_appearance_result && mysqli_num_rows($fetch_appearance_result) > 0) {
        $appearance = [];
        while ($row = mysqli_fetch_assoc($fetch_appearance_result)) {
            $appearance[$row['appearance_type']] = [
                'id' => $row['id'],
                'file_name' => $row['file_name'],
                'datetime_added' => $row['datetime_added']
            ];
        }
        return $appearance;
    } else {
        return null;
    }
}
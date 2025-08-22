<?php
session_start();
include("../database-connection.php");

$data = [];

$query = "
    SELECT 
        g.group_id, g.lesson_id, g.project_title, g.group_status, g.datetime_created as group_created,
        l.lesson_title, l.week_number, l.lesson_description, l.lesson_image_banner, l.datetime_created as lesson_created,
        (SELECT COUNT(m.member_id) FROM group_members m WHERE m.group_id = g.group_id) as total_members,
        (SELECT COUNT(t.task_id) FROM group_tasks t WHERE t.group_id = g.group_id) as total_tasks
    FROM lesson_group_collaborators g
    LEFT JOIN lessons l ON g.lesson_id = l.lesson_id
    ORDER BY g.datetime_created DESC
";

$result = mysqli_query($con, $query);

if ($result) {
    $groups = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $groups[] = [
            'lesson_title' => $row['lesson_title'],
            'project_title' => $row['project_title'],
            'group_status' => $row['group_status'],
            'total_members' => $row['total_members'],
            'total_tasks' => $row['total_tasks'],
            'group_id' => $row['group_id'],
            'datetime_created' => $row['group_created']
        ];
    }
    $data['status'] = "success";
    $data['groups'] = $groups;
} else {
    $data['status'] = "error";
    $data['message'] = "Failed to fetch groups.";
}
echo json_encode($data);
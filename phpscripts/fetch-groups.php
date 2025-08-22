<?php
session_start();
include("database-connection.php");

$data = [];
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$lessonId = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;

if ($lessonId > 0 && $userId > 0) {
    $sql = "
        SELECT 
            lg.group_id, 
            lg.project_title, 
            lg.group_status, 
            lg.datetime_created,
            gm.user_id AS member_id, 
            ua.user_name 
        FROM 
            lesson_group_collaborators lg
        LEFT JOIN 
            group_members gm ON lg.group_id = gm.group_id
        LEFT JOIN 
            users_accounts ua ON gm.user_id = ua.user_id
        WHERE 
            lg.lesson_id = $lessonId
    ";

    $result = mysqli_query($con, $sql);

    if ($result) {
        $data['groups'] = [];
        $groupData = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $groupId = $row['group_id'];

            if (!isset($groupData[$groupId])) {
                $groupData[$groupId] = [
                    'group_id' => $groupId,
                    'project_title' => $row['project_title'],
                    'group_status' => $row['group_status'],
                    'datetime_created' => $row['datetime_created'],
                    'members' => []
                ];
            }

            $userName = $row['member_id'] == $userId ? 'You' : $row['user_name'];
            $groupData[$groupId]['members'][] = $userName;
        }

        foreach ($groupData as &$group) {
            $you = array_filter($group['members'], fn($member) => $member === 'You');
            $others = array_filter($group['members'], fn($member) => $member !== 'You');
            $group['members'] = array_merge($you, $others);
        }

        $data['groups'] = array_values($groupData);
        $data['status'] = 'success';
    } else {
        $data['status'] = 'error';
        $data['message'] = 'No groups found for this lesson.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid lesson ID or user not logged in.';
}

echo json_encode($data);
?>
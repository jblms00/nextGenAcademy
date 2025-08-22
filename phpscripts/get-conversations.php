<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $loggedInUserId = mysqli_real_escape_string($con, $_GET['loggedInUserId']);

    // Updated query to retrieve sender details of the most recent message
    $get_conversations_query = "
        SELECT 
            c.conversation_id, 
            c.is_group, 
            (SELECT content FROM messages WHERE conversation_id = c.conversation_id ORDER BY created_at DESC LIMIT 1) AS recent_message,
            (SELECT sender_id FROM messages WHERE conversation_id = c.conversation_id ORDER BY created_at DESC LIMIT 1) AS sender_id,
            (SELECT ua.user_name FROM users_accounts ua WHERE ua.user_id = sender_id) AS sender_name, 
            (SELECT TIMESTAMPDIFF(SECOND, created_at, NOW()) FROM messages WHERE conversation_id = c.conversation_id ORDER BY created_at DESC LIMIT 1) AS time_diff,
            GROUP_CONCAT(u.user_name SEPARATOR ', ') AS participants,
            GROUP_CONCAT(u.user_photo SEPARATOR ',') AS participants_photos
        FROM conversations c 
        LEFT JOIN conversation_participants cp ON c.conversation_id = cp.conversation_id 
        LEFT JOIN users_accounts u ON cp.user_id = u.user_id 
        WHERE cp.user_id != '$loggedInUserId' OR c.is_group = 1 
        GROUP BY c.conversation_id
        ORDER BY c.updated_at DESC";

    $result = mysqli_query($con, $get_conversations_query);

    if ($result) {
        $conversations = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $seconds = (int) $row['time_diff'];
            if ($seconds < 60) {
                $row['time_ago'] = $seconds . " seconds ago";
            } elseif ($seconds < 3600) {
                $minutes = floor($seconds / 60);
                $row['time_ago'] = $minutes . " minutes ago";
            } else {
                $hours = floor($seconds / 3600);
                $row['time_ago'] = $hours . " hours ago";
            }

            if ($row['is_group']) {
                $participants = explode(', ', $row['participants']);

                $otherParticipants = array_filter($participants, function ($participant) use ($loggedInUserId, $con) {
                    // You might need to fetch user ID associated with the participant name
                    $query = "SELECT user_id FROM users_accounts WHERE user_name = '" . mysqli_real_escape_string($con, $participant) . "'";
                    $result = mysqli_query($con, $query);
                    $user = mysqli_fetch_assoc($result);
                    return $user['user_id'] != $loggedInUserId;
                });

                if (count($otherParticipants) > 0) {
                    if (count($otherParticipants) == 1) {
                        $row['conversation_name'] = "You, " . implode('', $otherParticipants);
                    } elseif (count($otherParticipants) == 2) {
                        $row['conversation_name'] = "You, " . implode(' and ', $otherParticipants);
                    } else {
                        $row['conversation_name'] = "You, " . implode(', ', array_slice($otherParticipants, 0, -1)) . " and " . end($otherParticipants);
                    }
                } else {
                    $row['conversation_name'] = "You"; // Just in case no participants found
                }

                $row['participants_photos'] = explode(',', $row['participants_photos']);
            }



            $conversations[] = $row;
        }

        $data['status'] = 'success';
        $data['conversations'] = $conversations;
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Failed to retrieve conversations.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>
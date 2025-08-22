<?php
session_start();
include("database-connection.php");

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loggedInUserId = mysqli_real_escape_string($con, $_POST['loggedInUserId']);
    $loggedInUserName = mysqli_real_escape_string($con, $_POST['loggedInUserName']);

    $selectedUsers = json_decode($_POST['selected_users'], true);

    if (is_array($selectedUsers)) {
        $is_group = count($selectedUsers) > 1 ? 1 : 0;

        $userIds = array_merge([$loggedInUserId], $selectedUsers);
        sort($userIds);
        $userIdsString = implode(',', $userIds);

        $check_conversation_query = "
            SELECT c.conversation_id 
            FROM conversations c 
            JOIN conversation_participants cp ON c.conversation_id = cp.conversation_id 
            WHERE cp.user_id IN ($userIdsString) 
            GROUP BY c.conversation_id 
            HAVING COUNT(DISTINCT cp.user_id) = " . count($userIds) . "
        ";

        $existingConversationResult = mysqli_query($con, $check_conversation_query);
        if (mysqli_num_rows($existingConversationResult) > 0) {
            $data['status'] = 'error';
            $data['message'] = 'Conversation with selected users already exists.';
        } else {
            // No existing conversation found, proceed to create a new one
            $create_conversation_query = "INSERT INTO conversations (is_group) VALUES ('$is_group')";
            $create_conversation_result = mysqli_query($con, $create_conversation_query);

            if ($create_conversation_result) {
                $conversationId = mysqli_insert_id($con);

                $add_creator_query = "INSERT INTO conversation_participants (conversation_id, user_id, joined_at) VALUES ('$conversationId', '$loggedInUserId', NOW())";
                mysqli_query($con, $add_creator_query);

                foreach ($selectedUsers as $userId) {
                    $add_user_query = "INSERT INTO conversation_participants (conversation_id, user_id, joined_at) VALUES ('$conversationId', '$userId', NOW())";
                    mysqli_query($con, $add_user_query);
                }

                $messageContent = (count($selectedUsers) > 1) ? "$loggedInUserName created a group conversation" : "$loggedInUserName created a conversation";
                $add_message_query = "INSERT INTO messages (conversation_id, sender_id, content, created_at) VALUES ('$conversationId', '$loggedInUserId', '$messageContent', NOW())";
                mysqli_query($con, $add_message_query);

                $data['status'] = 'success';
                $data['message'] = 'Conversation created successfully.';
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Failed to create conversation.';
            }
        }
    } else {
        $data['status'] = 'error';
        $data['message'] = 'Invalid user selection.';
    }
} else {
    $data['status'] = 'error';
    $data['message'] = 'Invalid request method.';
}

echo json_encode($data);
?>
const loggedInUserId = $("body").data("user-id");
const userPhoto = $("body").data("user-photo");
const userName = $("body").data("user-name");
const toastMessage = $("#liveToast .toast-body p");
$(document).ready(function () {
    loadChatList();
    displayUsers();
    createConversation();
    setupChatClick();
    handleMessageSend();
    $(".search-container input").on("keyup", function () {
        let searchValue = $(this).val().toLowerCase();
        filterChatList(searchValue);
    });

    checkScreenSize();

    $(window).resize(function () {
        checkScreenSize();
    });
});

function loadChatList() {
    $.ajax({
        url: "../phpscripts/get-conversations.php",
        data: { loggedInUserId: loggedInUserId },
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var chatListHtml = "";
                response.conversations.forEach(function (conversation) {
                    var recentMessageSender = "";

                    if (
                        conversation.recent_message ===
                        "created a group conversation"
                    ) {
                        recentMessageSender = `${conversation.sender_name} `;
                    } else {
                        recentMessageSender =
                            conversation.sender_id === loggedInUserId
                                ? "You: "
                                : `${conversation.sender_name}: `;
                    }

                    var formattedMessage = formatRecentMessage(
                        conversation.recent_message
                    );

                    var userPhoto = "";
                    if (conversation.is_group) {
                        if (
                            Array.isArray(conversation.participants_photos) &&
                            conversation.participants_photos.length > 0
                        ) {
                            userPhoto = `
                                <div class="group-photos bg-light rounded-circle border border-dark border-1" style="width: 50px; height: 50px; position: relative; overflow: hidden;">
                                    ${conversation.participants_photos
                                        .slice(0, 4)
                                        .map(
                                            (photo, index) => `
                                        <img src="../assets/images/usersProfile/${
                                            photo || "default-profile.png"
                                        }" 
                                             style="position: absolute; top: ${
                                                 Math.floor(index / 2) * 25
                                             }px; left: ${
                                                (index % 2) * 25
                                            }px; width: 25px; height: 25px; border-radius: 50%;" alt="img">
                                    `
                                        )
                                        .join("")}
                                </div>
                            `;
                        } else {
                            userPhoto = `
                                <div class="group-photos bg-light rounded-circle" style="width: 50px; height: 50px;">
                                    <img src="../assets/images/usersProfile/default-profile.png" style="width: 50px; height: 50px; border-radius: 50%;" alt="img">
                                </div>
                            `;
                        }
                    } else {
                        userPhoto = `
                            <img src="../assets/images/usersProfile/${
                                conversation.user_photo || "default-profile.png"
                            }" 
                                 class="bg-light rounded-circle" height="50" width="50" alt="img">
                        `;
                    }

                    var recentMessage = formattedMessage.includes(
                        "created a conversation"
                    )
                        ? `${formattedMessage}`
                        : `${recentMessageSender}${formattedMessage}`;

                    chatListHtml += `
                        <li data-conversation-id="${
                            conversation.conversation_id
                        }" data-is-group="${conversation.is_group}">
                            <div class="user-profile">
                                ${userPhoto}
                            </div>
                            <div class="user-data">
                                <h5 class="mb-0">${
                                    conversation.conversation_name ||
                                    conversation.participants
                                }</h5>
                                <p class="recent-messages">${recentMessage}</p>
                                <small class="text-danger fw-semibold">${
                                    conversation.time_ago
                                }</small>
                            </div>
                        </li>
                    `;
                });
                $(".chat-list").html(chatListHtml);
            } else {
                $(".chat-list").html(
                    '<p class="text-danger">Failed to load conversations.</p>'
                );
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function setupChatClick() {
    $(document).on("click", ".chat-list li", function () {
        $(".main-chat-container .chat-container .chat-box").css(
            "height",
            "650px"
        );
        $(".chat-box").empty();
        $(".chat-header, .chat-input").removeClass("d-none");
        $(".chat-list li").removeClass("active");
        $(this).addClass("active");

        var conversationId = $(this).data("conversation-id");
        var isGroupChat = $(this).data("is-group");
        var chatMateName = $(this).find(".user-data h5").text();

        $(".chat-header").empty();

        var photosHtml = "";
        if (isGroupChat) {
            var chatMatePhoto = $(this).find(".group-photos").html() || "";
            photosHtml = `
                <div class="group-photos bg-light rounded-circle border border-dark border-1" style="width: 50px; height: 50px; position: relative; overflow: hidden;">
                    ${chatMatePhoto}
                </div>
                <h4 class="mb-0">${chatMateName}</h4>
            `;
            $(".chat-header").append(photosHtml);
        } else {
            var userPhoto = $(this).find(".user-profile img").attr("src");
            photosHtml = `
                    <img src="${userPhoto}" class="rounded-circle bg-light" style="width: 50px; height: 50px;">
                    <h4 class="mb-0">${chatMateName}</h4>
                `;

            $(".chat-header").append(photosHtml);
        }

        $(".chat-header h4").text(chatMateName);
        loadMessages(conversationId);
    });
}

function formatRecentMessage(message) {
    var words = message.split(" ");
    if (words.length > 8) {
        return words.slice(0, 8).join(" ") + "...";
    }
    return message;
}

function displayUsers() {
    $(document).on("click", ".add-conversation", function () {
        $.ajax({
            url: "../phpscripts/get-users.php",
            data: { loggedInUserId: loggedInUserId },
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#usersModal").modal("show");
                    var usersHtml = "";
                    response.users.forEach(function (user) {
                        usersHtml += `
                            <div class="form-check">
                                <input class="form-check-input select-user" type="checkbox" value="${user.user_id}" id="user_${user.user_id}">
                                <label class="form-check-label" for="user_${user.user_id}">
                                    <img src="../assets/images/usersProfile/${user.user_photo}" class="rounded-circle" height="30" width="30" alt="User Photo">
                                    ${user.user_name}
                                </label>
                            </div>
                        `;
                    });
                    $("#usersContainer").html(usersHtml);
                } else {
                    $("#usersContainer").html(
                        '<p class="text-danger">Failed to load users.</p>'
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    });
}

function createConversation() {
    $(document).on("click", "#createConversationBtn", function () {
        let selectedUsers = [];
        $(".select-user:checked").each(function () {
            selectedUsers.push($(this).val());
        });

        if (selectedUsers.length === 0) {
            toastMessage
                .text("Please select at least one user.")
                .addClass("text-danger")
                .removeClass("text-success");
            $("#liveToast").toast("show");
            return;
        }

        $.ajax({
            url: "../phpscripts/user-create-conversation.php",
            method: "POST",
            data: {
                selected_users: JSON.stringify(selectedUsers),
                loggedInUserId: loggedInUserId,
                loggedInUserName: userName,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastMessage
                        .text(response.message)
                        .addClass("text-success")
                        .removeClass("text-danger");
                    $("#liveToast").toast("show");

                    $("#usersModal").modal("hide");
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    toastMessage
                        .text(response.message)
                        .addClass("text-danger")
                        .removeClass("text-success");
                    $("#liveToast").toast("show");
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    });
}

function loadMessages(conversationId) {
    $.ajax({
        url: "../phpscripts/get-messages.php",
        data: { conversation_id: conversationId },
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                $(".chat-box").empty();
                let messagesHtml = "";
                response.messages.forEach(function (message) {
                    var chatClass =
                        parseInt(message.sender_id) === parseInt(loggedInUserId)
                            ? "chat right"
                            : "chat left";

                    messagesHtml += `
                        <div class="${chatClass}">
                            <span>
                                <img src="../assets/images/usersProfile/${
                                    message.sender_photo
                                }" width="40" height="40" class="rounded-circle object-fit-cover" alt="User Photo">
                            </span>
                            <div class="message">
                                <p class="mb-0">${message.content}</p>
                            </div>
                            <small class="text-center">${formatDate(
                                message.created_at
                            )}</small>
                        </div>
                    `;
                });
                $(".chat-box").prepend(messagesHtml);
                $(".chat-box").scrollTop(0);
            } else {
                $(".chat-box").html(
                    '<p class="text-danger">Failed to load messages.</p>'
                );
            }
        },
        error: function (xhr, status, error) {
            console.error("Error loading messages: ", error);
        },
    });
}

function handleMessageSend() {
    $(document).on("keypress", ".chat-input input", function (event) {
        if (event.which === 13) {
            var messageContent = $(this).val().trim();
            var conversationId = $(".chat-list li.active").data(
                "conversation-id"
            );
            if (messageContent && conversationId) {
                $.ajax({
                    url: "../phpscripts/user-send-chat.php",
                    method: "POST",
                    data: {
                        conversation_id: conversationId,
                        sender_id: loggedInUserId,
                        content: messageContent,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            $(".chat-input input").val("");
                            loadMessages(conversationId);
                        } else {
                            toastMessage
                                .text(response.message)
                                .addClass("text-danger")
                                .removeClass("text-success");
                            $("#liveToast").toast("show");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    },
                });
            }
        }
    });
}

function filterChatList(searchValue) {
    let chatItems = $(".chat-list li");
    let found = false;

    $(".chat-list").empty();

    if (searchValue.trim() === "") {
        loadChatList();
        $(".no-conversation-message").hide();
        return;
    }

    chatItems.each(function () {
        let chatName = $(this)
            .find(".user-data h5")
            .text()
            .toLowerCase()
            .trim();

        if (chatName.includes(searchValue.toLowerCase().trim())) {
            found = true;
            $(".chat-list").append($(this).clone());
        }
    });

    if (!found) {
        $(".chat-list").html(
            '<p class="text-danger text-center fw-semibold mt-5">No conversation found.</p>'
        );
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString(undefined, {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    });
}

function checkScreenSize() {
    if (window.innerWidth <= 767) {
        $(".main-chat-container").hide();
        if ($(".mobile-message").length === 0) {
            $(".home-section").append(
                '<div class="mobile-message text-center text-danger fw-semibold" style="padding: 20px;">This feature is optimized for tablet, laptop, or desktop devices. Please switch to a larger device to continue.</div>'
            );
        }
    } else {
        $(".main-chat-container").show();
        $(".mobile-message").remove();
    }
}

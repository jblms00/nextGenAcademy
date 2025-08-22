const YOUTUBE_API_KEY = "AIzaSyDuIFYKViKEKq9B6XnT_WuMZayRV8eRpao";
const userPhoto = $("body").data("user-photo");
const loggedInUserId = $("body").data("user-id");

$(document).ready(function () {
	var urlParams = new URLSearchParams(window.location.search);
	var lessonId = urlParams.get("id");
	var weekNumber = urlParams.get("weekNumber");
	var videoCode = urlParams.get("video");
	var videoIdFragment = window.location.hash;
	var videoId = "";

	if (videoIdFragment) {
		videoId = videoIdFragment.replace("#", "");
	}

	console.log(videoId);

	displayVideoLecture(lessonId, weekNumber, videoCode, videoId);

	$("#messageInput").on("keypress", function (event) {
		if (event.which === 13) {
			sendMessage(videoId);
		}
	});
});

function displayVideoLecture(lessonId, weekNumber, videoCode, videoId) {
	if (videoCode) {
		var embedUrl = `https://www.youtube.com/embed/${videoCode}`;

		var containerHtml = `
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="text-uppercase fw-bold">Video Lecture for Lesson Week ${weekNumber}</h2>
                <a href="lecture?weekNumber${weekNumber}&id${lessonId}" class="btn btn-primary rounded-pill py-0" style="width: 10%">Finish Lecture</a>
            </div>
            <div class="row mb-5">
                <div class="col">
                    <div class="video-container">
                        <iframe width="100%" height="500" src="${embedUrl}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-3">
                    <div class="chat-container">
                        <div class="chat-body">
                            <div class="message-container" id="chatContainer"></div>
                        </div>
                        <div class="input-container">
                            <input type="text" id="messageInput" placeholder="Enter your message here" class="form-control m-0"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4 class="fw-bold">Watch other video lectures from this Week ${weekNumber} Lessons</h4>
                    <div class="other-lectures-list">
                        <!-- Other video lectures will be displayed here -->
                    </div>
                </div>
            </div>
        `;
		$(".container-video-lecture").html(containerHtml);

		fetchOtherLectures(weekNumber, videoCode);
		fetchLectureMessages(videoId);
	} else {
		$(".container-video-lecture").html("<p>No video found.</p>");
	}
}

function fetchOtherLectures(weekNumber, currentVideoCode) {
	$.ajax({
		url: `../phpscripts/fetch-other-lectures.php?weekNumber=${weekNumber}`,
		method: "GET",
		dataType: "json",
		success: function (response) {
			if (response.status === "success") {
				var otherLectures = response.lectures;
				var otherLecturesHtml = "";

				otherLectures.forEach(function (lecture) {
					if (lecture.video_id !== currentVideoCode) {
						fetchYouTubeTitle(lecture.video_id, function (videoTitle) {
							otherLecturesHtml += `
                                <p class="mb-0">
                                    <a href="videoLecture?id=${lecture.lesson_id}&weekNumber=${lecture.week_number}&video=${lecture.video_id}" class="text-decoration-none fw-semibold">
                                        ${videoTitle}
                                    </a>
                                </p>
                                <hr class="divider mt-0">
                            `;
							$(".other-lectures-list").html(otherLecturesHtml);
						});
					}
				});

				if (otherLectures.length === 0) {
					otherLecturesHtml =
						"<p>No other video lectures available for this week.</p>";
					$(".other-lectures-list").html(otherLecturesHtml);
				}
			} else {
				console.error("Error fetching other lectures: " + response.message);
				$(".other-lectures-list").html(
					"<p>Error loading other lectures.</p>"
				);
			}
		},
		error: function (xhr, status, error) {
			console.error(error);
		},
	});
}

function fetchYouTubeTitle(videoCode, callback) {
	var apiUrl = `https://www.googleapis.com/youtube/v3/videos?id=${videoCode}&key=${YOUTUBE_API_KEY}&part=snippet`;

	$.get(apiUrl, function (data) {
		if (data.items && data.items.length > 0) {
			var videoTitle = data.items[0].snippet.title;
			callback(videoTitle);
		} else {
			callback("Unknown Title");
		}
	}).fail(function () {
		callback("Unknown Title");
	});
}

function fetchLectureMessages(videoLecturesId) {
	$.ajax({
		url: `../phpscripts/fetch-conversations.php?video_lectures_id=${videoLecturesId}`,
		method: "GET",
		dataType: "json",
		success: function (response) {
			if (response.status === "success") {
				var messages = response.messages;
				var messageHtml = "";

				if (messages.length === 0) {
					$("#chatContainer")
						.html(
							`<h6 class="text-center text-light fw-bold">No messages yet.</h6>`
						)
						.css("justify-content", "center");
				} else {
					$("#chatContainer").css("justify-content", "");

					messages.forEach(function (message) {
						var chatClass =
							message.user_id === loggedInUserId
								? "chat left"
								: "chat right";
						messageHtml += `
                            <div class="${chatClass}">
                                <span>
                                    <img src="../assets/images/usersProfile/${message.user_photo}" width="100%" height="30" alt="User Photo">
                                </span>
                                <div class="message">
                                    <p class="mb-0">${message.message_content}</p>
                                </div>
                            </div>
                        `;
					});

					$("#chatContainer").html(messageHtml);
				}
			} else {
				console.error("Error fetching messages: " + response.message);
				$("#chatContainer").html("<p>Error loading messages.</p>");
			}
		},
		error: function (xhr, status, error) {
			console.error(error);
		},
	});
}

function sendMessage(videoId) {
	var messageContent = $("#messageInput").val().trim();

	console.log(videoId);

	$.ajax({
		url: "../phpscripts/user-send-message.php",
		method: "POST",
		data: {
			video_lectures_id: videoId,
			message_content: messageContent,
			user_id: loggedInUserId,
		},
		dataType: "json",
		success: function (response) {
			if (response.status === "success") {
				var messageHtml = `
                    <div class="chat right">
                        <span>
                            <img src="../assets/images/usersProfile/${userPhoto}" width="100%" height="30" alt="User Photo">
                        </span>
                        <div class="message">
                            <p class="mb-0">${messageContent}</p>
                        </div>
                    </div>
                `;
				$("#chatContainer").prepend(messageHtml);
				$("#messageInput").val("");
				$("#chatContainer").find("h6.text-light").remove();
				$("#chatContainer").css("justify-content", "");
			} else {
				console.error("Error sending message: " + response.message);
			}
		},
		error: function (xhr, status, error) {
			console.error(error);
		},
	});
}

const url = window.location.href;
const weekNumberMatch = url.match(/weekNumber(\d+)/);
const weekNumber = weekNumberMatch ? weekNumberMatch[1] : null;
const lessonIdMatch = url.match(/id(\d+)/);
const lessonId = lessonIdMatch ? lessonIdMatch[1] : null;

$(document).ready(function () {
	displayLectures();
});

function displayLectures() {
	$.ajax({
		url: "../phpscripts/fetch-lectures.php?weekNumber=" + weekNumber,
		method: "GET",
		dataType: "json",
		success: function (response) {
			if (response.status === "success") {
				var lectures = response.lectures;
				var lecturesHtml = "";

				var titlePromises = [];

				lectures.forEach(function (lecture) {
					var videoCode = getYouTubeID(lecture.video_url);
					var newPageUrl = `videoLecture?id=${lecture.lesson_id}&weekNumber=${lecture.week_number}&video=${videoCode}&vid#${lecture.video_lectures_id}`;
					var thumbnailUrl = `https://img.youtube.com/vi/${videoCode}/hqdefault.jpg`;

					titlePromises.push(
						fetchYouTubeVideoTitle(videoCode).then((video_title) => {
							lecturesHtml += `
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">${video_title}</h5>
                                            <a href="${newPageUrl}" style="display: block; text-decoration: none; color: inherit;">
                                                <img src="${thumbnailUrl}" alt="Video Thumbnail" width="100%" height="340" style="object-fit:contain; border-radius: 8px;">
                                            </a>
                                        </div>
                                    </div>
                                `;
						})
					);
				});

				Promise.all(titlePromises).then(() => {
					$(".container-video-lectures").html(lecturesHtml);
				});
			} else {
				console.error("Error fetching lectures: " + response.message);
				$(".container-video-lectures").html(`<p>${response.message}</p>`);
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function fetchYouTubeVideoTitle(videoCode) {
	return new Promise((resolve, reject) => {
		var apiKey = "AIzaSyDuIFYKViKEKq9B6XnT_WuMZayRV8eRpao";
		$.ajax({
			url: `https://www.googleapis.com/youtube/v3/videos?id=${videoCode}&key=${apiKey}&part=snippet`,
			method: "GET",
			dataType: "json",
			success: function (data) {
				if (data.items && data.items.length > 0) {
					var videoTitle = data.items[0].snippet.title;
					resolve(videoTitle);
				} else {
					resolve("Title not found");
				}
			},
			error: function (xhr, status, error) {
				console.error("Error fetching video title: " + error);
				resolve("Error fetching title");
			},
		});
	});
}

function getYouTubeID(url) {
	var videoCode = null;
	var regex =
		/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&\n]{11})/;
	var matches = url.match(regex);
	if (matches) {
		videoCode = matches[1];
	}
	return videoCode;
}

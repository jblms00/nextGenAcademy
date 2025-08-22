function formatDateTime(datetime) {
    var options = { year: "numeric", month: "long", day: "numeric" };
    var date = new Date(datetime);

    var timeOptions = { hour: "numeric", minute: "numeric", hour12: true };
    var timeString = date.toLocaleString("en-US", timeOptions);
    var dateString = date.toLocaleDateString("en-US", options);

    return `${timeString} at ${dateString}`;
}

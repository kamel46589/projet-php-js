function openPopup(url, width, height) {
    // Calculate the position to center the window
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;

    // Open the popup window
    window.open(url, "_blank", "width=" + width + ",height=" + height + ",left=" + left + ",top=" + top);
}
document.addEventListener('DOMContentLoaded', function() {
    var img = new Image();
    img.src = "http://127.0.0.1:8000/images/hero-background.jpg";
    img.onload = function() {
        document.body.style.setProperty('--bg-lava', 'url(http://127.0.0.1:8000/images/hero-background.jpg)');
    };
});

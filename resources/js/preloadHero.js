document.addEventListener('DOMContentLoaded', function() {
    var img = new Image();
    img.src = "https://inzenjertim.com/images/hero-background.jpg";
    img.onload = function() {
        document.body.style.setProperty('--bg-lava', 'url(https://inzenjertim.com/images/hero-background.jpg)');
    };
});

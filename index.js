    // Aplica opacidade na seta com base no scroll
    window.addEventListener('scroll', function () {
        var topWindow = window.scrollY * 1.5;
        var windowHeight = window.innerHeight;
        var position = 1 - topWindow / windowHeight;
        document.querySelector('.arrow-wrap')?.style.setProperty('opacity', position);
    });
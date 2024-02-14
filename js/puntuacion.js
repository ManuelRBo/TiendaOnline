var estrellas = document.querySelectorAll('.puntuacion .estrella');

    estrellas.forEach(function (estrella, index) {
        estrella.addEventListener('mouseover', function () {
            // Iterar sobre todas las estrellas hasta la actual y cambiar su color de relleno
            for (var i = 0; i <= index; i++) {
                estrellas[i].querySelector('svg polygon').style.fill = '#FFEC00';
            }
        });

        estrella.addEventListener('mouseout', function () {
            // Volver al color original para todas las estrellas
            estrellas.forEach(function (e) {
                e.querySelector('svg polygon').style.fill = 'transparent';
            });
        });
    });
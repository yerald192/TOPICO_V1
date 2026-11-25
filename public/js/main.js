// ==========================================================
// COMPORTAMIENTOS JAVASCRIPT GLOBALES (TOPICO MVC V2)
// ==========================================================

document.addEventListener('DOMContentLoaded', () => {
    // 1. Auto-cierre de alertas flash después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 400);
        }, 5000);
    });

    // 2. Cálculo automático de edad si se selecciona Fecha de Nacimiento
    const inputFechaNac = document.getElementById('fecha_nacimiento');
    const inputEdad = document.getElementById('edad');

    if (inputFechaNac && inputEdad) {
        inputFechaNac.addEventListener('change', () => {
            const fecha = new Date(inputFechaNac.value);
            if (!isNaN(fecha.getTime())) {
                const hoy = new Date();
                let edad = hoy.getFullYear() - fecha.getFullYear();
                const m = hoy.getMonth() - fecha.getMonth();
                if (m < 0 || (m === 0 && hoy.getDate() < fecha.getDate())) {
                    edad--;
                }
                if (edad >= 0 && edad <= 120) {
                    inputEdad.value = edad;
                }
            }
        });
    }
});

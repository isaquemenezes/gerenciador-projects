export default function autoDismissFlashMessage() {
    document.addEventListener('DOMContentLoaded', () => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            setTimeout(() => {
                flash.classList.remove('show');
                flash.classList.add('fade');
                flash.style.transition = 'opacity 0.5s ease';
                flash.style.opacity = 0;
                setTimeout(() => flash.remove(), 500);
            }, 3000);
        }
    });
}

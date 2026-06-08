document.addEventListener('DOMContentLoaded', () => {
    const toasts = document.querySelectorAll('.toast');

    if (toasts.length > 0) {
        setTimeout(() => {
            toasts.forEach((toast) => {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';

                setTimeout(() => {
                    toast.remove();
                }, 500);
            });
        }, 2500);
    }
});
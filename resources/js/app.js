import './bootstrap';
import Alpine from 'alpinejs';

// ─── Alpine.js ───────────────────────────────────────────────────────────
window.Alpine = Alpine;
Alpine.start();


// ─── Notification Helper ─────────────────────────────────────────────────
window.showNotification = function (message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium animate-slide-down ${
        type === 'success' ? 'bg-primary-600' :
        type === 'error' ? 'bg-red-600' :
        'bg-amber-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
};

// ─── Format Currency ─────────────────────────────────────────────────────
window.formatCurrency = function (amount) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
    }).format(amount);
};

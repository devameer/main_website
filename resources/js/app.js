import Chart from 'chart.js/auto';
import { marked } from 'marked';
import hljs from 'highlight.js/lib/common';
import 'highlight.js/styles/github-dark-dimmed.css';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Expose globals used by inline scripts (charts), Alpine stores, and the markdown editor.
window.Chart = Chart;
window.Alpine = Alpine;
window.marked = marked;
window.hljs = hljs;

// Persist + apply theme before Livewire boots to avoid flash.
window.applyTheme = (theme) => {
    const isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
};

// ---- Toast store (shared via Alpine.store('toasts')) ----
document.addEventListener('alpine:init', () => {
    if (Alpine.store('toasts')) return;
    Alpine.store('toasts', {
        items: [],
        push(type, message, title = null) {
            const id = Date.now() + Math.random();
            this.items.push({ id, type, message, title });
            setTimeout(() => this.dismiss(id), type === 'error' ? 6000 : 3800);
        },
        success(m, t) { this.push('success', m, t); },
        error(m, t) { this.push('error', m, t); },
        warning(m, t) { this.push('warning', m, t); },
        info(m, t) { this.push('info', m, t); },
        dismiss(id) { this.items = this.items.filter((i) => i.id !== id); },
    });
});

// Livewire dispatches `notify` → push into toast store.
const routeNotify = (detail) => {
    const store = Alpine.store('toasts');
    if (!store) return;
    const { type = 'info', message, title } = detail || {};
    store.push(type, message, title);
};
document.addEventListener('livewire:init', () => {
    Livewire.on('notify', (e) => routeNotify(Array.isArray(e) ? e[0] : e));
});

// Boot Livewire (this also boots Alpine).
Livewire.start();

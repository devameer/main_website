// Lazy syntax highlighting — only loaded when a page actually has code blocks.
// Keeps highlight.js (~50KB) off every page; loaded on-demand via dynamic import.
document.addEventListener('DOMContentLoaded', () => {
    const blocks = document.querySelectorAll('pre code');
    if (!blocks.length) return;

    import('highlight.js/lib/common').then(({ default: hljs }) => {
        import('highlight.js/styles/github-dark-dimmed.css');
        blocks.forEach((el) => hljs.highlightElement(el));
    });
});

// Mobile nav toggle — Alpine is loaded by Livewire on pages that need it,
// but for pages without Livewire we wire it manually here.
window.siteNav = () => ({
    open: false,
    toggle() { this.open = !this.open; },
    close() { this.open = false; },
});

// Copy email to clipboard
window.copyEmail = (email) => {
    navigator.clipboard?.writeText(email).then(() => {
        const el = document.getElementById('email-copied');
        if (el) {
            el.classList.remove('opacity-0');
            setTimeout(() => el.classList.add('opacity-0'), 2000);
        }
    });
};

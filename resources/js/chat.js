import hljs from 'highlight.js';
import 'highlight.js/styles/github-dark.css';

window.hljs = hljs;

document.addEventListener('DOMContentLoaded', () => {

    const chatBox = document.getElementById('chat-box');

    if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    document.querySelectorAll('pre').forEach((pre) => {

        const code = pre.querySelector('code');

        if (!code) return;

        hljs.highlightElement(code);

        pre.classList.add('relative');

        const button = document.createElement('button');

        button.className =
            'copy-btn absolute top-1 right-1 p-1 rounded-md text-slate-400 hover:text-white';

        button.innerHTML = `
<svg xmlns="http://www.w3.org/2000/svg"
     width="16"
     height="16"
     viewBox="0 0 24 24"
     fill="none"
     stroke="currentColor"
     stroke-width="2">
    <rect x="9" y="9" width="13" height="13" rx="2"/>
    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
</svg>
`;

        pre.appendChild(button);

    });

});

document.addEventListener('click', async (e) => {

    const btn = e.target.closest('.copy-btn');

    if (!btn) return;

    const codeEl = btn.parentElement.querySelector('code');

    if (!codeEl) return;

    const text = codeEl.innerText;

    try {

        await navigator.clipboard.writeText(text);

        btn.innerHTML = `
<svg xmlns="http://www.w3.org/2000/svg"
     width="16"
     height="16"
     viewBox="0 0 24 24"
     fill="none"
     stroke="currentColor"
     stroke-width="2">
    <polyline points="20 6 9 17 4 12"/>
</svg>
`;

        setTimeout(() => {

            btn.innerHTML = `
<svg xmlns="http://www.w3.org/2000/svg"
     width="16"
     height="16"
     viewBox="0 0 24 24"
     fill="none"
     stroke="currentColor"
     stroke-width="2">
    <rect x="9" y="9" width="13" height="13" rx="2"/>
    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
</svg>
`;

        }, 2000);

    } catch (err) {

        console.error('Failed to copy:', err);

    }

});

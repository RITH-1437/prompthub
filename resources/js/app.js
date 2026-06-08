import './bootstrap';
import './copyPrompt';
import './toast';
import './settings';
import './chat';
// 1. Import 'icons' alongside 'createIcons'
import { createIcons, icons } from 'lucide';

// 2. Attach both to the window object
window.lucide = { createIcons, icons };

document.addEventListener('DOMContentLoaded', () => {
    // 3. Pass the icons object into the function
    createIcons({ icons });
});
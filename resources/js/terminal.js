export function initTerminal() {

    const container =
        document.getElementById('terminal-lines');

    if (!container) return;

    const commands = [
        '$ php artisan portfolio:load',
        '✓ Loading Projects',
        '✓ Loading Experience',
        '✓ Loading Skills',
        '✓ Loading Certifications',
        '',
        '$ composer show',
        'Laravel 12',
        'Livewire 4',
        'Filament 5',
        '',
        '$ whoami',
        'Muhammad Ahmed',
        'Laravel Developer',
        '',
        '$ skills',
        'PHP',
        'Laravel',
        'Livewire',
        'Filament',
        'MySQL',
        'Three.js',
        '',
        '$ status',
        'Open to opportunities'
    ];

    let commandIndex = 0;
    let charIndex = 0;

    let currentLine =
        document.createElement('div');

    container.appendChild(currentLine);

    function type() {

        if (commandIndex >= commands.length) {

            currentLine.innerHTML +=
                '<span class="cursor"></span>';

            return;
        }

        const text =
            commands[commandIndex];

        if (charIndex < text.length) {

            currentLine.textContent +=
                text.charAt(charIndex);

            charIndex++;

            setTimeout(
                type,
                20 + Math.random() * 30
            );

            return;
        }

        currentLine.classList.add(
            text.startsWith('$')
                ? 'term-command'
                : 'term-success'
        );

        commandIndex++;
        charIndex = 0;

        currentLine =
            document.createElement('div');

        container.appendChild(currentLine);

        setTimeout(type, 250);
    }

    type();
}
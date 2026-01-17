<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel Claude Toolkit') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700&display=swap" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <style>
            body {
                font-family: 'JetBrains Mono', monospace;
                background-color: #030712;
                color: #4ade80;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1.5rem;
                margin: 0;
            }
            .terminal-cursor {
                animation: blink 1s step-end infinite;
            }
            @keyframes blink {
                50% { opacity: 0; }
            }
            main { max-width: 42rem; width: 100%; }
            .terminal-window { border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 0.5rem; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(34, 197, 94, 0.1); }
            .terminal-header { background-color: #111827; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid rgba(34, 197, 94, 0.2); }
            .terminal-dots { display: flex; gap: 0.375rem; }
            .terminal-dot { width: 0.75rem; height: 0.75rem; border-radius: 50%; }
            .dot-red { background-color: rgba(239, 68, 68, 0.8); }
            .dot-yellow { background-color: rgba(234, 179, 8, 0.8); }
            .dot-green { background-color: rgba(34, 197, 94, 0.8); }
            .terminal-path { font-size: 0.75rem; color: #6b7280; margin-left: 0.5rem; }
            .terminal-content { background-color: #030712; padding: 1.5rem; }
            .terminal-content > * + * { margin-top: 1rem; }
            pre { font-size: 0.75rem; line-height: 1.25; margin: 0; }
            .cmd-line { display: flex; gap: 0.5rem; }
            .prompt { color: #6b7280; }
            .cmd { color: #22d3ee; }
            .file { color: #facc15; }
            .output { padding-left: 1rem; color: #d1d5db; }
            .json-key { color: #a78bfa; }
            .json-value { color: #86efac; }
            .links { padding-top: 1rem; border-top: 1px solid rgba(34, 197, 94, 0.2); display: flex; flex-wrap: wrap; gap: 0.75rem; font-size: 0.75rem; margin-top: 1rem; }
            .link { padding: 0.375rem 0.75rem; border: 1px solid rgba(34, 197, 94, 0.5); border-radius: 0.25rem; text-decoration: none; transition: all 0.2s; }
            .link:hover { background-color: rgba(34, 197, 94, 0.1); border-color: #4ade80; }
            .bracket { color: #6b7280; }
            .link-text { color: #4ade80; }
            .terminal-footer { background-color: #111827; padding: 0.5rem 1rem; font-size: 0.75rem; color: #4b5563; border-top: 1px solid rgba(34, 197, 94, 0.2); }
            .footer-prompt { color: rgba(34, 197, 94, 0.5); }
            .page-footer { text-align: center; color: #4b5563; font-size: 0.75rem; margin-top: 1.5rem; }
            .heart { color: #ef4444; }
            .coffee { color: #eab308; }
            @media (min-width: 640px) { pre { font-size: 0.875rem; } }
        </style>
    </head>
    <body>
        <main>
            <div class="terminal-window">
                <div class="terminal-header">
                    <div class="terminal-dots">
                        <span class="terminal-dot dot-red"></span>
                        <span class="terminal-dot dot-yellow"></span>
                        <span class="terminal-dot dot-green"></span>
                    </div>
                    <span class="terminal-path">~/chemaclass/laravel-claude-toolkit</span>
                </div>

                <div class="terminal-content">
                    <pre>
 _                              _    ____ _                 _
| |    __ _ _ __ __ ___   _____| |  / ___| | __ _ _   _  __| | ___
| |   / _` | '__/ _` \ \ / / _ \ | | |   | |/ _` | | | |/ _` |/ _ \
| |__| (_| | | | (_| |\ V /  __/ | | |___| | (_| | |_| | (_| |  __/
|_____\__,_|_|  \__,_| \_/ \___|_|  \____|_|\__,_|\__,_|\__,_|\___|
                          _____ ___   ___  _     _  _____ _____
                         |_   _/ _ \ / _ \| |   | |/ /_ _|_   _|
                           | || | | | | | | |   | ' / | |  | |
                           | || |_| | |_| | |___| . \ | |  | |
                           |_| \___/ \___/|_____|_|\_\___| |_|
                    </pre>

                    <div>
                        <p class="cmd-line">
                            <span class="prompt">$</span>
                            <span class="cmd">whoami</span>
                        </p>
                        <p class="output">
                            A Laravel 12 starter kit optimized for AI-assisted development
                        </p>

                        <p class="cmd-line" style="margin-top: 0.75rem;">
                            <span class="prompt">$</span>
                            <span class="cmd">cat</span>
                            <span class="file">stack.json</span>
                        </p>
                        <div class="output">
                            <p>{</p>
                            <p style="padding-left: 1rem;">"<span class="json-key">php</span>": "<span class="json-value">8.4</span>",</p>
                            <p style="padding-left: 1rem;">"<span class="json-key">laravel</span>": "<span class="json-value">12</span>",</p>
                            <p style="padding-left: 1rem;">"<span class="json-key">database</span>": "<span class="json-value">SQLite</span>",</p>
                            <p style="padding-left: 1rem;">"<span class="json-key">frontend</span>": "<span class="json-value">Vite + Tailwind CSS 4</span>",</p>
                            <p style="padding-left: 1rem;">"<span class="json-key">container</span>": "<span class="json-value">Laravel Sail</span>"</p>
                            <p>}</p>
                        </div>

                        <p class="cmd-line" style="margin-top: 0.75rem;">
                            <span class="prompt">$</span>
                            <span class="cmd">echo</span>
                            <span class="file">"Ready to build something awesome?"</span>
                            <span class="terminal-cursor">_</span>
                        </p>
                    </div>

                    <div class="links">
                        <a href="https://github.com/Chemaclass/laravel-claude-toolkit" target="_blank" class="link">
                            <span class="bracket">[</span><span class="link-text">GitHub</span><span class="bracket">]</span>
                        </a>
                        <a href="https://laravel.com/docs" target="_blank" class="link">
                            <span class="bracket">[</span><span class="link-text">Laravel Docs</span><span class="bracket">]</span>
                        </a>
                        <a href="https://chemaclass.com" target="_blank" class="link">
                            <span class="bracket">[</span><span class="link-text">@Chemaclass</span><span class="bracket">]</span>
                        </a>
                    </div>
                </div>

                <div class="terminal-footer">
                    <span class="footer-prompt">></span> ./vendor/bin/sail up -d
                </div>
            </div>

            <p class="page-footer">
                Made with <span class="heart">&lt;3</span> and a lot of <span class="coffee">coffee</span>
            </p>
        </main>
    </body>
</html>

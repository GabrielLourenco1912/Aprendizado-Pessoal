<?php

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Projeto Pessoal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --bg: #0f172a;
            --card: #020617;
            --primary: #38bdf8;
            --text: #e5e7eb;
            --muted: #94a3b8;
            --border: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #020617, #0f172a);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .container {
            max-width: 900px;
            width: 100%;
        }

        header {
            margin-bottom: 32px;
        }

        header h1 {
            font-size: 2.2rem;
            margin-bottom: 8px;
            color: white;
        }

        header p {
            color: var(--muted);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: linear-gradient(180deg, var(--card), #020617);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            text-decoration: none;
            color: var(--text);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(56,189,248,0.15), transparent 60%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-4px);
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(56,189,248,0.15);
        }

        .card h2 {
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .card p {
            font-size: 0.95rem;
            color: var(--muted);
        }

        footer {
            margin-top: 40px;
            text-align: center;
            font-size: 0.85rem;
            color: var(--muted);
        }
    </style>
</head>
<body>

<div class="container">

    <header>
        <h1>Projeto Pessoal</h1>
        <p>Página inicial • Acesso rápido aos módulos do sistema</p>
    </header>

    <main class="grid">
        <a href="/bd/schemaBuilder" class="card">
            <h2>Schema Builder</h2>
            <p>Definição da estrutura do banco de dados de forma visual e intuitiva.</p>
        </a>

    </main>

    <footer>
        © <?= date('Y') ?> • Projeto Pessoal
    </footer>
</div>

</body>
</html>

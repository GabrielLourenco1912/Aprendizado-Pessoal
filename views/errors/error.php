<?php
    /** @var $code
    * @var $message */
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro <?= $code ?></title>
    <style>
        :root { --bg-color: #f3f4f6; --card-bg: #ffffff; --text-primary: #1f2937; --text-secondary: #6b7280; --accent-color: #4f46e5; --accent-hover: #4338ca; --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--bg-color); height: 100vh; display: flex; align-items: center; justify-content: center; color: var(--text-primary); }
        .error-container { text-align: center; background: var(--card-bg); padding: 3rem; border-radius: 1rem; box-shadow: var(--shadow); max-width: 480px; width: 90%; position: relative; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); }
        .error-code-bg { font-size: 10rem; font-weight: 900; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #f3f4f6; z-index: 0; user-select: none; letter-spacing: -0.05em; }
        .content { position: relative; z-index: 1; }
        .error-title { font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: var(--text-primary); letter-spacing: -0.025em; }
        .error-message { font-size: 1.1rem; color: var(--text-secondary); margin-bottom: 2rem; line-height: 1.6; }
        .btn-home { display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.5rem; background-color: var(--accent-color); color: white; text-decoration: none; font-weight: 600; border-radius: 0.5rem; transition: all 0.2s ease; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2); }
        .btn-home:hover { background-color: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 6px 8px -1px rgba(79, 70, 229, 0.3); }
        .btn-home:active { transform: translateY(0); }
        .icon-container { margin-bottom: 1.5rem; font-size: 3rem; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
    </style>
</head>
<body>
<div class="error-container">
    <div class="error-code-bg"><?= $code ?></div>
    <div class="content">
        <div class="icon-container">
            <?php if($code == 404): ?>👻<?php elseif($code >= 500): ?>🔧<?php else: ?>⚠️<?php endif; ?>
        </div>
        <h1 class="error-title">
            <?php
            if ($code == 404) echo "Página não encontrada";
            elseif ($code == 403) echo "Acesso Negado";
            elseif ($code == 500) echo "Erro Interno";
            else echo "Ocorreu um erro";
            ?>
        </h1>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
        <a href="/" class="btn-home">Voltar ao Início</a>
    </div>
</div>
</body>
</html>
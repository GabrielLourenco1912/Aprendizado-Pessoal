<?php

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Postgres Builder | Projeto Pessoal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --bg: #0b1220;
            --surface: #0f172a;
            --card: #111827;

            --primary: #4ea1ff;
            --primary-soft: rgba(78,161,255,0.15);
            --danger: #ef4444;

            --text: #e5e7eb;
            --muted: #9ca3af;
            --border: rgba(255,255,255,0.08);
            --input-bg: rgba(255,255,255,0.03);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Inter, system-ui, -apple-system, sans-serif; }

        body {
            min-height: 100vh;
            background:
                    radial-gradient(800px circle at 50% -20%, rgba(78,161,255,0.1), transparent 40%),
                    linear-gradient(160deg, #020617, var(--bg));
            color: var(--text);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 48px 24px;
        }

        .container { max-width: 1200px; width: 100%; }

        /* Back Link */
        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--muted); text-decoration: none; font-size: 0.9rem;
            margin-bottom: 28px; transition: color .2s ease;
        }
        .back-link:hover { color: var(--primary); transform: translateX(-4px); }

        /* Header */
        header { margin-bottom: 40px; }
        header h1 {
            font-size: 2.2rem; font-weight: 700; letter-spacing: -0.03em;
            margin-bottom: 8px; display: flex; align-items: center; gap: 12px;
            text-shadow: 0 0 40px rgba(78,161,255,0.2);
        }
        header p { color: var(--muted); font-size: 1rem; }

        /* Cards & Containers */
        .card {
            background: linear-gradient(180deg, var(--card), var(--surface));
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.05);
            border: 1px solid var(--border);
        }

        /* Form Elements */
        label { display: block; margin-bottom: 8px; font-weight: 500; color: #c7d2fe; font-size: 0.85rem; }
        .form-group { margin-bottom: 0; }

        input[type="text"], select {
            width: 100%; padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 10px; color: var(--text);
            font-size: 0.9rem; outline: none; transition: all .2s ease;
        }
        input::placeholder { color: #4b5563; }

        input:focus, select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-soft);
            background: rgba(255,255,255,0.06);
        }

        select option, select optgroup {
            background-color: #111827;
            color: var(--text);
        }

        /* --- Custom Grid Table --- */
        .columns-container {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border);
            background: rgba(17, 24, 39, 0.6); /* Transparência sutil */
            backdrop-filter: blur(10px);
        }

        .col-header {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1fr 2.5fr 48px;
            gap: 16px; padding: 16px 20px;
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em;
            color: var(--muted); background: rgba(255,255,255,0.02);
            border-bottom: 1px solid var(--border);
        }

        .col-row {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1fr 2.5fr 48px;
            gap: 16px; padding: 20px;
            border-bottom: 1px solid var(--border);
            align-items: start;
            animation: fadeIn 0.3s ease;
            transition: background 0.2s;
        }
        .col-row:hover { background: rgba(255,255,255,0.01); }
        .col-row:last-child { border-bottom: none; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

        /* Checkboxes & FK */
        .checkbox-group { display: flex; flex-direction: column; gap: 10px; }

        .custom-check {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.8rem; color: var(--muted); cursor: pointer; transition: color 0.2s;
        }
        .custom-check:hover { color: var(--text); }
        .custom-check input {
            accent-color: var(--primary);
            width: 14px; height: 14px; cursor: pointer;
        }

        .fk-details {
            display: none; grid-template-columns: 1fr 1fr; gap: 8px;
            margin-top: 6px; padding-top: 10px;
            border-top: 1px dashed var(--border);
            animation: slideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .fk-details.active { display: grid; }

        .fk-details input { font-size: 0.8rem; padding: 8px 12px; }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }

        /* Buttons */
        .btn {
            border-radius: 10px; font-weight: 600; cursor: pointer;
            border: none; padding: 12px 24px; transition: all 0.2s ease;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            color: #ffffff;
            box-shadow: 0 10px 20px rgba(78,161,255,0.25);
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .btn-primary:hover { filter: brightness(1.1); transform: translateY(-1px); }

        .btn-outline {
            background: transparent; border: 1px solid var(--border); color: var(--text);
        }
        .btn-outline:hover {
            border-color: var(--primary); color: var(--primary);
            box-shadow: inset 0 0 0 1px var(--primary-soft);
        }

        .btn-danger {
            width: 36px; height: 36px; padding: 0; /* Círculo/Quadrado para o ícone */
            background: transparent; border: 1px solid rgba(239,68,68,0.3); color: #f87171;
            border-radius: 8px;
        }
        .btn-danger:hover { background: var(--danger); color: white; border-color: var(--danger); }

        /* Debug */
        .debug-card {
            background: #0f172a; border: 1px solid #1e293b; border-left: 4px solid var(--primary);
            padding: 20px; margin-bottom: 30px; border-radius: 12px; font-family: monospace; overflow-x: auto;
        }
        .debug-header { color: var(--primary); font-weight: bold; margin-bottom: 8px; }

        footer { margin-top: 60px; text-align: center; color: var(--muted); font-size: 0.85rem; }

        @media (max-width: 900px) {
            .col-header { display: none; }
            .col-row {
                grid-template-columns: 1fr; gap: 12px;
                background: rgba(255,255,255,0.02); margin-bottom: 12px;
                border-radius: 12px; border: 1px solid var(--border);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="/" class="back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
        Voltar para Home
    </a>

    <header>
        <h1>🐘 Postgres Builder</h1>
        <p>Definição de schemas para ambiente PostgreSQL.</p>
    </header>

    <form method="POST" action="/bd/schemaBuilder">
        <div class="card">
            <div class="form-group">
                <label for="tableName">NOME DA TABELA </label>
                <input type="text" id="tableName" name="table_name" placeholder="Ex: pedidos_compra" required style="font-size: 1.1rem; padding: 16px;">
            </div>
        </div>

        <div class="columns-container">
            <div class="col-header">
                <div>Coluna</div>
                <div>Tipo (PG)</div>
                <div>Tamanho</div>
                <div>Configurações</div>
                <div style="text-align: center;">🗑️</div>
            </div>

            <div id="columnsBody">
            </div>
        </div>

        <div style="padding: 16px; background: rgba(0,0,0,0.2); border: 1px solid var(--border); border-top: none; border-radius: 0 0 14px 14px; margin-bottom: 24px;">
            <button type="button" class="btn btn-outline" style="width: 100%;" onclick="addColumn()">
                + Adicionar Nova Coluna
            </button>
        </div>

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 16px 40px; font-size: 1.1rem;">
                Gerar Tabela SQL
            </button>
        </div>
    </form>

    <footer>© <?= date('Y') ?> • Sistema de Automação Postgres</footer>
</div>

<script>

    function blockPrimaryOptions() {

        const rows = document.querySelectorAll('.col-row');

        function updatePrimaryOptions() {
            let primaryEmUso = false;

            rows.forEach(row => {
                const select = row.querySelector('select[name*="[key]"]');
                if (select.value === 'PRIMARY') {
                    primaryEmUso = true;
                }
            });

            rows.forEach(row => {
                const select = row.querySelector('select[name*="[key]"]');
                const optionPrimary = select.querySelector('option[value="PRIMARY"]');

                if (!optionPrimary) return;

                if (primaryEmUso && select.value !== 'PRIMARY') {
                    optionPrimary.disabled = true;
                } else {
                    optionPrimary.disabled = false;
                }
            });
        }

        rows.forEach(row => {
            const select = row.querySelector('select[name*="[key]"]');
            select.addEventListener('change', updatePrimaryOptions);
        });

        updatePrimaryOptions();
    }

    function addColumn() {
        const container = document.getElementById('columnsBody');
        const index = container.children.length;

        const row = document.createElement('div');
        row.className = 'col-row';

        row.innerHTML = `
            <div>
                <input type="text" name="columns[${index}][name]" placeholder="Ex: id, user_id" required>
            </div>
            <div>
                <select name="columns[${index}][type]">
                    <optgroup label="Numéricos">
                        <option value="INTEGER">INTEGER (4b)</option>
                        <option value="BIGINT">BIGINT (8b)</option>
                        <option value="DECIMAL">DECIMAL</option>
                        <option value="SMALLINT">SMALLINT</option>
                    </optgroup>
                    <optgroup label="Texto">
                        <option value="VARCHAR">VARCHAR</option>
                        <option value="TEXT" selected>TEXT (Padrão PG)</option>
                        <option value="CHAR">CHAR</option>
                    </optgroup>
                    <optgroup label="Avançados">
                        <option value="BOOLEAN">BOOLEAN</option>
                        <option value="JSONB">JSONB</option>
                        <option value="UUID">UUID</option>
                    </optgroup>
                    <optgroup label="Data/Hora">
                        <option value="TIMESTAMP">TIMESTAMP</option>
                        <option value="TIMESTAMPTZ">TIMESTAMPTZ (Zone)</option>
                        <option value="DATE">DATE</option>
                    </optgroup>
                </select>
            </div>
            <div>
                <input type="text" name="columns[${index}][length]" placeholder="Opcional">
            </div>

            <div class="checkbox-group">
                <div style="display: flex; gap: 16px;">
                    <label class="custom-check" title="GENERATED ALWAYS AS IDENTITY">
                        <input type="checkbox" name="columns[${index}][ai]" value="1">
                        Identity
                    </label>
                    <label class="custom-check">
                        <input type="checkbox" name="columns[${index}][not_null]" value="1" checked>
                        Not Null
                    </label>
                </div>

                <select name="columns[${index}][key]" onchange="toggleFK(this)" style="padding: 8px;">
                    <option value="">-- Sem Índice --</option>
                    <option value="PRIMARY">PRIMARY KEY</option>
                    <option value="UNIQUE">UNIQUE</option>
                    <option value="INDEX">INDEX</option>
                    <option value="FOREIGN">FOREIGN KEY</option>
                </select>

                <div class="fk-details">
                    <input type="text" name="columns[${index}][fk_table]" placeholder="Tabela Ref." class="fk-input">
                    <input type="text" name="columns[${index}][fk_column]" placeholder="Coluna Ref." class="fk-input">
                </div>
            </div>

            <div style="text-align: center;">
                <button type="button" class="btn btn-danger" onclick="removeRow(this)" title="Remover coluna">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>
            </div>
        `;

        container.appendChild(row);

        blockPrimaryOptions()
    }

    function toggleFK(selectElement) {
        const row = selectElement.closest('.col-row');

        const notNullCheckbox = row.querySelector('input[name*="[not_null]"]');

        const aiCheckbox = row.querySelector('input[name*="[ai]"]');

        const fkDetails = row.querySelector('.fk-details');

        const valor = selectElement.value;

        if (valor === 'PRIMARY') {
            notNullCheckbox.checked = true;

            notNullCheckbox.onclick = function() { return false; };

            notNullCheckbox.style.opacity = "0.5";
            notNullCheckbox.style.cursor = "not-allowed";
            notNullCheckbox.parentNode.title = "Obrigatório para chaves Primárias e Estrangeiras";
        } else if (valor === 'FOREIGN') {
            notNullCheckbox.checked = true;

            aiCheckbox.checked = false;

            notNullCheckbox.onclick = function() { return false; };

            aiCheckbox.onclick = function() { return false; };

            notNullCheckbox.style.opacity = "0.5";
            notNullCheckbox.style.cursor = "not-allowed";
            notNullCheckbox.parentNode.title = "Obrigatório para chaves Primárias e Estrangeiras";

            aiCheckbox.style.opacity = "0.5";
            aiCheckbox.style.cursor = "not-allowed";
            aiCheckbox.parentNode.title = "Obrigatóriamente desabilitado para chaves strangeiras";
        } else {
            notNullCheckbox.onclick = null;

            notNullCheckbox.style.opacity = "1";
            notNullCheckbox.style.cursor = "pointer";
            notNullCheckbox.parentNode.title = "";

            aiCheckbox.onclick = null;

            aiCheckbox.style.opacity = "1";
            aiCheckbox.style.cursor = "pointer";
            aiCheckbox.parentNode.title = "";
        }

        if (valor === 'FOREIGN') {
            fkDetails.style.display = 'block';
            row.querySelector('.fk-input').focus();
        } else {
            fkDetails.style.display = 'none';
            row.querySelectorAll('.fk-input').forEach(input => input.value = '');
        }
    }

    function removeRow(btn) {
        btn.closest('.col-row').remove();
        blockPrimaryOptions()
    }

    window.onload = () => addColumn();
</script>

</body>
</html>
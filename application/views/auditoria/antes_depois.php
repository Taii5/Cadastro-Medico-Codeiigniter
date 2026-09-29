<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Auditoria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h1 class="mb-4">
            Histórico de Auditoria
        </h1>

        <div class="mb-3">
            <a
                href="<?= site_url('medicos'); ?>"
                class="btn btn-secondary"
            >
                Voltar para médicos
            </a>
        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-striped table-hover align-middle">

                <thead class="table-light">

                    <tr>
                        <th>Ação</th>
                        <th>Médico</th>
                        <th>Data e hora</th>
                        <th>Dados antes</th>
                        <th>Dados depois</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (empty($auditorias)): ?>

                        <tr>
                            <td colspan="5" class="text-center">
                                Nenhum registro de auditoria encontrado.
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($auditorias as $auditoria): ?>

                            <tr>

                                <td>
                                    <?= html_escape($auditoria->acao); ?>
                                </td>

                                <td>
                                    <?= html_escape(
                                        $auditoria->nome_completo
                                            ? $auditoria->nome_completo
                                            : 'Médico excluído'
                                    ); ?>
                                </td>

                                <td>
                                    <?= html_escape($auditoria->data_hora); ?>
                                </td>

                                <td>
                                    <pre class="mb-0"><?= html_escape(
                                        $auditoria->dados_antes
                                    ); ?></pre>
                                </td>

                                <td>
                                    <pre class="mb-0"><?= html_escape(
                                        $auditoria->dados_depois
                                    ); ?></pre>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>

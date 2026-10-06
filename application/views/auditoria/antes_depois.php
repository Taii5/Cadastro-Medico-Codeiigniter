<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Auditoria</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #f5f6f8;
        }

        .pagina {
            max-width: 1400px;
            margin: 0 auto;
        }

        .cabecalho {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .cabecalho h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #212529;
        }

        .cabecalho p {
            margin: 0;
            color: #6c757d;
        }

        .card-auditoria {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-size: 14px;
            font-weight: 600;
            padding: 16px;
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .nome-medico {
            font-weight: 600;
            color: #212529;
        }

        .data-hora {
            color: #6c757d;
            font-size: 14px;
            white-space: nowrap;
        }

        .badge-acao {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .acao-criar {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .acao-editar {
            background-color: #fff3cd;
            color: #664d03;
        }

        .acao-excluir {
            background-color: #f8d7da;
            color: #842029;
        }

        .acao-outro {
            background-color: #e2e3e5;
            color: #41464b;
        }

        .dados {
            min-width: 300px;
            max-width: 450px;
        }

        .dados-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 12px;
            max-height: 220px;
            overflow-y: auto;
        }

        .dados-antes {
            border-left: 4px solid #dc3545;
        }

        .dados-depois {
            border-left: 4px solid #198754;
        }

        .titulo-dados {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .titulo-antes {
            color: #dc3545;
        }

        .titulo-depois {
            color: #198754;
        }

        pre {
            margin: 0;
            white-space: pre-wrap;
            word-break: break-word;
            font-size: 12px;
            color: #495057;
            font-family: monospace;
        }

        .vazio {
            padding: 50px !important;
            color: #6c757d;
        }

    </style>

</head>


<body>


<div class="container-fluid py-4">

    <div class="pagina">


        <!-- CABEÇALHO -->

        <div class="cabecalho">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h1>
                        Histórico de Auditoria
                    </h1>

                    <p>
                        Registro das alterações realizadas no cadastro de médicos.
                    </p>

                </div>


                <a
                    href="<?= site_url('medicos'); ?>"
                    class="btn btn-primary"
                >
                    ← Voltar 
                </a>

            </div>

        </div>


        <!-- TABELA -->

        <div class="card-auditoria">

            <div class="table-responsive">

                <table class="table align-middle">


                    <thead>

                        <tr>

                            <th>
                                Ação
                            </th>

                            <th>
                                Médico
                            </th>

                            <th>
                                Data e hora
                            </th>

                            <th>
                                Dados antes
                            </th>

                            <th>
                                Dados depois
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if (empty($auditorias)): ?>


                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center vazio"
                                >

                                    Nenhum registro de auditoria encontrado.

                                </td>

                            </tr>


                        <?php else: ?>


                            <?php foreach ($auditorias as $auditoria): ?>


                                <tr>


                                    <!-- AÇÃO -->

                                    <td>

                                        <?php if ($auditoria->acao == 'criar'): ?>

                                            <span class="badge-acao acao-criar">
                                                CRIAR
                                            </span>

                                        <?php elseif ($auditoria->acao == 'editar'): ?>

                                            <span class="badge-acao acao-editar">
                                                EDITAR
                                            </span>

                                        <?php elseif ($auditoria->acao == 'excluir'): ?>

                                            <span class="badge-acao acao-excluir">
                                                EXCLUIR
                                            </span>

                                        <?php else: ?>

                                            <span class="badge-acao acao-outro">
                                                <?= html_escape(
                                                    strtoupper($auditoria->acao)
                                                ); ?>
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- MÉDICO -->

                                    <td>

                                        <span class="nome-medico">

                                            <?= html_escape(
                                                !empty($auditoria->nome_completo)
                                                    ? $auditoria->nome_completo
                                                    : 'Médico excluído'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- DATA -->

                                    <td>

                                        <span class="data-hora">

                                            <?= !empty($auditoria->data_hora)
                                                ? date(
                                                    'd/m/Y H:i:s',
                                                    strtotime(
                                                        $auditoria->data_hora
                                                    )
                                                )
                                                : 'Data não informada'; ?>

                                        </span>

                                    </td>


                                    <!-- DADOS ANTES -->

                                    <td class="dados">

                                        <div class="dados-box dados-antes">

                                            <div class="titulo-dados titulo-antes">
                                                ANTES
                                            </div>

                                            <?php if (!empty($auditoria->dados_antes)): ?>

                                                <pre><?= html_escape(
                                                    json_encode(
                                                        json_decode(
                                                            $auditoria->dados_antes
                                                        ),
                                                        JSON_PRETTY_PRINT |
                                                        JSON_UNESCAPED_UNICODE
                                                    )
                                                ); ?></pre>

                                            <?php else: ?>

                                                <span class="text-muted">
                                                    Nenhum dado anterior.
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </td>


                                    <!-- DADOS DEPOIS -->

                                    <td class="dados">

                                        <div class="dados-box dados-depois">

                                            <div class="titulo-dados titulo-depois">
                                                DEPOIS
                                            </div>

                                            <?php if (!empty($auditoria->dados_depois)): ?>

                                                <pre><?= html_escape(
                                                    json_encode(
                                                        json_decode(
                                                            $auditoria->dados_depois
                                                        ),
                                                        JSON_PRETTY_PRINT |
                                                        JSON_UNESCAPED_UNICODE
                                                    )
                                                ); ?></pre>

                                            <?php else: ?>

                                                <span class="text-muted">
                                                    Nenhum dado posterior.
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </td>


                                </tr>


                            <?php endforeach; ?>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </div>


    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>
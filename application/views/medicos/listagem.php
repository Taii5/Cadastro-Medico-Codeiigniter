<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Médicos</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background-color: #f4f6f9;
        }

        .nome-medico {
    text-transform: uppercase;
}
        .navbar {
            background-color: #0d6efd;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #eee;
            padding: 20px;
            border-radius: 15px 15px 0 0 !important;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #0d6efd;
            color: white;
            border: none;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn {
            border-radius: 8px;
        }

        .btn-sm {
            padding: 5px 10px;
        }

        .form-control {
            border-radius: 8px;
        }

        .badge-especialidade {
            background-color: #e7f1ff;
            color: #0d6efd;
            padding: 7px 10px;
            border-radius: 20px;
            font-weight: 500;
        }

        .email {
            color: #555;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark mb-4">
    <div class="container">

        <span class="navbar-brand fw-bold">
            Cadastro de Médicos
        </span>

        <a
            href="<?= site_url('auditoria'); ?>"
            class="btn btn-light btn-sm"
        >
            Auditoria
        </a>

    </div>
</nav>

<div class="container">

    <?php if ($this->session->flashdata('sucesso')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('sucesso'); ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>
                    <h3 class="mb-1">Médicos cadastrados</h3>

                    <p class="text-muted mb-0">
                        Consulte, edite ou exclua os médicos cadastrados.
                    </p>
                </div>

                <a
                    href="<?= site_url('medicos/novo'); ?>"
                    class="btn btn-primary"
                >
                    + Novo médico
                </a>

            </div>

            <form
                method="get"
                action="<?= site_url('medicos'); ?>"
            >

                <div class="input-group">
            <input
                type="text"
                name="busca"
                class="form-control"
                placeholder="Pesquisar por Nome ou CRM"
                value="<?= isset($busca) ? $busca : ''; ?>"
                oninput="this.value = this.value.toUpperCase();"
            >

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Pesquisar
                    </button>

                    <?php if ($this->input->get('busca')): ?>

                        <a
                            href="<?= site_url('medicos'); ?>"
                            class="btn btn-outline-secondary"
                        >
                            Limpar
                        </a>

                    <?php endif; ?>

                </div>

            </form>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CRM</th>
                            <th>Especialidade</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($medicos)): ?>

                            <?php foreach ($medicos as $medico): ?>

                                <tr>

                                   <td class="nome-medico">
    <?= html_escape($medico->nome_completo); ?>
</td>

                                    <td>
                                        <?= html_escape($medico->crm); ?>
                                    </td>

                                    <td>
                                        <span class="badge-especialidade">
                                            <?= html_escape($medico->especialidade); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= html_escape($medico->telefone); ?>
                                    </td>

                                    <td class="email">
                                        <?= html_escape($medico->email); ?>
                                    </td>

                                    <td class="text-center">

                                        <a
                                            href="<?= site_url('medicos/editar/' . $medico->id); ?>"
                                            class="btn btn-warning btn-sm"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="<?= site_url('medicos/excluir/' . $medico->id); ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tem certeza que deseja excluir este médico?');"
                                        >
                                            Excluir
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td
                                    colspan="6"
                                    class="text-center py-5"
                                >
                                    <h5 class="text-muted">
                                        Nenhum médico encontrado.
                                    </h5>

                                    <p class="text-muted mb-0">
                                        Cadastre um novo médico ou tente outra pesquisa.
                                    </p>
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $medico ? 'Editar Médico' : 'Cadastrar Médico' ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- 1. Carregar a biblioteca principal do jQuery primeiro -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- 2. Depois carregar o plugin de máscara -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <span class="navbar-brand">
            Cadastro de Médicos
        </span>
    </div>
</nav>

<div class="container">

    <div class="card mx-auto" style="max-width: 800px;">

        <div class="card-body p-4">

            <h3 class="mb-4">
                <?= $medico ? 'Editar médico' : 'Cadastrar médico' ?>
            </h3>

            <?php
                if ($medico) {
                    $action = site_url('medicos/atualizar/' . $medico->id);
                } else {
                    $action = site_url('medicos/salvar');
                }
            ?>

            <form method="post" action="<?= $action ?>">

                <!-- NOME -->
                <div class="mb-3">

                    <label class="form-label">
                        Nome completo *
                    </label>

                    <input
                        type="text"
                        name="nome_completo"
                        class="form-control <?= form_error('nome_completo') ? 'is-invalid' : '' ?>"
                        value="<?= $medico ? html_escape($medico->nome_completo) : set_value('nome_completo'); ?>"
                        placeholder = "Ex: Leandro Dias"
                    >

                     <?= form_error('nome_completo', '<div style="color:red;">', '</div>'); ?>

                </div>
<div class="mb-3">

    <label class="form-label">
        CPF *
    </label>

    <input
        type="text"
        name="cpf"
        id="cpf"
        class="form-control"
        placeholder="Digite seu CPF"
        maxlength="14"
        value="<?= $medico ? html_escape($medico->cpf) : set_value('cpf'); ?>"
    >

    <?= form_error('cpf', '<div style="color:red;">', '</div>'); ?>

</div>

                <!-- CRM E ESPECIALIDADE -->
                <div class="mb-3">

    <label class="form-label">
        CRM *
    </label>

    <input
        type="text"
        name="crm"
        class="form-control"
        placeholder="Digite seu CRM"
        value="<?= $medico ? html_escape($medico->crm) : set_value('crm'); ?>"
    >

    <?= form_error('crm', '<div style="color:red;">', '</div>'); ?>

</div>


                    <div class="mb-3">

                        <label class="form-label">
                            Especialidade *
                        </label>

                        <input
                            type="text"
                            name="especialidade"
                            class="form-control <?= form_error('especialidade') ? 'is-invalid' : '' ?>"
                            value="<?= $medico ? html_escape($medico->especialidade) : set_value('especialidade'); ?>"
                            placeholder = "Digite sua especialidade"
                        >

                        <?= form_error('especialidade', '<div style="color:red;">', '</div>'); ?>

                    </div>

                </div>


                <!-- TELEFONE -->
                
<div class="mb-3">

    <label class="form-label">
        Telefone *
    </label>

    <input
        type="text"
        name="telefone"
        id="telefone"
        class="form-control"
        placeholder="Digite seu telefone"
        value="<?= $medico ? html_escape($medico->telefone) : set_value('telefone'); ?>"
    >

    <?= form_error('telefone', '<div style="color:red;">', '</div>'); ?>

</div>


<!-- E-MAIL -->
<div class="mb-3">

    <label class="form-label">
        E-mail *
    </label>

    <input
        type="email"
        name="email"
        class="form-control"
        placeholder="Digite seu e-mail"
        value="<?= $medico ? html_escape($medico->email) : set_value('email'); ?>"
    >

    <?= form_error('email', '<div style="color:red;">', '</div>'); ?>

</div>

                <!-- BOTÕES -->
                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="<?= site_url('medicos'); ?>"
                        class="btn btn-secondary"
                    >
                        Voltar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <?= $medico ? 'Salvar alterações' : 'Cadastrar' ?>
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
    $(document).ready(function(){
        $('#telefone').mask('(00) 00000-0000');
        $('#cpf').mask('000.000.000-00');
    });
</script>

</body>
</html>
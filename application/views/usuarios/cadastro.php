<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cadastro de Usuário</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body class="bg-light">


<div class="container mt-5 mb-5">

    <div
        class="card mx-auto shadow-sm"
        style="max-width: 600px;"
    >

        <div class="card-body p-4">

            <h3 class="mb-1">
                Cadastro de Usuário
            </h3>

            <p class="text-muted mb-4">
                Preencha seus dados para acessar o sistema.
            </p>


            <?php if ($this->session->flashdata('erro')): ?>

                <div class="alert alert-danger">

                    <?= $this->session->flashdata('erro'); ?>

                </div>

            <?php endif; ?>


            <form
                method="post"
                action="<?= site_url('usuarios/salvar'); ?>"
            >


                <!-- NOME -->

                <div class="mb-3">

                    <label class="form-label">
                        Nome completo *
                    </label>

                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        value="<?= set_value('nome'); ?>"
                        placeholder="Digite seu nome completo"
                    >

                    <?= form_error(
                        'nome',
                        '<div class="text-danger small mt-1">',
                        '</div>'
                    ); ?>

                </div>


                <!-- CRM -->

                <div class="mb-3">

                    <label class="form-label">
                        CRM *
                    </label>

                    <input
                        type="text"
                        name="crm"
                        class="form-control"
                        value="<?= set_value('crm'); ?>"
                        placeholder="Digite seu CRM"
                        inputmode="numeric"
                    >

                    <?= form_error(
                        'crm',
                        '<div class="text-danger small mt-1">',
                        '</div>'
                    ); ?>

                </div>


                <!-- ESPECIALIDADE -->

                <div class="mb-3">

                    <label class="form-label">
                        Especialidade *
                    </label>

                    <input
                        type="text"
                        name="especialidade"
                        class="form-control"
                        value="<?= set_value('especialidade'); ?>"
                        placeholder="Digite sua especialidade"
                    >

                    <?= form_error(
                        'especialidade',
                        '<div class="text-danger small mt-1">',
                        '</div>'
                    ); ?>

                </div>


                <!-- TELEFONE -->

                <div class="mb-3">

                    <label class="form-label">
                        Telefone *
                    </label>

                    <input
                        type="text"
                        name="telefone"
                        class="form-control"
                        value="<?= set_value('telefone'); ?>"
                        placeholder="Digite seu telefone"
                        inputmode="numeric"
                        maxlength="11"
                    >

                    <?= form_error(
                        'telefone',
                        '<div class="text-danger small mt-1">',
                        '</div>'
                    ); ?>

                </div>


                <!-- EMAIL -->

                <div class="mb-3">

                    <label class="form-label">
                        E-mail *
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= set_value('email'); ?>"
                        placeholder="Digite seu e-mail"
                    >

                    <?= form_error(
                        'email',
                        '<div class="text-danger small mt-1">',
                        '</div>'
                    ); ?>

                </div>


                <!-- SENHA -->

                <div class="mb-3">

                    <label class="form-label">
                        Senha *
                    </label>

                    <input
                        type="password"
                        name="senha"
                        class="form-control"
                        placeholder="Digite sua senha"
                    >

                    <?= form_error(
                        'senha',
                        '<div class="text-danger small mt-1">',
                        '</div>'
                    ); ?>

                </div>


                <!-- CONFIRMAR SENHA -->

                <div class="mb-4">

                    <label class="form-label">
                        Confirmar senha *
                    </label>

                    <input
                        type="password"
                        name="confirmar_senha"
                        class="form-control"
                        placeholder="Confirme sua senha"
                    >

                    <?= form_error(
                        'confirmar_senha',
                        '<div class="text-danger small mt-1">',
                        '</div>'
                    ); ?>

                </div>


                <!-- BOTÕES -->

                <div class="d-flex justify-content-between">

                    <a
                        href="<?= site_url('auth'); ?>"
                        class="btn btn-secondary"
                    >
                        Voltar
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Cadastrar
                    </button>

                </div>


            </form>

        </div>

    </div>

</div>


</body>

</html>
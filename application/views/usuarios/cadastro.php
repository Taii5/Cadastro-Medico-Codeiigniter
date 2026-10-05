<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Usuário</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card mx-auto" style="max-width: 500px;">

        <div class="card-body p-4">

            <h3 class="mb-4">Cadastro de Usuário</h3>

            <form method="post" action="<?= site_url('usuarios/salvar'); ?>">

                <!-- NOME -->
                <div class="mb-3">

                    <label class="form-label">
                        Nome *
                    </label>

                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        value="<?= set_value('nome'); ?>"
                        placeholder = "Digite seu nome"
                    >

                    <?= form_error(
                        'nome',
                        '<div class="text-danger small">',
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
                        placeholder = "Digite seu e-mail"
                    >

                    <?= form_error(
                        'email',
                        '<div class="text-danger small">',
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
                        placeholder = "Digite sua senha"
                    >

                    <?= form_error(
                        'senha',
                        '<div class="text-danger small">',
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
                        placeholder = "******"
                    >

                    <?= form_error(
                        'confirmar_senha',
                        '<div class="text-danger small">',
                        '</div>'
                    ); ?>

                </div>

                <div class="d-flex justify-content-between">

                    <a href="<?= site_url('auth'); ?>"
                       class="btn btn-secondary">
                        Voltar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Cadastrar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>
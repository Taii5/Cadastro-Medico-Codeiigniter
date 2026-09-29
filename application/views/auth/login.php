<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistema de Médicos</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    
                    <h2 class="text-center mb-4">
                        Sistema de Médicos
                    </h2>

                    <h5 class="text-center mb-4">
                        Login
                    </h5>

                    <?php if (isset($erro)): ?>

                        <div class="alert alert-danger">
                            <?= html_escape($erro); ?>
                        </div>

                    <?php endif; ?>

                    <?= validation_errors(
                        '<div class="alert alert-danger">',
                        '</div>'
                    ); ?>

                    <form
                        method="post"
                        action="<?= site_url('auth/entrar'); ?>"
                    >

                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label"
                            >
                                E-mail
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= set_value('email'); ?>"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label
                                for="senha"
                                class="form-label"
                            >
                                Senha
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="senha"
                                name="senha"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Entrar
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>

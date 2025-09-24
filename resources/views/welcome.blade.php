<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MetricFlow</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
  
.container1 {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 120px;
    height: 450px;
}
</style>

<body>
<nav class="navbar navbar-expand-lg navbar-light  shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="">
            <img src="{{ asset('/img/logo.png') }}" alt="MetricFlowIMG" class="img-fluid rounded">
            <span class="fw-bold">MetricFlow</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            
            <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sessão</a>
        </div>
    </div>
</nav>

    <div class="container1">
        <div class="row align-items-center">
            <!-- Text -->
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="fw-bold">MetricFlow</h2>
                <h4 class="text-muted mb-3">Simplifique e Otimize Connosco</h4>
                <p class="text-secondary">
                    Analise de Produtividade
                </p>
                <a href="{{ route('login') }}" class="btn btn-primary">Comece Agora!</a>
            </div>
            <!-- Image -->
            <div class="col-md-6 text-center">
                <img src="{{ asset('/img/img.png') }}" alt="MetricFowIMG" class="img-fluid rounded">
            </div>
        </div>
    </div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php include 'includes/header.php'; ?>

<h2>Adicionar Novo Livro</h2>

<form action="actions/salvar_livro.php" method="POST" id="form-livro" enctype="multipart/form-data">
    <div class="form-group">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
    </div>
    <div class="form-group">
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor">
    </div>
    <div class="form-group">
        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero">
    </div>
    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Quero Ler" selected>Quero Ler</option>
            <option value="Lendo">Lendo</option>
            <option value="Lido">Lido</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="capa">Capa do Livro (Opcional):</label>
        <input type="file" id="capa" name="capa">
    </div>

    <button type="submit" class="btn btn-success">Salvar Livro</button>
</form>

<?php include 'includes/footer.php'; ?>
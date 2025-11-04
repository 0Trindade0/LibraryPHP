<?php
include 'includes/header.php';
include 'includes/conexao.php';

// SQL para selecionar todos os livros (sem alteração) [cite: 92, 93]
$sql = "SELECT * FROM livros ORDER BY titulo";
$stmt = $pdo->query($sql);
?>

<h2>Meus Livros</h2>

<?php
// Bloco de Alerta (sem alteração) [cite: 94-97]
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    if ($msg == 'sucesso') {
        echo "<div class='alert alert-success'>Livro salvo com sucesso!</div>";
    } else if ($msg == 'atualizado') {
        echo "<div class='alert alert-success'>Livro atualizado com sucesso!</div>";
    } else if ($msg == 'excluido') {
        echo "<div class='alert alert-danger'>Livro excluído com sucesso.</div>";
    }
}
?>

<div class="book-list">
    <?php
    if ($stmt->rowCount() > 0) {
        // O loop 'while' continua igual
        while ($livro = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <article class="book-item">
            
            <div class="book-cover-container">
                <?php if (!empty($livro['capa'])): ?>
                    <img src="<?php echo htmlspecialchars($livro['capa']); ?>" alt="Capa de <?php echo htmlspecialchars($livro['titulo']); ?>" class="capa-img">
                <?php else: //[cite: 103]?>
                    <div class="capa-placeholder">
                        <span class="placeholder-titulo"><?php echo htmlspecialchars($livro['titulo']); ?></span> <span class="placeholder-autor"><?php echo htmlspecialchars($livro['autor']); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="book-info-container">
                <div class="book-info-header">
                    <h3 class="book-title"><?php echo htmlspecialchars($livro['titulo']); ?></h3> <p class="book-author"><?php echo htmlspecialchars($livro['autor']); ?></p>
                </div>

                <div class="book-footer">
                    <div class="book-meta">
                        <span><strong>Gênero:</strong> <?php echo htmlspecialchars($livro['genero']); ?></span>
                        <span><strong>Status:</strong> <?php echo htmlspecialchars($livro['status']); ?></span> </div>
                    <div class="book-actions">
                        <a href="form_editar.php?id=<?php echo $livro['id']; ?>" class="btn btn-small btn-primary">Editar</a>
                        <a href="actions/excluir_livro.php?id=<?php echo $livro['id']; ?>" class="btn btn-small btn-danger btn-excluir">Excluir</a> </div>
                </div>
            </div>
        </article>

    <?php
        } // Fim do loop while
    } else {
        // Se não houver livros, mostramos um <p> simples
        echo "<p>Nenhum livro cadastrado.</p>";
    }
    ?>
</div> <?php include 'includes/footer.php'; //[cite: 111]?>
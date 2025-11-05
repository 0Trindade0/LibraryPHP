// "Ouvinte" que espera todo o HTML da página carregar
// antes de executar qualquer JavaScript.
document.addEventListener("DOMContentLoaded", function() {

    // --- 1. VALIDAÇÃO DO FORMULÁRIO (Lado do Cliente) ---
    // Seleciona o formulário (só existe nas págs de cadastro/edição)
    const form = document.getElementById("form-livro");
    
    // Se o formulário existir nesta página...
    if (form) {
        // ...adiciona um "ouvinte" ao evento de 'submit' (envio)
        form.addEventListener("submit", function(event) {
            // Pega o campo de título
            const tituloInput = document.getElementById("titulo");
            
            // trim() remove espaços em branco do início e fim
            // Se o título estiver vazio...
            if (tituloInput.value.trim() === "") { 
                // ...mostra um alerta
                alert("O campo 'Título' é obrigatório.");
                // IMPEDE o envio do formulário para o PHP
                event.preventDefault(); 
                // Coloca o cursor do usuário de volta no campo
                tituloInput.focus(); 
            }
        });
    }

    // --- 2. CONFIRMAÇÃO DE EXCLUSÃO ---
    // Seleciona TODOS os botões com a classe ".btn-excluir"
    const linksExcluir = document.querySelectorAll(".btn-excluir");
    
    // Para cada botão de exclusão encontrado...
    linksExcluir.forEach(function(link) {
        // ...adiciona um "ouvinte" de clique
        link.addEventListener("click", function(event) {
            
            // Mostra a caixa de diálogo "OK/Cancelar" do navegador
            const confirmou = confirm("Tem certeza que deseja excluir este livro?");
            
            // Se o usuário clicou em "Cancelar" (!confirmou)
            if (!confirmou) {
                // IMPEDE a ação do link (o clique é cancelado)
                event.preventDefault();
            }
            // Se ele clicou "OK", o script não faz nada e
            // o link funciona normalmente, levando para o excluir_livro.php
        });
    });

});
// Espera o DOM carregar para executar o script
document.addEventListener("DOMContentLoaded", function() {

    // --- 1. Validação do Formulário ---
    const form = document.getElementById("form-livro");
    
    if (form) {
        form.addEventListener("submit", function(event) {
            const tituloInput = document.getElementById("titulo");
            
            // trim() remove espaços em branco do início e fim
            if (tituloInput.value.trim() === "") { 
                alert("O campo 'Título' é obrigatório.");
                event.preventDefault(); // Impede o envio do formulário
                tituloInput.focus(); // Foca no campo
            }
        });
    }

    // --- 2. Confirmação de Exclusão --- [cite: 63]
    const linksExcluir = document.querySelectorAll(".btn-excluir");
    
    linksExcluir.forEach(function(link) { 
        link.addEventListener("click", function(event) {
            // Pergunta ao usuário se ele tem certeza
            const confirmou = confirm("Tem certeza que deseja excluir este livro?");
            
            if (!confirmou) {
                event.preventDefault(); // Cancela a ação (não segue o link) [cite: 65]
            }
        });
    });

});

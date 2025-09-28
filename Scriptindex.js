// Redireciona quando clicar em SIM
document.getElementById("btnSim").addEventListener("click", function () {
    window.location.href = "lugar.html";
});

// Faz o botão NÃO se mover para lugar aleatório
document.getElementById("btnNao").addEventListener("click", function () {
    const btnNao = document.getElementById("btnNao");

    // Pega largura e altura da tela
    const larguraTela = window.innerWidth - btnNao.offsetWidth;
    const alturaTela = window.innerHeight - btnNao.offsetHeight;

    // Gera posição aleatória
    const novaPosX = Math.floor(Math.random() * larguraTela);
    const novaPosY = Math.floor(Math.random() * alturaTela);

    // Aplica no botão
    btnNao.style.left = novaPosX + "px";
    btnNao.style.top = novaPosY + "px";
});
// Selecionar o formulário
const form = document.querySelector('form');

// Escutar o evento de envio do formulário
form.addEventListener('submit', async function(event) {
  event.preventDefault(); // Evita o comportamento padrão de recarregar a página
  
  // Captura os dados do formulário
  const formData = new FormData(form); // Cria um objeto FormData com os dados do formulário
  
  try {
    // Faz a requisição POST para o arquivo backend.php
    const response = await fetch('backend.php', {
      method: 'POST',
      body: formData
    });

    // Verifica se a resposta foi bem-sucedida
    if (!response.ok) {
      throw new Error(`Erro na requisição: ${response.statusText}`);
    }

    const result = await response.json(); // Converte a resposta para JSON

    // Exibe a mensagem de sucesso ou erro
    if (result.success) {
      alert('Formulário enviado com sucesso!');
      form.reset(); // Limpa o formulário
    } else {
      alert(`Erro: ${result.message}`);
    }
  } catch (error) {
    alert(`Erro no envio do formulário: ${error.message}`);
  }
});

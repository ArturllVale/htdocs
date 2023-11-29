// Seletor para alternar entre os modos sandbox e produção
var modoSandbox = true; // Altere para false para o modo de produção

// URL do PagSeguro
var url = modoSandbox ? 'https://sandbox.pagseguro.uol.com.br' : 'https://pagseguro.uol.com.br';

// Solicita o ID da sessão ao servidor
fetch('getSession.php')
    .then(response => response.text())
    .then(sessionId => {
        // Configura a sessão do PagSeguro
        PagSeguroDirectPayment.setSessionId(sessionId);

        // Formulário para realizar o pagamento
        var form = document.getElementById('form-pagamento');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var quantidade = document.getElementById('quantidade').value;
            var valor = 10 * quantidade; // O preço do "cash_coin" é 10 reais

            // Obtém a bandeira do cartão
            PagSeguroDirectPayment.getBrand({
                cardBin: document.getElementById('num-cartao').value.substring(0, 6),
                success: function(response) {
                    var bandeira = response.brand.name;

                    PagSeguroDirectPayment.createCardToken({
                        cardNumber: document.getElementById('num-cartao').value,
                        brand: bandeira,
                        cvv: document.getElementById('cvv').value,
                        expirationMonth: document.getElementById('mes').value,
                        expirationYear: document.getElementById('ano').value,
                        success: function(response) {
                            // Aqui você pode enviar o token do cartão para o seu servidor e realizar o pagamento
                            console.log(response.card.token);
                        },
                        error: function(response) {
                            // Tratamento do erro
                            console.error(response);
                        },
                        complete: function(response) {
                            // Callback para todas chamadas.
                        }
                    });
                },
                error: function(response) {
                    // Tratamento do erro
                    console.error(response);
                },
                complete: function(response) {
                    // Callback para todas chamadas.
                }
            });
        });
    });
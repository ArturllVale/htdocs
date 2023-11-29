<!DOCTYPE html>
<html>
<head>
    <title>Pagamento PagSeguro</title>
    <script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
</head>
<body>
    <form id="form-pagamento">
        <label for="quantidade">Quantidade de cash_coin:</label>
        <input type="number" id="quantidade" name="quantidade" min="1" required>
        <br>
        <label for="num-cartao">Número do cartão:</label>
        <input type="text" id="num-cartao" name="num-cartao" required>
        <br>
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>
        <br>
        <label for="mes">Mês de expiração:</label>
        <input type="text" id="mes" name="mes" required>
        <br>
        <label for="ano">Ano de expiração:</label>
        <input type="text" id="ano" name="ano" required>
        <br>
        <input type="submit" value="Pagar">
    </form>

    <script src="function.js"></script>
</body>
</html>

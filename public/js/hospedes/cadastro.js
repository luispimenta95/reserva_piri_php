var limit = 4;
var count = 1;

adicionarLinha();
removerLinha();

function adicionarLinha() {
    if (count == 1) {
        $(".deleteRow").prop("disabled", true);
    }
    $("thead").on("click", ".addRow", function () {
        count++;
        var linha =
            "<tr>" +
            "<td><input type='text' name='nome[]' class='form-control' required /></td>" +
            "<td><input type='date' name='nascimento[]' class='form-control' required /></td>" +
            "<td><input type='text' name='cpf[]' class='form-control' required/></td>" +
            "<td><input type='email' name='email[]' class='form-control' required/></td>" +
            "<td><input type='text' name='telefone[]' class='form-control' required/></td>" +
            "<td><a href='javascript:void(0)' class='btn btn-danger deleteRow'>Remover</a></td>" +
            "</tr>";
        $("tbody").append(linha);
        if (count == limit) {
            $(".addRow").hide();
        }
    });
}

function removerLinha() {
    $("tbody").on("click", ".deleteRow", function () {
        count--;
        $(this).parent().parent().remove();
        if (count < limit) {
            $(".addRow").show();
        }
    });
}

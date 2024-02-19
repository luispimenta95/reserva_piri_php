$(".loader").hide();

$(".download").click(function () {
    var id = $(this).attr("data-id");
    console.log(id);

    $.ajax({
        url: "/gerar-contrato/" + id,
        dataType: "json",
        data: { id: id },
        success: function (data) {
            console.log(data);
        },
    });
});

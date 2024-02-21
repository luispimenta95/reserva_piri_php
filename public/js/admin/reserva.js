$(".loader").hide();

$(".download").click(function () {
    var id = $(this).attr("data-id");
    console.log(id);

    $.ajax({
        url: "/gerar-contrato",
        dataType: "json",
        data: { id: id },
        success: function (response) {
            alert("Download completed successfully");
        },
    });
});
